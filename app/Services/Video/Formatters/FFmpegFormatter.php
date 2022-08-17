<?php

namespace App\Services\Video\Formatters;

use FFMpeg\Format\FormatInterface;
use FFMpeg\Media\AdvancedMedia;

interface FFmpegFormatter
{
    public function format(): FormatInterface;
    public function open(string $source): ?string;
}
