<?php
namespace TypiCMS\Modules\Galleries\Providers;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lang;
use TypiCMS\Modules\Galleries\Models\Gallery;
use TypiCMS\Modules\Galleries\Models\GalleryTranslation;
use TypiCMS\Modules\Galleries\Repositories\CacheDecorator;
use TypiCMS\Modules\Galleries\Repositories\EloquentGallery;
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Services\Cache\LaravelCache;
use View;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php', 'typicms.galleries'
        );

        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'galleries');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'galleries');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/galleries'),
        ], 'views');
        $this->publishes([
            __DIR__ . '/../database' => base_path('database'),
        ], 'migrations');
        $this->publishes([
            __DIR__ . '/../../tests' => base_path('tests'),
        ], 'tests');

        AliasLoader::getInstance()->alias(
            'Galleries',
            'TypiCMS\Modules\Galleries\Facades\Facade'
        );

        // Observers
        GalleryTranslation::observe(new SlugObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Galleries\Providers\RouteServiceProvider');

        /**
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Galleries\Composers\SidebarViewComposer');

        $app->bind('TypiCMS\Modules\Galleries\Repositories\GalleryInterface', function (Application $app) {
            $repository = new EloquentGallery(new Gallery);
            if (! config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['galleries', 'files'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

    }
}
