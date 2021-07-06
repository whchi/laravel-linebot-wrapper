<?php

namespace Whchi\LaravelLineBotWrapper;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LINEBotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configSrc = realpath($raw = __DIR__ . '/../config/linebot.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$configSrc => config_path('linebot.php')], 'config');
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
        $this->app->singleton(HTTPClient::class, function ($app) {
            return new CurlHTTPClient(config('linebot.channel_access_token'));
        });
        $this->app->singleton(LINEBot::class, function ($app) {
            return new LINEBot($app->make(HTTPClient::class), ['channelSecret' => config('linebot.channel_secret')]);
        });
        $this->app->singleton(
            'LINEBotContext',
            function ($app) {
                return new LINEBotContext(LINEBot::class);
            }
        );
    }
}
