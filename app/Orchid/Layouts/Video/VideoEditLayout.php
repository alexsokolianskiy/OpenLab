<?php

namespace App\Orchid\Layouts\Video;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;
use App\Services\Video\VideoType;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Switcher;

class VideoEditLayout extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $type = $this->query->get('video.type');
        return [
            Group::make([
                Input::make('video.title')
                    ->type('text')
                    ->max(255)
                    ->required()
                    ->title(__('experiments.title')),
                Switcher::make('video.active')
                    ->title('Active')->sendTrueOrFalse(),
            ]),
            Group::make([
                Select::make('video.type')
                    ->title('Video input type')
                    ->options(
                        array_flip(VideoType::options())
                    )
                    ->required()
                    ->value($type),
                Input::make('video.source')
                    ->title('Video source')
                    ->type('text')
                    ->max(255)
                    ->required(),
            ])

        ];
    }
}
