<?php

namespace App\Orchid\Layouts\Video;

use App\Models\Video;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;

class VideoListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'videos';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('title', __('experiments.title'))
            ->sort()
            ->cantHide()
            ->filter(Input::make()),
            TD::make(__('Actions'))
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(function (Video $video) {
                return Group::make([

                        Link::make(__('experiments.edit'))
                            ->route('videos.edit', $video->id)
                            ->icon('pencil'),

                        Button::make(__('experiments.remove'))
                            ->icon('trash')
                            ->confirm(__('experiments.sure'))
                            ->method(sprintf('remove/%d', $video->id)),
                    ]);
            }),
        ];
    }
}
