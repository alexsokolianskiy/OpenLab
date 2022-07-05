<?php

namespace App\Orchid\Screens\Queue;

use App\Models\Queue;
use App\Models\Video;
use App\Orchid\Layouts\Queue\QueueEditLayout;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Video\VideoEditLayout;

class QueueEditScreen extends Screen
{
    public $queue;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Queue $queue): iterable
    {
        return [
            'queue' => $queue
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'QueueEditScreen';
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
                ->canSee($this->queue->exists),

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
        return [QueueEditLayout::class];
    }

         /**
     * @param Request $request
     * @param Experiment    $experiment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Queue $queue)
    {
        $request->validate([
            'queue.title' => ['required'],
        ]);

        $queue->fill($request->get('queue'));
        $queue->save();

        Toast::info(__('experiments.success'));

        return redirect()->route('queues.list');
    }

    /**
     * @param Experiment $experiment
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
