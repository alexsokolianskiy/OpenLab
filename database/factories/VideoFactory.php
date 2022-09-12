<?php

namespace Database\Factories;

use App\Services\Video\VideoStatus;
use App\Services\Video\VideoType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'status' => $this->faker->randomElement([VideoStatus::RUNNING->value, VideoStatus::STOPPED->value]),
            'type' => $this->faker->randomElement([VideoType::DEVICE->value, VideoType::NETWORK->value]),
            'source' => $this->faker->numerify('/dev/video#'),
            'active' => $this->faker->randomElement([0, 1])
        ];
    }
}
