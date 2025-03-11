<?php

namespace EmekaOrjiani\LinkIO\Services;

use EmekaOrjiani\LinkIO\DTOs\BridgeTransactionDTO;

class BridgeService
{
    protected LinkIOClient $client;

    public function __construct(LinkIOClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a bridge transaction (token/network → token/network).
     *
     * @param string $walletAddress
     * @param float $sourceAmount
     * @param string $sourceCurrency
     * @param string $sourceNetwork
     * @param string $destinationCurrency
     * @param string $destinationNetwork
     * @param array $options
     * @return BridgeTransactionDTO
     */
    public function createBridgeTransaction(
        string $walletAddress,
        float $sourceAmount,
        string $sourceCurrency,
        string $sourceNetwork,
        string $destinationCurrency,
        string $destinationNetwork,
        array $options = []
    ): BridgeTransactionDTO
    {
        $payload = array_merge([
            'wallet_address'       => $walletAddress,
            'source_amount'        => $sourceAmount,
            'source_currency'      => $sourceCurrency,
            'source_network'       => $sourceNetwork,
            'destination_currency' => $destinationCurrency,
            'destination_network'  => $destinationNetwork,
        ], $options);

        $response = $this->client->post('transactions/bridge', $payload);

        return BridgeTransactionDTO::fromArray($response);
    }

    /**
     * Retrieve a single bridge transaction by ID.
     *
     * @param string $transactionId
     * @return BridgeTransactionDTO
     */
    public function getBridgeTransaction(string $transactionId): BridgeTransactionDTO
    {
        $response = $this->client->get("transactions/bridge/{$transactionId}");

        return BridgeTransactionDTO::fromArray($response);
    }

    /**
     * List all bridge transactions.
     *
     * @param array $filters
     * @return BridgeTransactionDTO[]
     */
    public function listBridgeTransactions(array $filters = []): array
    {
        $response = $this->client->get('transactions/bridge', $filters);

        $transactions = $response['data'] ?? [];

        return array_map(
            fn($tx) => BridgeTransactionDTO::fromArray($tx),
            $transactions
        );
    }
}
