<?php

namespace App\Models\ValueObjects;

class ExchangeRate
{
    private Currency $currency;

    private Multiplier $multiplier;

    public function __construct(Currency $currency, Multiplier $multiplier)
    {
        $this->currency = $currency;
        $this->multiplier = $multiplier;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getMultiplier(): Multiplier
    {
        return $this->multiplier;
    }
}
