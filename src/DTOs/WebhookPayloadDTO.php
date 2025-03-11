<?php

namespace EmekaOrjiani\LinkIO\DTOs;

use Illuminate\Http\Request;

final class WebhookPayloadDTO
{
    public string $eventType;
    public string $transactionId;
    public ?string $status;
    public string $resource;
    public string $triggeredAt;
    public array $payload;
    public array $raw;

    public static function fromRequest(Request $request): self
    {
        $data = $request->all();

        $dto = new self();

        $dto->eventType     = (string) ($data['event_type'] ?? '');
        $dto->transactionId = (string) ($data['transaction_id'] ?? '');
        $dto->status        = $data['status'] ?? null;
        $dto->resource      = (string) ($data['resource'] ?? 'unknown');
        $dto->triggeredAt   = (string) ($data['triggered_at'] ?? now()->toISOString());
        $dto->payload       = $data['payload'] ?? [];
        $dto->raw           = $data;

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'event_type'     => $this->eventType,
            'transaction_id' => $this->transactionId,
            'status'         => $this->status,
            'resource'       => $this->resource,
            'triggered_at'   => $this->triggeredAt,
            'payload'        => $this->payload,
        ];
    }
}
