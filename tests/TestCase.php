<?php

namespace Renatoxm\LaravelVonageDlrWebhooks\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Renatoxm\LaravelVonageDlrWebhooks\LaravelVonageDlrWebhooksServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelVonageDlrWebhooksServiceProvider::class,
        ];
    }
}
