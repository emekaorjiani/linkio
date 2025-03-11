<?php

namespace EmekaOrjiani\LinkIO\DTOs;

final class BridgeTransactionDTO
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

        $dto->transactionId       = (string) ($data['transaction_id'] ?? '');
        $dto->sourceAmount        = isset($data['source_amount']) ? (float) $data['source_amount'] : 0.0;
        $dto->sourceCurrency      = (string) ($data['source_currency'] ?? '');
        $dto->sourceNetwork       = (string) ($data['source_network'] ?? '');
        $dto->destinationAmount   = isset($data['destination_amount']) ? (float) $data['destination_amount'] : 0.0;
        $dto->destinationCurrency = (string) ($data['destination_currency'] ?? '');
        $dto->destinationNetwork  = (string) ($data['destination_network'] ?? '');
        $dto->status              = (string) ($data['status'] ?? 'pending');
        $dto->createdAt           = (string) ($data['created_at'] ?? now()->toISOString());
        $dto->completedAt         = $data['completed_at'] ?? null;

        $dto->raw = $data;

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'transaction_id'       => $this->transactionId,
            'source_amount'        => $this->sourceAmount,
            'source_currency'      => $this->sourceCurrency,
            'source_network'       => $this->sourceNetwork,
            'destination_amount'   => $this->destinationAmount,
            'destination_currency' => $this->destinationCurrency,
            'destination_network'  => $this->destinationNetwork,
            'status'               => $this->status,
            'created_at'           => $this->createdAt,
            'completed_at'         => $this->completedAt,
        ];
    }
}
