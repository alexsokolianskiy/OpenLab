<?php
namespace App\Services\Menu;

use App\Models\Menu as ModelsMenu;
use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuService
{
    public static function template()
    {
        $headItems = ModelsMenu::firstLevel()->get();


        $menu = Menu::new()
        ->addClass('navbar-nav me-auto mb-2 mb-md-0')
        ->addItemParentClass('nav-item');

        foreach($headItems as $item) {
            if ($item->children()->count()) {
                $submenu = Menu::new()
                ->addClass('dropdown-menu')
                ->setAttribute('aria-labelledby',  $item->url )
                ->addItemClass('dropdown-item');

                foreach($item->children as $child) {
                    $submenu = $submenu->link($child->url, $child->title);
                }
                $menu = $menu->submenu(
                    sprintf('<a class="nav-link dropdown-toggle" href="#" id="%s" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                %s
              </a>', $item->url, $item->title ), $submenu)->addClass('dropdown');
            } else {
                $menu = $menu-> add(Link::to($item->url, $item->title)->addClass('nav-link'));
            }
        }

        return $menu;

    }
}
