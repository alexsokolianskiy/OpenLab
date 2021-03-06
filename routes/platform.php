<?php

declare(strict_types=1);

use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Page\PageEditScreen;
use App\Orchid\Screens\Page\PageListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\Queue\QueueEditScreen;
use App\Orchid\Screens\Queue\QueueListScreen;
use App\Orchid\Screens\Video\VideoEditScreen;
use App\Orchid\Screens\Video\VideoListScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Experiment\ExperimentsEditScreen;
use App\Orchid\Screens\Experiment\ExperimentsListScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Menu\MenuEditScreen;
use App\Orchid\Screens\Menu\MenuListScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'language'], function () {
    // Main
    Route::screen('/main', PlatformScreen::class)
        ->name('platform.main');

    // Platform > Profile
    Route::screen('profile', UserProfileScreen::class)
        ->name('platform.profile')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('Profile'), route('platform.profile'));
        });

    // Platform > System > Users
    Route::screen('users/{user}/edit', UserEditScreen::class)
        ->name('platform.systems.users.edit')
        ->breadcrumbs(function (Trail $trail, $user) {
            return $trail
                ->parent('platform.systems.users')
                ->push(__('User'), route('platform.systems.users.edit', $user));
        });

    // Platform > System > Users > Create
    Route::screen('users/create', UserEditScreen::class)
        ->name('platform.systems.users.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.systems.users')
                ->push(__('Create'), route('platform.systems.users.create'));
        });

    // Platform > System > Users > User
    Route::screen('users', UserListScreen::class)
        ->name('platform.systems.users')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('Users'), route('platform.systems.users'));
        });

    // Platform > System > Roles > Role
    Route::screen('roles/{role}/edit', RoleEditScreen::class)
        ->name('platform.systems.roles.edit')
        ->breadcrumbs(function (Trail $trail, $role) {
            return $trail
                ->parent('platform.systems.roles')
                ->push(__('Role'), route('platform.systems.roles.edit', $role));
        });

    // Platform > System > Roles > Create
    Route::screen('roles/create', RoleEditScreen::class)
        ->name('platform.systems.roles.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.systems.roles')
                ->push(__('Create'), route('platform.systems.roles.create'));
        });

    // Platform > System > Roles
    Route::screen('roles', RoleListScreen::class)
        ->name('platform.systems.roles')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('Roles'), route('platform.systems.roles'));
        });

    // Example...
    Route::screen('example', ExampleScreen::class)
        ->name('platform.example')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Example screen');
        });

    Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
    Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
    Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
    Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
    Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
    Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

    //Route::screen('idea', Idea::class, 'platform.screens.idea');

    Route::screen('/experiments', ExperimentsListScreen::class)->name('experiments.list');
    Route::screen('/experiments/create', ExperimentsEditScreen::class)->name('experiments.create');
    Route::screen('/experiments/edit/{experiment}', ExperimentsEditScreen::class)->name('experiments.edit');
    Route::post('/experiments/remove/{experiment}', [ExperimentsListScreen::class, 'remove'])->name('experiments.remove');

    Route::screen('/videos', VideoListScreen::class)->name('videos.list');
    Route::screen('/videos/create', VideoEditScreen::class)->name('videos.create');
    Route::screen('/videos/edit/{video}', VideoEditScreen::class)->name('videos.edit');
    Route::post('/videos/remove/{video}', [VideoListScreen::class, 'remove'])->name('videos.remove');

    Route::screen('/queues', QueueListScreen::class)->name('queues.list');
    Route::screen('/queues/create', QueueEditScreen::class)->name('queues.create');
    Route::screen('/queues/edit/{queue}', QueueEditScreen::class)->name('queues.edit');
    Route::post('/queues/remove/{queue}', [QueueListScreen::class, 'remove'])->name('queues.remove');

    Route::screen('/page', PageListScreen::class)->name('pages.list');
    Route::screen('/page/create', PageEditScreen::class)->name('pages.create');
    Route::screen('/page/edit/{page}', PageEditScreen::class)->name('pages.edit');
    Route::post('/page/remove/{page}', [PageListScreen::class, 'remove'])->name('page.remove');

    Route::screen('/menu', MenuListScreen::class)->name('menu.list');
    Route::screen('/menu/create', MenuEditScreen::class)->name('menu.create');
    Route::screen('/menu/edit/{menu}', MenuEditScreen::class)->name('menu.edit');
    Route::post('/menu/remove/{menu}', [MenuListScreen::class, 'remove'])->name('menu.remove');
});
