<?php

namespace Whchi\LaravelLineBotWrapper\Tests;


use Closure;
use Config;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Mockery as m;
use Whchi\LaravelLineBotWrapper\LINEBotServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LINEBotServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('linebot.channel_access_token', 'token_123456');
        $app['config']->set('linebot.channel_secret', 'secret_123456');
    }

    public function httpMock(Closure $callback)
    {
        $mock = $callback(m::mock(CurlHTTPClient::class, [
            $this->app['config']->get('linebot.channel_access_token'),
        ]));

        $this->app->instance('linebot.http', $mock);
    }

}
