<?php

namespace EmekaOrjiani\LinkIO\DTOs;

use Illuminate\Http\Request;

class WebhookPayloadDTO
{
    public string $eventType;         // e.g., transaction.completed, transaction.failed
    public string $transactionId;
    public ?string $status;
    public string $resource;          // onramp, offramp, bridge
    public array $payload;            // The whole payload
    public string $triggeredAt;       // Time of event trigger (optional)
    public array $raw;                // The full raw data

    public static function fromRequest(Request $request): self
    {
        $data = $request->all();

        $dto = new self();
        $dto->eventType = $data['event_type'] ?? '';
        $dto->transactionId = $data['transaction_id'] ?? '';
        $dto->status = $data['status'] ?? null;
        $dto->resource = $data['resource'] ?? 'unknown';
        $dto->triggeredAt = $data['triggered_at'] ?? now()->toISOString();
        $dto->payload = $data['payload'] ?? [];
        $dto->raw = $data;

        return $dto;
    }
}
