<?php

namespace App\Orchid\Screens\Queue;

use App\Models\Queue;
use App\Models\Video;
use App\Orchid\Layouts\Queue\QueueListLayout;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Video\VideoListLayout;

class QueueListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'queues' => Queue::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'QueueListScreen';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
            ->icon('plus')
            ->route('queues.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            QueueListLayout::class
        ];
    }

    /**
     * @param Video $video
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Queue $queue)
    {
        $queue->delete();

        Toast::info(__('experiments.success'));

        return redirect()->route('queues.list');
    }
}
