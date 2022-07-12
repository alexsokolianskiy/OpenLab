<?php
namespace App\Services\Menu;

use Spatie\Menu\Menu;

class MenuService
{
    public static function template()
    {

            return Menu::new()
            ->addClass('navbar-nav me-auto mb-2 mb-md-0')
            ->addItemParentClass('nav-item')
            ->addItemClass('nav-link')
            ->link('/', 'One')
            ->link('/', 'Two');


    }
}
