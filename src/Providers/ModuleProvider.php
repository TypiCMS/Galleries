<?php

namespace TypiCMS\Modules\Galleries\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Core\Services\Cache\LaravelCache;
use TypiCMS\Modules\Galleries\Models\Gallery;
use TypiCMS\Modules\Galleries\Models\GalleryTranslation;
use TypiCMS\Modules\Galleries\Repositories\CacheDecorator;
use TypiCMS\Modules\Galleries\Repositories\EloquentGallery;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.galleries'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['galleries' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'galleries');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'galleries');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/galleries'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Galleries',
            'TypiCMS\Modules\Galleries\Facades\Facade'
        );

        // Observers
        GalleryTranslation::observe(new SlugObserver());
        Gallery::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Galleries\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Galleries\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('galleries::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('galleries');
        });

        $app->bind('TypiCMS\Modules\Galleries\Repositories\GalleryInterface', function (Application $app) {
            $repository = new EloquentGallery(new Gallery());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['galleries', 'files'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
