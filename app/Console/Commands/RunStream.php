<?php

namespace App\Console\Commands;

use App\Jobs\RunStream as JobsRunStream;
use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class RunStream extends Command
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
        JobsRunStream::dispatch();
    }
}
