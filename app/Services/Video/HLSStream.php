<?php

namespace App\Services\Video;

use Exception;
use FFMpeg\FFMpeg;
use Monolog\Logger;
use App\Models\Video;
use App\Services\Video\VideoType;
use Monolog\Handler\StreamHandler;
use App\Services\Video\StreamVideo;
use Illuminate\Support\Facades\Storage;
use App\Services\Video\Formatters\FFmpegFormatter;
use App\Services\Video\Formatters\HLSDeviceFormatter;
use App\Services\Video\Formatters\HLSNetworkFormatter;

class HLSStream extends StreamVideo
{
    protected ?FFmpegFormatter $formatter;
    public function __construct(Video $video)
    {
        parent::__construct($video);
        $this->formatter = $this->createFormatter();
    }

    public function createFormatter()
    {
        return match ((int) $this->video->type) {
            VideoType::NETWORK->value => new HLSNetworkFormatter(),
            VideoType::DEVICE->value => new HLSDeviceFormatter(),
            default => null
        };
    }

    public function run()
    {
        $videoLogger = $this->createLogger();
        $ffmpeg = FFMpeg::create(
            configuration: [
                'timeout' => 0
            ],
            logger: $videoLogger
        );
        if (!$this->formatter) {
            throw new Exception('no such input device/address');
        }
        $input = $this->formatter->open($this->video->source);
        $format = $this->formatter->format();
        $video = $ffmpeg->openAdvanced([$input]);
        $video->map(array('0:v'), $format, $this->getPlayListPath());
        try{
            $video->save();
        } catch (\Exception $e) {
            $videoLogger->error('Stream runner error', [$e->getCode(), $e->getMessage()]);
            throw $e;
        }
    }

    public function createLogger() : Logger
    {
        $videoLogger = new Logger('video-'.$this->video->id);
        $videoLogger->pushHandler(new StreamHandler(storage_path('logs/'. 'video-'.$this->video->id.'.log')), Logger::DEBUG);
        return $videoLogger;
    }

    public function getStreamUrl(): string
    {
        return asset(sprintf('storage/playlists/%s/%s.m3u8', $this->video->id, $this->video->id));
    }

    public function getPlayListPath(): string
    {
        Storage::disk('public')->makeDirectory(sprintf('/playlists/%s/', $this->video->id));
        return Storage::disk('public')->path(sprintf('/playlists/%s/%s.m3u8', $this->video->id, $this->video->id));
    }
}
