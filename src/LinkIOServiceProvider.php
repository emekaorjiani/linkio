<?php

namespace EmekaOrjiani\LinkIO;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use EmekaOrjiani\LinkIO\Http\Middleware\EnsureSignature;
use EmekaOrjiani\LinkIO\Services\LinkIOClient;

class LinkIOServiceProvider extends ServiceProvider
{
    public function register()
    {
        // 1. Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/linkio.php', 'linkio'
        );

        // 2. Bind our LinkIOClient singleton
        $this->app->singleton(LinkIOClient::class, function($app) {
            return new LinkIOClient();
        });

        // 3. Optionally bind a single entry for the facade
        $this->app->singleton('linkio', function ($app) {
            // Return an array or a manager object with references to each service
            return [
                'onRamp'  => $app->make(\EmekaOrjiani\LinkIO\Services\OnRampService::class),
                'offRamp' => $app->make(\EmekaOrjiani\LinkIO\Services\OffRampService::class),
                'bridge'  => $app->make(\EmekaOrjiani\LinkIO\Services\BridgeService::class),
                'rates'   => $app->make(\EmekaOrjiani\LinkIO\Services\RatesService::class),
            ];
        });
    }

    public function boot()
    {
        // 4. Publish the config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/linkio.php' => config_path('linkio.php'),
            ], 'linkio-config');
        }

        // 5. Register middleware alias for webhook signature
        $this->app['router']->aliasMiddleware('linkio.signature', EnsureSignature::class);
    }
}
