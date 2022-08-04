<?php

namespace Tests\Mocks;

use App\Factories\ExchangeRatesFactory;
use App\Interfaces\ExchangeRatesServiceInterface;
use App\Models\ExchangeRates;

class ExchangeRatesServiceMock implements ExchangeRatesServiceInterface
{
    private array $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function getRates(array $currencies): ExchangeRates
    {
        return (new ExchangeRatesFactory())->createExchangeRates($this->values);
    }
}
