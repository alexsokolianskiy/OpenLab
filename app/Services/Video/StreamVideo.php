<?php

namespace App\Services\Video;

use App\Models\Video;


abstract class StreamVideo
{
    public function __construct(protected Video $video)
    {

    }

    abstract public function run();

    abstract public function getStreamUrl() : string;

    public function setPlayVideoStatus() {
        $this->video->status = VideoStatus::STOPPED->value;
        $this->video->save();
    }
    public function setStopVideoStatus()
    {
        $this->video->status = VideoStatus::RUNNING->value;
        $this->video->save();
    }
}
