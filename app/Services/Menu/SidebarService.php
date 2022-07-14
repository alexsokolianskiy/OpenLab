<?php
namespace App\Services\Menu;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;
use App\Models\Experiment;
use App\Models\Menu as ModelsMenu;
use Illuminate\Support\Facades\Request;

class SidebarService
{
    public static function template()
    {
        $experiments = Experiment::all();


        $menu = Menu::new()
        ->addClass('nav nav-pills flex-column mb-auto')
        ->setActiveClassOnLink();
        // ->addItemParentClass('nav-item');

        foreach($experiments as $experiment) {
            $menu = $menu-> add(
                Link::to(url('/experiment/'.$experiment->id), $experiment->title)
                ->addClass('nav-link text-white')
            );
        }

        return $menu->setActive(Request::url());

    }
}
