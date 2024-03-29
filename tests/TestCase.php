<?php

namespace Whchi\LaravelLineBotWrapper\Tests;

use ReflectionClass;
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

    /**
     * @throws \ReflectionException
     */
    protected static function getNonPublicMethod($name, $klass)
    {
        $class = new ReflectionClass($klass);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

}
