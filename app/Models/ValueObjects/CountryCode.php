<?php

namespace App\Models\ValueObjects;

use Exception;

class CountryCode
{
    private string $value;

    public function __construct(string $value)
    {
        if (preg_match('/[A-Z]{2}/', $value) !== 1) {
            throw new Exception(sprintf('Invalid value for CountryCode provided "%s"', $value));
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEU(): bool
    {
        return in_array($this->getValue(), ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'EL', 'ES', 'FI', 'FR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK']);
    }
}
