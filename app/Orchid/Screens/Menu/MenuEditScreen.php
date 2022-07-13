<?php

namespace App\Orchid\Screens\Menu;

use App\Models\Page;
use App\Models\Queue;
use Orchid\Screen\Screen;
use App\Models\Experiment;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Page\PageEditLayout;
use App\Orchid\Layouts\Experiment\ExperimentsEditLayout;
use App\Orchid\Layouts\Menu\MenuEditLayout;
use App\Services\Page\PageService;

class MenuEditScreen extends Screen
{
    public $item;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Menu $menu): iterable
    {
        return [
            'item' => $menu
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
            Button::make(__('Remove'))
            ->icon('trash')
            ->confirm(__('experiments.sure'))
            ->method('remove')
            ->canSee($this->item->exists),

        Button::make(__('Save'))
            ->icon('check')
            ->method('save'),
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
            MenuEditLayout::class
        ];
    }

     /**
     * @param Request $request
     * @param Page    $page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Menu $menu)
    {
        $request->validate([
            'item.title' => ['required'],
            'item.url' => ['string', 'required'],
            'item.parent_id' => [Rule::exists(Menu::class, 'id')],
            'item.order_num' => ['integer']
        ]);

        $data = $request->get('item');
        $menu->fill($data);
        $menu->save();
        Toast::info(__('experiments.success'));

        return redirect()->route('menu.list');
    }

    /**
     * @param Experiment $experiment
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
