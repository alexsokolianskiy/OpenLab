<?php

namespace App\Orchid\Layouts\Experiment;

use App\Models\Queue;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\SimpleMDE;

class ExperimentsEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('experiment.title')
            ->type('text')
            ->max(255)
            ->required()
            ->title(__('experiments.title')),
            Relation::make('experiment.queue_id')
            ->fromModel(Queue::class, 'title')
            ->title(__('experiments.queue')),
            Quill::make('experiment.description')
            ->title(__('experiments.description'))
        ];
    }
}
