<?php

return [
    /*
    |--------------------------------------------------------------------------
    | LinkIO API Key
    |--------------------------------------------------------------------------
    */
    'api_key' => env('LINKIO_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | LinkIO API Secret
    |--------------------------------------------------------------------------
    | Sometimes used for webhook verification or advanced authentication.
    */
    'api_secret' => env('LINKIO_API_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | LinkIO Base URL
    |--------------------------------------------------------------------------
    */
    'base_url' => env('LINKIO_BASE_URL', 'https://api.linkio.world/v1'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Secret
    |--------------------------------------------------------------------------
    | Used to verify the signature of incoming requests from LinkIO.
    */
    'webhook_secret' => env('LINKIO_WEBHOOK_SECRET', ''),
];
