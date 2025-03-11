<?php

namespace EmekaOrjiani\LinkIO\DTOs;

class OffRampTransactionDTO
{
    public string $transactionId;
    public float $cryptoAmount;
    public string $cryptoCurrency;
    public float $fiatAmount;
    public string $fiatCurrency;
    public string $recipientBankAccount;
    public string $status;
    public string $createdAt;
    public ?string $completedAt;
    public array $raw;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->transactionId       = $data['transaction_id'] ?? '';
        $dto->cryptoAmount        = (float) ($data['crypto_amount'] ?? 0);
        $dto->cryptoCurrency      = $data['crypto_currency'] ?? '';
        $dto->fiatAmount          = (float) ($data['fiat_amount'] ?? 0);
        $dto->fiatCurrency        = $data['fiat_currency'] ?? '';
        $dto->recipientBankAccount = $data['recipient_bank_account'] ?? '';
        $dto->status              = $data['status'] ?? 'pending';
        $dto->createdAt           = $data['created_at'] ?? '';
        $dto->completedAt         = $data['completed_at'] ?? null;
        $dto->raw                 = $data;
        return $dto;
    }
}
