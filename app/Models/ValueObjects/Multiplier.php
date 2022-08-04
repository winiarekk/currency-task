<?php

namespace App\Models\ValueObjects;

use Exception;

class Multiplier
{
    private float $value;

    public function __construct(float $value)
    {
        if ($value <= 0) {
            throw new Exception(sprintf('Invalid value for Multiplier provided "%f"', $value));
        }

        $this->value = $value;
    }

    public function getValue() : float
    {
        return $this->value;
    }
}
