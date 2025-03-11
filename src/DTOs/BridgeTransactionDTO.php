<?php

namespace EmekaOrjiani\LinkIO\DTOs;

class BridgeTransactionDTO
{
    public string $transactionId;
    public float $sourceAmount;
    public string $sourceCurrency;
    public string $sourceNetwork;
    public float $destinationAmount;
    public string $destinationCurrency;
    public string $destinationNetwork;
    public string $status;
    public string $createdAt;
    public ?string $completedAt;
    public array $raw;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->transactionId       = $data['transaction_id'] ?? '';
        $dto->sourceAmount        = (float) ($data['source_amount'] ?? 0);
        $dto->sourceCurrency      = $data['source_currency'] ?? '';
        $dto->sourceNetwork       = $data['source_network'] ?? '';
        $dto->destinationAmount   = (float) ($data['destination_amount'] ?? 0);
        $dto->destinationCurrency = $data['destination_currency'] ?? '';
        $dto->destinationNetwork  = $data['destination_network'] ?? '';
        $dto->status              = $data['status'] ?? 'pending';
        $dto->createdAt           = $data['created_at'] ?? '';
        $dto->completedAt         = $data['completed_at'] ?? null;
        $dto->raw                 = $data;
        return $dto;
    }
}
