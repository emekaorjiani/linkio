<?php

namespace EmekaOrjiani\LinkIO\DTOs;

class BaseResponseDTO
{
    public bool $success;
    public ?string $message;
    public ?array $errors;
    public mixed $data;

    public static function fromArray(array $response): self
    {
        $dto = new self();
        $dto->success = $response['success'] ?? true;
        $dto->message = $response['message'] ?? '';
        $dto->errors  = $response['errors'] ?? null;
        $dto->data    = $response['data'] ?? null;
        return $dto;
    }
}
