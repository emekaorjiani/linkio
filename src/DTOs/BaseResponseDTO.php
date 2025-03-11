<?php

namespace EmekaOrjiani\LinkIO\DTOs;

final class BaseResponseDTO
{
    public bool $success;
    public ?string $message;
    public ?array $errors;
    public mixed $data;

    public static function fromArray(array $response): self
    {
        $dto = new self();

        $dto->success = (bool) ($response['success'] ?? true);
        $dto->message = $response['message'] ?? null;
        $dto->errors  = $response['errors'] ?? null;
        $dto->data    = $response['data'] ?? null;

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'errors'  => $this->errors,
            'data'    => $this->data,
        ];
    }
}
