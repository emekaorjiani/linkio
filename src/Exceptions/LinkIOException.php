<?php

namespace EmekaOrjiani\LinkIO\Exceptions;

use Exception;

class LinkIOException extends Exception
{
    /**
     * The HTTP status code returned by LinkIO (optional).
     *
     * @var int|null
     */
    protected ?int $statusCode;

    /**
     * The raw response from LinkIO (optional).
     *
     * @var mixed
     */
    protected $response;

    /**
     * LinkIOException constructor.
     *
     * @param string $message
     * @param int|null $statusCode
     * @param mixed $response
     */
    public function __construct(string $message = "An error occurred while communicating with LinkIO", ?int $statusCode = null, $response = null)
    {
        parent::__construct($message, $statusCode);

        $this->statusCode = $statusCode;
        $this->response   = $response;
    }

    /**
     * Get the HTTP status code returned by LinkIO (if any).
     *
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * Get the raw response returned by LinkIO (if any).
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Convert the exception to a JSON array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'message'    => $this->getMessage(),
            'statusCode' => $this->getStatusCode(),
            'response'   => $this->getResponse(),
        ];
    }
}
