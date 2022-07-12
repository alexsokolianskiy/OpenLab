<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use Illuminate\Http\Request;

class ExperimentController extends Controller
{
    public function index(Experiment $experiment)
    {
        return view('experiment', [
            'experiment' => $experiment
        ]);
    }
}
