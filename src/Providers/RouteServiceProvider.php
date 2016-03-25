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
            $router->get('admin/galleries', ['as' => 'admin.galleries.index', 'uses' => 'AdminController@index']);
            $router->get('admin/galleries/create', ['as' => 'admin.galleries.create', 'uses' => 'AdminController@create']);
            $router->get('admin/galleries/{gallery}/edit', ['as' => 'admin.galleries.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/galleries', ['as' => 'admin.galleries.store', 'uses' => 'AdminController@store']);
            $router->put('admin/galleries/{gallery}', ['as' => 'admin.galleries.update', 'uses' => 'AdminController@update']);

            /*
             * API routes
             */
            $router->get('api/galleries', ['as' => 'api.galleries.index', 'uses' => 'ApiController@index']);
            $router->put('api/galleries/{gallery}', ['as' => 'api.galleries.update', 'uses' => 'ApiController@update']);
            $router->delete('api/galleries/{gallery}', ['as' => 'api.galleries.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
