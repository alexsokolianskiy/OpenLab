<?php

namespace App\Orchid\Screens\Page;

use App\Models\Page;
use Orchid\Screen\Screen;
use App\Models\Experiment;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;
use App\Services\Page\PageService;
use App\Orchid\Layouts\Page\PageListLayout;
use App\Orchid\Layouts\Experiment\ExperimentsListLayout;

class PageListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'pages' => Page::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('pages.pages');
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
            ->route('pages.create'),
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
            PageListLayout::class
        ];
    }

         /**
     * @param Page $page
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Page $page)
    {
        $page->delete();
        $pageService = new PageService();
        if ($page->view) {
            $pageService->deleteView($page->view);
        }
        Toast::info(__('experiments.success'));

        return redirect()->route('pages.list');
    }
}
