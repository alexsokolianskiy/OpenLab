<?php

namespace Tests\Unit\Video;

use Tests\TestCase;
use App\Models\User;
use App\Models\Video;
use Orchid\Support\Testing\ScreenTesting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\CreateOrchidAdmin;

class VideoTest extends TestCase
{
    use RefreshDatabase, ScreenTesting, CreateOrchidAdmin, WithFaker;


    public function test_video_success_create()
    {
        $user = $this->createAdmin();
        $screen = $this->screen('videos.create')->actingAs($user);
        $video = Video::factory()->make()->toArray();
        $screen->display();
        $screen->method('save', [
            'video' => $video
        ]);
        $this->assertDatabaseHas('videos', $video);
    }

    public function test_video_failed_create()
    {
        $user = $this->createAdmin();
        $screen = $this->screen('videos.create')->actingAs($user);
        $video = Video::factory()->make([
            'type' => 99
        ])->toArray();
        $screen->display();
        $screen->method('save', [
            'video' => $video
        ]);
        $this->assertDatabaseMissing('videos', $video);
    }

    public function test_video_success_remove()
    {
        $video = Video::factory()->create();
        $user = $this->createAdmin();
        $screen = $this->screen('videos.list')->actingAs($user);
        $screen->display();
        $screen->method('remove', [
            $video
        ]);
        $this->assertDatabaseMissing('videos', $video->toArray());
    }

    public function test_video_success_edit_device()
    {
        $user = $this->createAdmin();
        $origin = Video::factory()->create();
        $screen = $this->screen('videos.edit')->parameters([$origin->id])->actingAs($user);
        $screen->display();
        $source = $this->faker->numerify('/dev/video#');
        $origin->source = $source;
        $screen->method('save', [
            'video' =>  $origin->toArray()
        ]);
        $this->assertEquals($source, $origin->source);
    }

    // public function test_video_stream_should_start_on_startup()
    // {

    // }

    // public function test_video_stream_from_device_should_start()
    // {

    // }

    // public function test_video_stream_from_file_should_start()
    // {

    // }

    // public function test_video_stream_from_ip_should_start()
    // {

    // }

    // public function test_video_stream_should_stop()
    // {

    // }

    // public function test_video_stream_should_be_restored_on_failure()
    // {

    // }

    // public function test_video_stream_files_should_be_cleaned_up_after_stream_stop()
    // {

    // }
}
