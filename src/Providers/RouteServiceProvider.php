<?php

namespace TypiCMS\Modules\Galleries\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
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
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('galleries')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($page->translate($lang)->status && $uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.galleries', 'uses' => 'PublicController@index']);
                        $router->get($uri.'/{slug}', $options + ['as' => $lang.'.galleries.slug', 'uses' => 'PublicController@show']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/galleries', 'AdminController@index')->name('admin::index-galleries');
            $router->get('admin/galleries/create', 'AdminController@create')->name('admin::create-gallery');
            $router->get('admin/galleries/{gallery}/edit', 'AdminController@edit')->name('admin::edit-gallery');
            $router->post('admin/galleries', 'AdminController@store')->name('admin::store-gallery');
            $router->put('admin/galleries/{gallery}', 'AdminController@update')->name('admin::update-gallery');

            /*
             * API routes
             */
            $router->get('api/galleries', 'ApiController@index')->name('api::index-galleries');
            $router->put('api/galleries/{gallery}', 'ApiController@update')->name('api::update-gallery');
            $router->delete('api/galleries/{gallery}', 'ApiController@destroy')->name('api::destroy-gallery');
        });
    }
}
