<?php

namespace EmekaOrjiani\LinkIO\DTOs;

final class OnRampTransactionDTO
{
    public string $transactionId;
    public float $fiatAmount;
    public string $fiatCurrency;
    public float $cryptoAmount;
    public string $cryptoCurrency;
    public string $walletAddress;
    public string $status;
    public string $createdAt;
    public ?string $completedAt;
    public array $raw;

    public static function fromArray(array $data): self
    {
        $dto = new self();

        $dto->transactionId  = (string) ($data['transaction_id'] ?? '');
        $dto->fiatAmount     = isset($data['fiat_amount']) ? (float) $data['fiat_amount'] : 0.0;
        $dto->fiatCurrency   = (string) ($data['fiat_currency'] ?? '');
        $dto->cryptoAmount   = isset($data['crypto_amount']) ? (float) $data['crypto_amount'] : 0.0;
        $dto->cryptoCurrency = (string) ($data['crypto_currency'] ?? '');
        $dto->walletAddress  = (string) ($data['wallet_address'] ?? '');
        $dto->status         = (string) ($data['status'] ?? 'pending');
        $dto->createdAt      = (string) ($data['created_at'] ?? now()->toISOString());
        $dto->completedAt    = $data['completed_at'] ?? null;

        $dto->raw            = $data;

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'transaction_id'   => $this->transactionId,
            'fiat_amount'      => $this->fiatAmount,
            'fiat_currency'    => $this->fiatCurrency,
            'crypto_amount'    => $this->cryptoAmount,
            'crypto_currency'  => $this->cryptoCurrency,
            'wallet_address'   => $this->walletAddress,
            'status'           => $this->status,
            'created_at'       => $this->createdAt,
            'completed_at'     => $this->completedAt,
        ];
    }
}
