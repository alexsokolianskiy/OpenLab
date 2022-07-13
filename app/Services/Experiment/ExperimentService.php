<?php

namespace App\Services\Experiment;

use App\Models\Experiment;

class ExperimentService
{
    public static function getRoutes()
    {
        $pages = Experiment::select('title', 'id')->get()->mapWithKeys(function($item, $key) {
            return [url(sprintf('/experiment/%s', $item['id'])) => 'Experiments['. $item['title'].']'];
        } );
        return $pages->toArray();
    }
}
