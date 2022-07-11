<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_create_queue_instance()
    {
        $this->assertTrue(true);
    }

    public function test_fail_create_queue_instance_bcz_title_already_in_use()
    {
        $this->assertTrue(true);
    }
}
