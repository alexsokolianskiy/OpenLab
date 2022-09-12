<?php

namespace App\Orchid\Screens\Video;

use App\Models\Video;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tests\Unit\Video\VideoTest;
use App\Services\Video\VideoType;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Artisan;
use App\Orchid\Layouts\Video\VideoEditLayout;

class VideoEditScreen extends Screen
{
    public $video;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Video $video): iterable
    {
        return [
            'video' => $video
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'VideoEditScreen';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('experiments.sure'))
                ->method('remove')
                ->canSee($this->video->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [VideoEditLayout::class];
    }

    /**
     * @param Request $request
     * @param Video $video
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Video $video)
    {
        $request->validate([
            'video.title' => ['required'],
            'video.type' => ['required', 'integer', new Enum(VideoType::class)],
            'video.source' => ['required', 'string'],
            'video.active' => ['required', 'boolean']
        ]);

        $video->fill($request->input('video'));
        $video->save();
        if ($video->active) {
            Artisan::queue('run:stream', ['video' => $video->id]);
        }
        Toast::info(__('experiments.success'));

        return redirect()->route('videos.list');
    }

    /**
     * @param Experiment $experiment
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Video $video)
    {
        $video->delete();

        Toast::info(__('experiments.success'));

        return redirect()->route('videos.list');
    }
}
