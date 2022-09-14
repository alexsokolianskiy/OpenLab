<?php

namespace Tests;

use Symfony\Component\Process\Process;


trait WithFakeVideoDevice
{
    protected $fakeVideoDev;

    protected function fakeVideo()
    {
        return $this->fakeVideoDev ?? $this->runFakeVideo();
    }

    protected function runFakeVideo()
    {
        exec('php artisan video:fake-device 99 > /dev/null &');
        return $this->fakeVideoDev = '/dev/video99';
    }
}
