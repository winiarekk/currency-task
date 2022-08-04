<?php

namespace App\Interfaces;

use App\Models\ValueObjects\BIN;
use App\Models\ValueObjects\CountryCode;

interface BinlistServiceInterface
{
    public function getCountryCode(BIN $bin): CountryCode;
}
