<?php

namespace TypiCMS\Modules\Galleries\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Galleries\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return null
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('galleries')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (locales() as $lang) {
                    if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['uses' => 'PublicController@index'])->name($lang.'::index-galleries');
                        $router->get($uri.'/{slug}', $options + ['uses' => 'PublicController@show'])->name($lang.'::gallery');
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->group(['middleware' => 'admin', 'prefix' => 'admin'], function (Router $router) {
                $router->get('galleries', 'AdminController@index')->name('admin::index-galleries');
                $router->get('galleries/create', 'AdminController@create')->name('admin::create-gallery');
                $router->get('galleries/{gallery}/edit', 'AdminController@edit')->name('admin::edit-gallery');
                $router->post('galleries', 'AdminController@store')->name('admin::store-gallery');
                $router->put('galleries/{gallery}', 'AdminController@update')->name('admin::update-gallery');
                $router->patch('galleries/{gallery}', 'AdminController@ajaxUpdate');
                $router->delete('galleries/{gallery}', 'AdminController@destroy')->name('admin::destroy-gallery');
            });
        });
    }
}
