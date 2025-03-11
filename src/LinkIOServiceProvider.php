<?php

namespace EmekaOrjiani\LinkIO;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use EmekaOrjiani\LinkIO\Http\Middleware\EnsureSignature;
use EmekaOrjiani\LinkIO\Services\LinkIOClient;

class LinkIOServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // 1. Merge the config (correct path for config directory)
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/linkio.php' => config_path('linkio.php'),
            ], 'linkio-config');
        }
        

        // 2. Bind the LinkIOClient singleton
        $this->app->singleton(LinkIOClient::class, function ($app) {
            return new LinkIOClient();
        });

        // 3. Register the services for Facade
        $this->app->singleton('linkio', function ($app) {
            return new LinkIOManager($app);
        });

        // 4. Register the services individually (optional)
        $this->app->singleton(\EmekaOrjiani\LinkIO\Services\OnRampService::class);
        $this->app->singleton(\EmekaOrjiani\LinkIO\Services\OffRampService::class);
        $this->app->singleton(\EmekaOrjiani\LinkIO\Services\BridgeService::class);
        $this->app->singleton(\EmekaOrjiani\LinkIO\Services\RatesService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 5. Publish the config
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/linkio.php' => config_path('linkio.php'),
            ], 'linkio-config');
        }

        // 6. Register the middleware alias for webhook verification
        $router = $this->app['router'];
        $router->aliasMiddleware('linkio.signature', EnsureSignature::class);
    }
}
