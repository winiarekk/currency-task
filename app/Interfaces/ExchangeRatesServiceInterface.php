<?php

namespace App\Interfaces;

use App\Models\ExchangeRates;

interface ExchangeRatesServiceInterface
{
    public function getRates(array $currencies): ExchangeRates;
}
