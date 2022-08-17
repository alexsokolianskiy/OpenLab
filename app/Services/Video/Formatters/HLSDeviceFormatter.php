<?php

namespace App\Services\Video\Formatters;

use FFMpeg\Format\Video\X264;
use FFMpeg\Media\AdvancedMedia;
use FFMpeg\Format\FormatInterface;
use Illuminate\Support\Facades\Storage;
use App\Services\Video\Formatters\FFmpegFormatter;

class HLSDeviceFormatter implements FFmpegFormatter
{
    public function format() : FormatInterface {
        $format = new x264();
        $format->setAdditionalParameters([
            '-hls_list_size', '5',
            '-hls_flags', 'delete_segments'
        ]);
        return $format;
    }

    public function open(string $source) : ?string {
        $path = Storage::disk('system')->path($source);
        if (!Storage::disk('system')->readStream($path)) {
            return null;
        }

        return $path;

    }
}
