<?php

namespace App\Orchid\Screens\Menu;

use App\Models\Menu;
use App\Models\Page;
use Orchid\Screen\Screen;
use App\Models\Experiment;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Services\Page\PageService;
use App\Orchid\Layouts\Page\PageListLayout;
use App\Orchid\Layouts\Experiment\ExperimentsListLayout;
use App\Orchid\Layouts\Menu\MenuListLayout;

class MenuListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'items' => Menu::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('menu.menu');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
            ->icon('plus')
            ->route('menu.create'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            MenuListLayout::class
        ];
    }

         /**
     * @param Menu $menu
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Menu $menu)
    {
        $menu->delete();

        Toast::info(__('experiments.success'));

        return redirect()->route('menu.list');
    }
}
