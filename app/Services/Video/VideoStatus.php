<?php

namespace App\Services\Video;

use App\Models\Video;

enum VideoStatus: int {
    case STOPPED = 0;
    case RUNNING = 1;

    public static function getProcessName(Video $video)
    {
        return sprintf('run:stream [%s]', $video->id);
    }

}
