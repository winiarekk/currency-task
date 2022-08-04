<?php

namespace App\Services;

use App\Factories\ExchangeRatesFactory;
use App\Interfaces\ExchangeRatesServiceInterface;
use App\Models\ExchangeRates;
use App\Models\ValueObjects\Currency;
use Exception;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class ExchangeRatesService implements ExchangeRatesServiceInterface
{
    private string $url;

    private string $apiKey;

    private ClientInterface $client;

    private ExchangeRatesFactory $factory;

    private Currency $baseCurrency;

    public function __construct(string $url, string $apiKey, ClientInterface $client, ExchangeRatesFactory $factory, Currency $baseCurrency)
    {
        $this->url = $url;
        $this->apiKey = $apiKey;
        $this->client = $client;
        $this->factory = $factory;
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * @return ExchangeRates
     */
    public function getRates(array $currencies): ExchangeRates
    {
        $response = $this->request($currencies);

        if ($response->getStatusCode() !== 200 || !isset(($json = json_decode($response->getBody()->getContents(), true))['rates'])) {
            throw new Exception(sprintf('Exception catched in ExchangeRates Service. Response was: "%s"', $response->getBody()->getContents()));
        }

        return $this->factory->createExchangeRates($json['rates']);
    }

    /**
     * @param Currency[] $currencies
     */
    private function request(array $currencies): ResponseInterface
    {
        return $this->client->request('GET', sprintf(
            '%s?base=%s&symbols=%s',
            $this->url,
            $this->baseCurrency->getValue(),
            implode(',', array_map(fn(Currency $currency) => $currency->getValue(), $currencies))
        ), [
            'headers' => [
                'apikey' => $this->apiKey,
            ],
        ]);
    }
}
