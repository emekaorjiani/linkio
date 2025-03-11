<?php

namespace EmekaOrjiani\LinkIO\Services;

use Illuminate\Support\Facades\Http;
use EmekaOrjiani\LinkIO\Exceptions\LinkIOException;

class LinkIOClient
{
    protected string $apiKey;
    protected string $apiSecret;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey    = config('linkio.api_key');
        $this->apiSecret = config('linkio.api_secret');
        $this->baseUrl   = rtrim(config('linkio.base_url'), '/');
    }

    /**
     * Send a GET request to LinkIO API.
     *
     * @param string $endpoint
     * @param array $query
     * @return array
     * @throws LinkIOException
     */
    public function get(string $endpoint, array $query = []): array
    {
        $url = "{$this->baseUrl}/{$endpoint}";

        $response = Http::withHeaders($this->defaultHeaders())
                        ->get($url, $query);

        return $this->handleResponse($response);
    }

    /**
     * Send a POST request to LinkIO API.
     *
     * @param string $endpoint
     * @param array $data
     * @return array
     * @throws LinkIOException
     */
    public function post(string $endpoint, array $data = []): array
    {
        $url = "{$this->baseUrl}/{$endpoint}";

        $response = Http::withHeaders($this->defaultHeaders())
                        ->post($url, $data);

        return $this->handleResponse($response);
    }

    /**
     * Handle the API response and throw exceptions if needed.
     *
     * @param \Illuminate\Http\Client\Response $response
     * @return array
     * @throws LinkIOException
     */
    protected function handleResponse($response): array
    {
        if ($response->failed()) {
            throw new LinkIOException(
                $response->json('message') ?? 'LinkIO request failed.',
                $response->status(),
                $response->json()
            );
        }

        return $response->json();
    }

    /**
     * Default headers for every request.
     *
     * @return array
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
            // Or 'ngnc-sec-key' => $this->apiKey; if LinkIO requires it.
        ];
    }
}
