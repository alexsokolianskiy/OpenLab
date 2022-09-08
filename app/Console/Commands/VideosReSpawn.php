<?php

namespace App\Console\Commands;

use App\Models\Video;
use Illuminate\Console\Command;
use App\Services\Video\VideoStatus;
use Alexsokolianskiy\ProcessManager\LinuxProcessManager;
use Exception;
use Illuminate\Support\Facades\Artisan;

class VideosReSpawn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:respawn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command manages streams that should be stopped/runned';

    public function cleanup(array $processesShouldExists)
    {
        $pm = new LinuxProcessManager();
        $pn = 'run:stream';
        $list = $pm->grep($pn);
        foreach ($list as $item) {
            if (in_array($item->command, $processesShouldExists)) {
                continue;
            }
            try {
                $pm->kill($item->pid);
            } catch (\Exception) {

            }
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pm = new LinuxProcessManager();
        $processesShouldExists = [];
        $videos = Video::get();
        foreach ($videos as $video) {
            $pn = VideoStatus::getProcessName($video);
            if ($video->status = VideoStatus::RUNNING->value) {
                $processesShouldExists[] = $pn;
                $pid = $pm->getPid($pn);
                if (!$pid) {
                    Artisan::call('run:stream', ['video' => $video->id]);
                }
            }
        }
        $this->cleanup($processesShouldExists);
    }
}
