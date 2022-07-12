<?php

namespace App\Orchid\Screens\Experiment;

use Orchid\Screen\Screen;
use App\Models\Experiment;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Experiment\ExperimentsEditLayout;

class ExperimentsEditScreen extends Screen
{
    public $experiment;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Experiment $experiment): iterable
    {
        return [
            'experiment' => $experiment
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('experiments.experiment');
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
            ->canSee($this->experiment->exists),

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
        return [
            ExperimentsEditLayout::class
        ];
    }

     /**
     * @param Request $request
     * @param Experiment    $experiment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Experiment $experiment)
    {
        $request->validate([
            'experiment.title' => ['required'],
            'experiment.description' => ['required'],
            'experiment.queue_id' => [Rule::exists(Queue::class, 'id')],
        ]);

        $data = $request->get('experiment');
        if (!isset($data['queue_id'])) {
            $data['queue_id'] = null;
        }

        $experiment->fill($data);
        $experiment->save();

        Toast::info(__('experiments.success'));

        return redirect()->route('experiments.list');
    }

    /**
     * @param Experiment $experiment
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Experiment $experiment)
    {
        $experiment->delete();

        Toast::info(__('experiments.success'));

        return redirect()->route('experiments.list');
    }
}
