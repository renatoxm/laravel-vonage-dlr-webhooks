<?php

namespace Renatoxm\LaravelVonageDlrWebhooks;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Renatoxm\LaravelVonageDlrWebhooks\Http\Controllers\LaravelVonageDlrWebhooksController;

class LaravelVonageDlrWebhooksServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerPublishing();
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-vonage-dlr-webhooks.php', 'laravel-vonage-dlr-webhooks');
    }

    /**
     * Summary of registerRoutes.
     */
    private function registerRoutes(): void
    {
        Route::post(config('laravel-vonage-dlr-webhooks.path'), LaravelVonageDlrWebhooksController::class)->name('LaravelVonageDlrWebhooks');
    }

    /**
     * Summary of registerMigrations.
     */
    private function registerMigrations(): void
    {
        if ($this->app->runningInConsole() && $this->shouldMigrate()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * Summary of registerPublishing.
     */
    private function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/laravel-vonage-dlr-webhooks.php' => config_path('laravel-vonage-dlr-webhooks.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'migrations');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-vonage-dlr-webhooks'];
    }

    /**
     * Summary of shouldMigrate.
     */
    protected function shouldMigrate(): bool
    {
        return config('laravel-vonage-dlr-webhooks.log.enabled');
    }
}
