<?php

namespace App\Console\Commands;

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
    protected $signature = 'video:fake-device';

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
        $processAddDevice = Process::fromShellCommandline('modprobe v4l2loopback card_label="Fake Webcam" exclusive_caps=1');
        $processAddDevice->run();

        $ffmpegProcess = Process::fromShellCommandline(sprintf('ffmpeg -stream_loop -1 -re -i %s -vcodec rawvideo -threads 0 -f v4l2 /dev/video0', resource_path('videos/example.mp4') ));

        $captureOutput = function ($type, $line) use (&$processOutput) {
            echo $line;
        };
        $ffmpegProcess->setTimeout(null)->run($captureOutput);

        return 0;
    }
}
