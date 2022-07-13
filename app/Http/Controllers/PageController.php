<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PageController extends Controller
{
    public function index(Page $page)
    {
        if ($page->view) {
            return view('pages.'. $page->view);
        }

        return new HttpException(404);
    }
}
