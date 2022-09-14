<?php

namespace App\Console\Commands;

use Alexsokolianskiy\ProcessManager\LinuxProcessManager;
use Illuminate\Console\Command;
use PhpParser\Node\Expr\ShellExec;
use Symfony\Component\Process\Process;

class FakeVideoDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:fake-device {numbers?*} {--video=99}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pm = new LinuxProcessManager();
        $ffmpemgPid = $pm->getPid('ffmpeg -stream_loop -1 -re');
        if ($ffmpemgPid) {
            $pm->kill($ffmpemgPid);
        }
        //remove previous virtual devices
        Process::fromShellCommandline('modprobe -r v4l2loopback')->run();
        $numbers = empty($this->argument('numbers')) ? ['99'] : $this->argument('numbers');
        $addV4lCmd = sprintf(
            'modprobe v4l2loopback video_nr=%s card_label="Fake Webcam" exclusive_caps=1',
            implode(',', array_map('intval', $numbers))
        );
        Process::fromShellCommandline($addV4lCmd)->run();

        //run static video as loopback
        $videoNumber = intval($this->option('video'));
        $ffmpegProcess = Process::fromShellCommandline(
            sprintf(
                'ffmpeg -stream_loop -1 -re -i %s -vcodec rawvideo -threads 0 -f v4l2 /dev/video%s',
                resource_path('videos/example.mp4'),
                $videoNumber
            )
        );

        $captureOutput = function ($type, $line) use (&$processOutput) {
            echo $line;
        };
        $ffmpegProcess->setTimeout(null)->run($captureOutput);

        return 0;
    }
}
