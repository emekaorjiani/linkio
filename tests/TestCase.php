<?php

namespace EmekaOrjiani\LinkIO\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use EmekaOrjiani\LinkIO\LinkIOServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LinkIOServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('linkio.api_key', 'test-api-key');
        $app['config']->set('linkio.api_secret', 'test-api-secret');
        $app['config']->set('linkio.base_url', 'https://api.sandbox.linkio.world');
        $app['config']->set('linkio.webhook_secret', 'test-webhook-secret');
    }
}
