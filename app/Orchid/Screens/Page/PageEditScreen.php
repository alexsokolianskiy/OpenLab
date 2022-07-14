<?php

namespace App\Orchid\Screens\Page;

use App\Models\Page;
use App\Models\Queue;
use Orchid\Screen\Screen;
use App\Models\Experiment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Page\PageEditLayout;
use App\Orchid\Layouts\Experiment\ExperimentsEditLayout;
use App\Services\Page\PageService;

class PageEditScreen extends Screen
{
    public $page;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Page $page): iterable
    {
        return [
            'page' => $page
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('pages.page');
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
            ->canSee($this->page->exists),

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
            PageEditLayout::class
        ];
    }

     /**
     * @param Request $request
     * @param Page    $page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Page $page)
    {
        $pageService = new PageService();
        $request->validate([
            'page.title' => ['required'],
            'page.code' => ['string'],
        ]);
        if ($page->exists() && $page->view) {
            $pageService->deleteView($page->view);
        }

        $title = $request->input('page.title');
        $page->title = $title;
        $page->save();
        $pageService->saveView($request->input('page.code'), $page->view);
        Toast::info(__('experiments.success'));

        return redirect()->route('pages.list');
    }

    /**
     * @param Experiment $experiment
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Page $page)
    {
        $pageService = new PageService();
        $page->delete();
        if ($page->view) {
            $pageService->deleteView($page->view);
        }
        Toast::info(__('experiments.success'));

        return redirect()->route('pages.list');
    }
}
