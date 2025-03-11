<?php

namespace EmekaOrjiani\LinkIO\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Event;
use EmekaOrjiani\LinkIO\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class WebhookTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Define test webhook route
        Route::post('/webhook/linkio', function () {
            return response()->json(['status' => 'ok']);
        })->middleware('linkio.signature');
    }

    /** @test */
    public function it_validates_webhook_signature_and_returns_ok()
    {
        $payload = [
            'event_type' => 'transaction.completed',
            'transaction_id' => 'tx_001',
            'status' => 'completed',
            'resource' => 'onramp',
            'triggered_at' => now()->toISOString(),
            'payload' => []
        ];

        $secret = config('linkio.webhook_secret');
        $signature = hash_hmac('sha256', json_encode($payload), $secret);

        $response = $this->postJson('/webhook/linkio', $payload, [
            'X-LinkIO-Signature' => $signature,
        ]);

        $response->assertOk();
        $response->assertJson(['status' => 'ok']);
    }

    /** @test */
    public function it_rejects_invalid_signature()
    {
        $payload = [
            'event_type' => 'transaction.failed',
            'transaction_id' => 'tx_002'
        ];

        $response = $this->postJson('/webhook/linkio', $payload, [
            'X-LinkIO-Signature' => 'invalid-signature',
        ]);

        $response->assertStatus(401);
    }
}
