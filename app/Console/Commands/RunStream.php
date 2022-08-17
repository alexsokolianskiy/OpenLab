<?php

namespace App\Console\Commands;

use FFMpeg\FFMpeg;
use App\Models\Video;
use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use App\Services\Video\HLSStream;
use Illuminate\Support\Facades\Storage;
use App\Jobs\RunStream as JobsRunStream;
use Illuminate\Contracts\Queue\ShouldQueue;

class RunStream extends Command implements ShouldQueue
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:stream';

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
        $video = Video::find(1);
        $hlsStream = new HLSStream($video);
        try {
            $hlsStream->setPlayVideoStatus();
            $hlsStream->run();
        } catch (\Exception $e) {
            $hlsStream->setStopVideoStatus();
            throw $e;
        }
    }
}
