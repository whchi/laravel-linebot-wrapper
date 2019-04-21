<?php

namespace Whchi\LaravelLineBotWrapper;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Whchi\LaravelLineBotWrapper\LINEBotContext;

class LINEBotServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configSrc = realpath($raw = __DIR__ . '/../config/linebot.php') ?: $raw;
        $migrationSrc = realpath($raw = __DIR__ . '/../database/migrations/') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$configSrc => config_path('linebot.php')], 'config');
            $this->loadMigrationsFrom($migrationSrc);
        }

        $this->mergeConfigFrom($configSrc, 'linebot');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'LINEBotContext', function ($app) {
                return new LINEBotContext;
            }
        );
    }

    public function provides()
    {
        return [
            'LINEBotContext',
        ];
    }
}
