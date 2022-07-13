<?php

namespace App\Orchid\Layouts\Menu;

use App\Models\Menu;
use App\Models\Queue;
use App\Services\Experiment\ExperimentService;
use App\Services\Page\PageService;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\SimpleMDE;

class MenuEditLayout extends Rows
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
        $item = $this->query->getContent('item');
        return [
            Input::make('item.title')
            ->type('text')
            ->max(255)
            ->required()
            ->title(__('experiments.title')),
            Relation::make('item.parent_id')
            //TODO prevent here display itself ids
            // ->applyScope('exceptCurrent', [$item])
            ->fromModel(Menu::class, 'title')
            ->title(__('menu.parent')),
            Select::make('item.url')
            ->options(
                array_merge(
                    PageService::getRoutes(),
                    ExperimentService::getRoutes()
                )
                ),
            Input::make('item.order_num')
                ->type('number')
                ->title('menu.order')

        ];
    }
}
