<?php

namespace EmekaOrjiani\LinkIO\DTOs;

final class RateDTO
{
    public string $baseCurrency;
    public string $quoteCurrency;
    public string $rateType;
    public float $rate;
    public ?float $minAmount;
    public ?float $maxAmount;
    public array $raw;

    public static function fromArray(array $data): self
    {
        $dto = new self();

        $dto->baseCurrency  = (string) ($data['base_currency'] ?? '');
        $dto->quoteCurrency = (string) ($data['quote_currency'] ?? '');
        $dto->rateType      = (string) ($data['rate_type'] ?? '');
        $dto->rate          = isset($data['rate']) ? (float) $data['rate'] : 0.0;
        $dto->minAmount     = isset($data['min_amount']) ? (float) $data['min_amount'] : null;
        $dto->maxAmount     = isset($data['max_amount']) ? (float) $data['max_amount'] : null;

        $dto->raw = $data;

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'base_currency'  => $this->baseCurrency,
            'quote_currency' => $this->quoteCurrency,
            'rate_type'      => $this->rateType,
            'rate'           => $this->rate,
            'min_amount'     => $this->minAmount,
            'max_amount'     => $this->maxAmount,
        ];
    }
}
