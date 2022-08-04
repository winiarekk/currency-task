<?php

namespace App\Models;

use App\Models\ValueObjects\Amount;
use App\Models\ValueObjects\Currency;
use App\Models\ValueObjects\ExchangeRate;
use Exception;

class ExchangeRates
{
    private array $values;

    /**
     * ExchangeRates constructor.
     *
     * @param ExchangeRate[] $values
     */
    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            if (!($value instanceof ExchangeRate)) {
                throw new Exception('Invalid value provided for ExchangeRates, expected ExchangeRate object');
            }

            if ($key !== $value->getCurrency()->getValue()) {
                throw new Exception('Invalid structure of ExchangeRates values. Provided array should be assotiative array, where currencies are the keys of array.');
            }
        }

        $this->values = $values;
    }

    /**
     * @return ExchangeRate[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    public function getForCurrency(Currency $currency): ExchangeRate
    {
        return $this->getValues()[$currency->getValue()];
    }

    public function exchange(Amount $amount, Currency $originalCurrency): Amount
    {
        return new Amount($amount->getValue() / $this->getForCurrency($originalCurrency)->getMultiplier()->getValue());
    }
}
