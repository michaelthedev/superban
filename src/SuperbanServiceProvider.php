<?php

namespace Michaelthedev\Superban;

use Illuminate\Support\ServiceProvider;
use Michaelthedev\Superban\Http\Middleware\SuperbanMiddleware;

class SuperbanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/superban.php', 'superban');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/superban.php' => config_path('superban.php'),
        ], 'config');

        $this->app['router']
            ->aliasMiddleware('superban', SuperbanMiddleware::class);
    }
}
