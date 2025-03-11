<?php

namespace EmekaOrjiani\LinkIO\DTOs;

class RateDTO
{
    public string $baseCurrency;     // NGN, USD, etc.
    public string $quoteCurrency;    // BTC, USDT, etc.
    public string $rateType;         // onramp, offramp, otc_buy, otc_sell, bridge
    public float $rate;              // Exchange rate
    public ?float $minAmount;        // Optional
    public ?float $maxAmount;        // Optional
    public array $raw;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->baseCurrency = $data['base_currency'] ?? '';
        $dto->quoteCurrency = $data['quote_currency'] ?? '';
        $dto->rateType = $data['rate_type'] ?? 'onramp';
        $dto->rate = (float) ($data['rate'] ?? 0);
        $dto->minAmount = isset($data['min_amount']) ? (float) $data['min_amount'] : null;
        $dto->maxAmount = isset($data['max_amount']) ? (float) $data['max_amount'] : null;
        $dto->raw = $data;
        return $dto;
    }
}
