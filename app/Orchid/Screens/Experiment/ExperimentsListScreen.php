<?php

namespace App\Orchid\Screens\Experiment;

use Orchid\Screen\Screen;
use App\Models\Experiment;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Experiment\ExperimentsListLayout;

class ExperimentsListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'experiments' => Experiment::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('experiments.experiments');
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
            ->route('experiments.create'),
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
            ExperimentsListLayout::class
        ];
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
