<?php

namespace EmekaOrjiani\LinkIO;

use Illuminate\Contracts\Foundation\Application;
use EmekaOrjiani\LinkIO\Services\OnRampService;
use EmekaOrjiani\LinkIO\Services\OffRampService;
use EmekaOrjiani\LinkIO\Services\BridgeService;
use EmekaOrjiani\LinkIO\Services\RatesService;

class LinkIOManager
{
    public function __construct(protected Application $app) {}

    public function onRamp(): OnRampService
    {
        return $this->app->make(OnRampService::class);
    }

    public function offRamp(): OffRampService
    {
        return $this->app->make(OffRampService::class);
    }

    public function bridge(): BridgeService
    {
        return $this->app->make(BridgeService::class);
    }

    public function rates(): RatesService
    {
        return $this->app->make(RatesService::class);
    }
}
