<?php

namespace EmekaOrjiani\LinkIO\Services;

use EmekaOrjiani\LinkIO\DTOs\OnRampTransactionDTO;

class OnRampService
{
    protected LinkIOClient $client;

    public function __construct(LinkIOClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create an on-ramp transaction (fiat → crypto).
     *
     * @param string $walletAddress
     * @param float $amount
     * @param string $fiatCurrency
     * @param array $options
     * @return OnRampTransactionDTO
     */
    public function createOnRampTransaction(
        string $walletAddress,
        float $amount,
        string $fiatCurrency,
        array $options = []
    ): OnRampTransactionDTO
    {
        $payload = array_merge([
            'wallet_address' => $walletAddress,
            'amount'         => $amount,
            'currency'       => $fiatCurrency,
        ], $options);

        $response = $this->client->post('transactions/onramp', $payload);

        return OnRampTransactionDTO::fromArray($response);
    }

    /**
     * Retrieve a single on-ramp transaction by ID.
     *
     * @param string $transactionId
     * @return OnRampTransactionDTO
     */
    public function getOnRampTransaction(string $transactionId): OnRampTransactionDTO
    {
        $response = $this->client->get("transactions/onramp/{$transactionId}");

        return OnRampTransactionDTO::fromArray($response);
    }

    /**
     * List all on-ramp transactions.
     *
     * @param array $filters
     * @return OnRampTransactionDTO[]
     */
    public function listOnRampTransactions(array $filters = []): array
    {
        $response = $this->client->get('transactions/onramp', $filters);

        $transactions = $response['data'] ?? [];

        return array_map(
            fn($tx) => OnRampTransactionDTO::fromArray($tx),
            $transactions
        );
    }
}
