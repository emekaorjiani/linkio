<?php

namespace EmekaOrjiani\LinkIO\Http\Controllers;

use Illuminate\Http\Request;
use EmekaOrjiani\LinkIO\DTOs\WebhookPayloadDTO;

class WebhookController
{
    public function handle(Request $request)
    {
        // Turn into a DTO or handle directly
        $payload = WebhookPayloadDTO::fromRequest($request);

        // Example: handle different event types
        if ($payload->eventType === 'transaction.completed') {
            // ...
        }
        
        return response()->json(['status' => 'ok']);
    }
}
