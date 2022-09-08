<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use App\Services\Video\HLSStream;
use Illuminate\Contracts\Queue\ShouldQueue;
use Alexsokolianskiy\ProcessManager\LinuxProcessManager;
use App\Services\Video\VideoStatus;

class RunStream extends Command implements ShouldQueue
{
    public $timeout = 0;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:stream {video}';
    private $video;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts stream with provided config';

    public function getCacheLockName(): string
    {
        return sprintf('run:stream [%s]', $this->video->id);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Video $video)
    {
        $pm = new LinuxProcessManager();
        pcntl_async_signals(true);
        pcntl_signal(SIGINT, [$this, 'shutdown']);
        pcntl_signal(SIGTERM, [$this, 'shutdown']);
        $id = (int) $this->arguments('video');
        $this->video = Video::find($id);
        $processPid = $pm->getPid(VideoStatus::getProcessName($this->video));
        if ($processPid) {
            echo "The command is already running\n";
            return 1;
        }
        $hlsStream = new HLSStream($this->video);
        try {
            $hlsStream->setPlayVideoStatus();
            $hlsStream->run();
        } catch (\Exception $e) {
            $hlsStream->setStopVideoStatus();
            throw $e;
        }
    }

    public function shutdown()
    {
        $hlsStream = new HLSStream($this->video);
        $hlsStream->setStopVideoStatus();
        return;
    }
}
