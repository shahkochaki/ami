<?php

namespace Shahkochaki\Ami\Tests;

use Shahkochaki\Ami\Factory;
use React\Stream\Stream;
use React\EventLoop\LoopInterface;
use React\SocketClient\ConnectorInterface;
use Shahkochaki\Ami\Tests\Factory as TestFactory;

class AmiServiceProvider extends \Shahkochaki\Ami\Providers\AmiServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerStream();
        parent::register();
    }

    /**
     * Register stream.
     */
    protected function registerStream()
    {
        $this->app->singleton(Stream::class, function ($app) {
            return new Stream(fopen('php://memory', 'r+'), $app[LoopInterface::class]);
        });
        $this->app->alias(Stream::class, 'ami.stream');
    }

    /**
     * {@inheritdoc}
     */
    protected function registerFactory()
    {
        $this->app->singleton(Factory::class, function ($app) {
            return new TestFactory($app[LoopInterface::class], $app[ConnectorInterface::class], $app[Stream::class]);
        });
        $this->app->alias(Factory::class, 'ami.factory');
    }
}
