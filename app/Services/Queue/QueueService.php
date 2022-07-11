<?php

namespace App\Services\Queue;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Queue;

class QueueService {
    private Queue $queue;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    public function setActiveUser(User $user)
    {
        $now = Carbon::now();
        $this->queue->current_user = $user->id;
        $this->queue->start_time = $now;
        $this->queue->end_time = $now->addSeconds($this->queue->time);
        $this->queue->save();
    }

    public function free()
    {
        $this->queue->current_user = null;
        $this->queue->start_time = null;
        $this->queue->end_time = null;
        $this->queue->save();
    }

    public function isActive(User $user)
    {
        if ($this->queue->current_user == $user->id) {
            return true;
        }

        return false;
    }
}
