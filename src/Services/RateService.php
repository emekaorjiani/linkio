<?php

namespace EmekaOrjiani\LinkIO\Services;

use EmekaOrjiani\LinkIO\DTOs\RateDTO;

class RatesService
{
    protected LinkIOClient $client;

    public function __construct(LinkIOClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get on-ramp rates.
     *
     * @param string $fiatCurrency
     * @param string $cryptoCurrency
     * @param array $options
     * @return RateDTO
     */
    public function getOnRampRates(string $fiatCurrency, string $cryptoCurrency, array $options = []): RateDTO
    {
        $query = array_merge([
            'fiat_currency'   => $fiatCurrency,
            'crypto_currency' => $cryptoCurrency,
        ], $options);

        $response = $this->client->get('rates/onramp', $query);

        return RateDTO::fromArray($response);
    }

    /**
     * Get off-ramp rates.
     *
     * @param string $cryptoCurrency
     * @param string $fiatCurrency
     * @param array $options
     * @return RateDTO
     */
    public function getOffRampRates(string $cryptoCurrency, string $fiatCurrency, array $options = []): RateDTO
    {
        $query = array_merge([
            'crypto_currency' => $cryptoCurrency,
            'fiat_currency'   => $fiatCurrency,
        ], $options);

        $response = $this->client->get('rates/offramp', $query);

        return RateDTO::fromArray($response);
    }

    /**
     * Get bridge rates.
     *
     * @param string $sourceCurrency
     * @param string $destinationCurrency
     * @param string $sourceNetwork
     * @param string $destinationNetwork
     * @param array $options
     * @return RateDTO
     */
    public function getBridgeRates(
        string $sourceCurrency,
        string $destinationCurrency,
        string $sourceNetwork,
        string $destinationNetwork,
        array $options = []
    ): RateDTO
    {
        $query = array_merge([
            'source_currency'      => $sourceCurrency,
            'destination_currency' => $destinationCurrency,
            'source_network'       => $sourceNetwork,
            'destination_network'  => $destinationNetwork,
        ], $options);

        $response = $this->client->get('rates/bridge', $query);

        return RateDTO::fromArray($response);
    }

    /**
     * Get OTC buy rates.
     *
     * @param string $fiatCurrency
     * @param string $cryptoCurrency
     * @param array $options
     * @return RateDTO
     */
    public function getOTCBuyRates(string $fiatCurrency, string $cryptoCurrency, array $options = []): RateDTO
    {
        $query = array_merge([
            'fiat_currency'   => $fiatCurrency,
            'crypto_currency' => $cryptoCurrency,
        ], $options);

        $response = $this->client->get('rates/otc-buy', $query);

        return RateDTO::fromArray($response);
    }

    /**
     * Get OTC sell rates.
     *
     * @param string $cryptoCurrency
     * @param string $fiatCurrency
     * @param array $options
     * @return RateDTO
     */
    public function getOTCSellRates(string $cryptoCurrency, string $fiatCurrency, array $options = []): RateDTO
    {
        $query = array_merge([
            'crypto_currency' => $cryptoCurrency,
            'fiat_currency'   => $fiatCurrency,
        ], $options);

        $response = $this->client->get('rates/otc-sell', $query);

        return RateDTO::fromArray($response);
    }
}
