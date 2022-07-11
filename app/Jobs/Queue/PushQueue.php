<?php

namespace App\Jobs\Queue;

use App\Models\User;
use App\Models\Queue;
use Illuminate\Bus\Queueable;
use App\Services\Queue\QueueService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PushQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Queue $queueModel;
    public User $user;
    public QueueService $queue_service;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Queue $queue, User $user)
    {
        $this->queue_service = new QueueService($queue);
        $this->queueModel = $queue;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->queue_service->setActiveUser($this->user);
        sleep($this->queueModel->time);
        $this->queue_service->free();
    }
}
