<?php

namespace EmekaOrjiani\LinkIO\Services;

use EmekaOrjiani\LinkIO\DTOs\OffRampTransactionDTO;

class OffRampService
{
    protected LinkIOClient $client;

    public function __construct(LinkIOClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create an off-ramp transaction (crypto → fiat).
     *
     * @param string $walletAddress
     * @param float $amount
     * @param string $cryptoCurrency
     * @param array $options
     * @return OffRampTransactionDTO
     */
    public function createOffRampTransaction(
        string $walletAddress,
        float $amount,
        string $cryptoCurrency,
        array $options = []
    ): OffRampTransactionDTO
    {
        $payload = array_merge([
            'wallet_address'   => $walletAddress,
            'amount'           => $amount,
            'crypto_currency'  => $cryptoCurrency,
        ], $options);

        $response = $this->client->post('transactions/offramp', $payload);

        return OffRampTransactionDTO::fromArray($response);
    }

    /**
     * Retrieve a single off-ramp transaction by ID.
     *
     * @param string $transactionId
     * @return OffRampTransactionDTO
     */
    public function getOffRampTransaction(string $transactionId): OffRampTransactionDTO
    {
        $response = $this->client->get("transactions/offramp/{$transactionId}");

        return OffRampTransactionDTO::fromArray($response);
    }

    /**
     * List all off-ramp transactions.
     *
     * @param array $filters
     * @return OffRampTransactionDTO[]
     */
    public function listOffRampTransactions(array $filters = []): array
    {
        $response = $this->client->get('transactions/offramp', $filters);

        $transactions = $response['data'] ?? [];

        return array_map(
            fn($tx) => OffRampTransactionDTO::fromArray($tx),
            $transactions
        );
    }
}
