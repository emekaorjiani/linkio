<?php

namespace EmekaOrjiani\LinkIO\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \EmekaOrjiani\LinkIO\Services\OnRampService onRamp()
 * @method static \EmekaOrjiani\LinkIO\Services\OffRampService offRamp()
 * @method static \EmekaOrjiani\LinkIO\Services\BridgeService bridge()
 * @method static \EmekaOrjiani\LinkIO\Services\RatesService rates()
 *
 * @see \EmekaOrjiani\LinkIO\LinkIOServiceProvider
 */
class LinkIO extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * This must match the container binding in LinkIOServiceProvider
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'linkio'; // This refers to the singleton you registered in the service provider
    }
}
