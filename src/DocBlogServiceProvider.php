<?php

namespace Parfaitementweb\DocBlog;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class DocblogServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'docblog');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'docblog');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/breadcrumbs.php');

        View::composer(
            'docblog::blog.menu', \Parfaitementweb\DocBlog\ViewComposers\Blog\MenuComposer::class
        );

        View::composer(
            'docblog::docs.menu', \Parfaitementweb\DocBlog\ViewComposers\Docs\MenuComposer::class
        );

        View::composer(
            'docblog::docs._partials.categories', \Parfaitementweb\DocBlog\ViewComposers\Docs\CategoriesComposer::class
        );

        app('router')->aliasMiddleware('docblog_auth', \Parfaitementweb\DocBlog\Http\Middleware\Authenticate::class);
        app('router')->aliasMiddleware('cacheResponse', \Spatie\ResponseCache\Middlewares\CacheResponse::class);
        app('router')->aliasMiddleware('localizationRedirect', \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class);

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/Helpers.php';

        $this->mergeConfigFrom(__DIR__ . '/../config/docblog.php', 'docblog');

        // Register the service the package provides.
        $this->app->singleton('docblog', function ($app) {
            return new docblog;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['docblog'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/docblog.php' => config_path('docblog.php'),
            __DIR__ . '/../config/feed.php' => config_path('feed.php'),
            __DIR__ . '/../config/laravellocalization.php' => config_path('laravellocalization.php'),
            __DIR__ . '/../config/medialibrary.php' => config_path('medialibrary.php'),
            __DIR__ . '/../config/responsecache.php' => config_path('responsecache.php'),
            __DIR__ . '/../config/scout.php' => config_path('scout.php'),
        ], 'docblog.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views/blog' => base_path('resources/views/vendor/docblog/blog'),
            __DIR__.'/../resources/views/docs' => base_path('resources/views/vendor/docblog/docs'),
        ], 'docblog.views');

        // Publishing assets.
        $this->publishes([
            __DIR__ . '/../resources/assets' => resource_path('assets/vendor/docblog'),
        ], 'docblog.views');

        // Publishing the translation files.
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/docblog'),
        ], 'docblog.views');

        // Registering package commands.
        // $this->commands([]);
    }
}
