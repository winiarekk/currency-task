<?php

namespace App\Services;

use App\Interfaces\BinlistServiceInterface;
use App\Models\ValueObjects\BIN;
use App\Models\ValueObjects\CountryCode;
use Exception;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class BinlistService implements BinlistServiceInterface
{
    private string $url;

    private ClientInterface $client;

    public function __construct(string $url, ClientInterface $client)
    {
        $this->url = $url;
        $this->client = $client;
    }

    public function getCountryCode(BIN $bin): CountryCode
    {
        $response = $this->request($bin);

        if ($response->getStatusCode() !== 200 || !isset(($json = json_decode($response->getBody()->getContents(), true))['country']['alpha2'])) {
            throw new Exception(sprintf('Exception catched in Bindlist Service. Response was: "%s"', $response->getBody()->getContents()));
        }

        return new CountryCode($json['country']['alpha2']);
    }

    private function request(BIN $bin): ResponseInterface
    {
        return $this->client->request('GET', sprintf('%s/%s', $this->url, $bin->getValue()));
    }
}
