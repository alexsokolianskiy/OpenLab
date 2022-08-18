<?php

namespace App\Services\Video;

use ArchTech\Enums\Options;

enum VideoType: int {
    use Options;

    case DEVICE = 0;
    case NETWORK = 1;

}
