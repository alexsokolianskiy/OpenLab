<?php

namespace Tests;

use App\Models\User;

trait CreateOrchidAdmin
{
    /**
     * Creates the application.
     *
     */
    public function createAdmin() : User
    {
        return User::factory()->orchidAdmin()->create();
    }
}
