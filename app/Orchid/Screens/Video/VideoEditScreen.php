<?php

namespace App\Orchid\Screens\Video;

use App\Models\Video;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
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
     * @param Experiment    $experiment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Video $video)
    {
        $request->validate([
            'video.title' => ['required'],
        ]);

        $video->fill($request->get('video'));
        $video->save();

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
