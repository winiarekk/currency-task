<?php

namespace App\Models\ValueObjects;

use Exception;

class Amount
{
    private string $value;

    public function __construct(float $value)
    {
        if ($value <= 0) {
            throw new Exception(sprintf('Invalid value for Amount provided "%f"', $value));
        }

        $this->value = $value;
    }

    public function getValue() : string
    {
        return $this->value;
    }
}
