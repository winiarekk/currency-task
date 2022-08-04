<?php

namespace App;

use App\Interfaces\BinlistServiceInterface;
use App\Interfaces\ExchangeRatesServiceInterface;
use App\Interfaces\InputReaderServiceInterface;
use App\Models\InputData;

class App
{
    private InputReaderServiceInterface $inputReaderService;

    private ExchangeRatesServiceInterface $exchangeRatesService;

    private BinlistServiceInterface $binlistService;

    public function __construct(InputReaderServiceInterface $inputReaderService, ExchangeRatesServiceInterface $exchangeRatesService, BinlistServiceInterface $binlistService)
    {
        $this->inputReaderService = $inputReaderService;
        $this->exchangeRatesService = $exchangeRatesService;
        $this->binlistService = $binlistService;
    }

    public function run(string $filename): void
    {
        $inputData = $this->inputReaderService->read($filename);
        $exchangeRates = $this->exchangeRatesService->getRates(array_map(fn(InputData $data) => $data->getCurrency(), $inputData));

        foreach ($inputData as $data) {
            $countryCode = $this->binlistService->getCountryCode($data->getBin());
            $amountInBaseCurrency = $exchangeRates->exchange($data->getAmount(), $data->getCurrency());
            $commission = $amountInBaseCurrency->getValue() * ($countryCode->isEU() ? 0.01 : 0.02);

            echo sprintf("%.2f%s", ceil($commission * 100) / 100, PHP_EOL);
        }
    }
}
