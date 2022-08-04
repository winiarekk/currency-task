<?php

namespace App\Factories;

use App\Models\ExchangeRates;
use App\Models\ValueObjects\Currency;
use App\Models\ValueObjects\ExchangeRate;
use App\Models\ValueObjects\Multiplier;

class ExchangeRatesFactory
{
    public function createExchangeRate(string $currency, float $multiplier): ExchangeRate
    {
        return new ExchangeRate(
            new Currency($currency),
            new Multiplier($multiplier)
        );
    }

    public function createExchangeRates(array $data): ExchangeRates
    {
        $rates = [];

        foreach($data as $currency => $multiplier) {
            $rates[$currency] = $this->createExchangeRate($currency, $multiplier);
        }

        return new ExchangeRates($rates);
    }
}
