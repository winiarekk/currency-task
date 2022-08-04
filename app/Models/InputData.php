<?php

namespace App\Models;

use App\Models\ValueObjects\Amount;
use App\Models\ValueObjects\BIN;
use App\Models\ValueObjects\Currency;

class InputData
{
    private BIN $bin;

    private Amount $amount;

    private Currency $currency;

    public function __construct(BIN $bin, Amount $amount, Currency $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getBin(): BIN
    {
        return $this->bin;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

}
