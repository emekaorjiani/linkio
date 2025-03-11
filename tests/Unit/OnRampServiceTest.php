<?php

namespace EmekaOrjiani\LinkIO\Tests\Unit;

use Illuminate\Support\Facades\Http;
use EmekaOrjiani\LinkIO\Services\LinkIOClient;
use EmekaOrjiani\LinkIO\Services\OnRampService;
use EmekaOrjiani\LinkIO\DTOs\OnRampTransactionDTO;
use PHPUnit\Framework\TestCase;

class OnRampServiceTest extends TestCase
{
    public function test_create_on_ramp_transaction()
    {
        // Fake the HTTP response
        Http::fake([
            '*' => Http::response([
                'transaction_id' => 'tx123',
                'amount' => 100,
                'fiat_currency' => 'NGN',
                'status' => 'pending'
            ], 200)
        ]);

        $client = new LinkIOClient(); // if needed, set config manually
        $service = new OnRampService($client);

        $dto = $service->createOnRampTransaction('0xABC', 100, 'NGN');
        $this->assertInstanceOf(OnRampTransactionDTO::class, $dto);
        $this->assertEquals('tx123', $dto->transactionId);
        $this->assertEquals('pending', $dto->status);
    }
}
