<?php

namespace App\Orchid\Layouts\Page;

use App\Models\Queue;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\SimpleMDE;

class PageEditLayout extends Rows
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
            Input::make('page.title')
            ->type('text')
            ->max(255)
            ->required()
            ->title(__('experiments.title')),
            SimpleMDE::make('page.view')
            ->title(__('experiments.description'))
        ];
    }
}
