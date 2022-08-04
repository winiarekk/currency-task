<?php

namespace Tests\Mocks;

use App\Interfaces\BinlistServiceInterface;
use App\Models\ValueObjects\BIN;
use App\Models\ValueObjects\CountryCode;

class BinlistServiceMock implements BinlistServiceInterface
{
    private array $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function getCountryCode(BIN $bin): CountryCode
    {
        return new CountryCode($this->values[$bin->getValue()]);
    }
}
