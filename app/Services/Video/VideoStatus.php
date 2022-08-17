<?php

namespace App\Services\Video;

enum VideoStatus: int {
    case STOPPED = 0;
    case RUNNING = 1;

}
