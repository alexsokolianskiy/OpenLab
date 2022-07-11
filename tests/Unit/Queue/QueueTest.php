<?php

namespace Tests\Unit\Queue;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Queue;
use App\Jobs\Queue\PushQueue;
use Illuminate\Support\Facades\Bus;
use App\Services\Queue\QueueService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_queue_user_success_occupy_and_release_queue()
    {
        $queue = Queue::factory()->create();
        $user = User::factory()->create();

        $now = Carbon::now();
        Carbon::setTestNow($now);
        $queueService = new QueueService($queue);
        $queueService->setActiveUser($user);
        $queue->refresh();
        $this->assertTrue($queueService->isActive($user));
        $endTime = $now->copy()->addSeconds($queue->time);
        $this->assertEquals($queue->start_time->timestamp, $now->timestamp);
        $this->assertEquals($queue->end_time->timestamp, $endTime->timestamp);
        Carbon::setTestNow($endTime);
        $queueService->free();
        $queue->refresh();
        $this->assertEquals($queue->start_time, null);
        $this->assertEquals($queue->end_time, null);
    }

    public function test_queue_should_process_each_user()
    {
        Bus::fake();
        $queue = Queue::factory()->create();
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        PushQueue::dispatch($queue, $user);
        Bus::assertDispatched(function (PushQueue $pushQueue) use ($user) {
               return $pushQueue->user->id == $user->id;
        });
        PushQueue::dispatch($queue, $anotherUser);
        Bus::assertDispatched(function (PushQueue $pushQueue) use ($anotherUser) {
            return $pushQueue->user->id == $anotherUser->id;
     });

    }
}
