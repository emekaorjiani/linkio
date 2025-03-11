<?php

namespace EmekaOrjiani\LinkIO\Tests\Unit;

use EmekaOrjiani\LinkIO\Services\OnRampService;
use EmekaOrjiani\LinkIO\Services\LinkIOClient;
use EmekaOrjiani\LinkIO\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class OnRampServiceTest extends TestCase
{
    public function test_it_creates_onramp_transaction()
    {
        // Fake HTTP response
        Http::fake([
            '*' => Http::response([
                'transaction_id' => 'tx_001',
                'fiat_amount' => 1000,
                'fiat_currency' => 'NGN',
                'crypto_amount' => 1.2,
                'crypto_currency' => 'USDT',
                'wallet_address' => '0xabc',
                'status' => 'pending',
                'created_at' => now()->toISOString(),
                'completed_at' => null
            ], 200)
        ]);

        $service = new OnRampService(new LinkIOClient());

        $dto = $service->createOnRampTransaction('0xabc', 1000, 'NGN');

        $this->assertEquals('tx_001', $dto->transactionId);
        $this->assertEquals(1000, $dto->fiatAmount);
        $this->assertEquals('pending', $dto->status);
    }
}
