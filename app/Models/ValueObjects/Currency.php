<?php

namespace App\Models\ValueObjects;

use Exception;

class Currency
{
    private string $value;

    public function __construct(string $value)
    {
        if (preg_match('/[A-Z]{3}/', $value) !== 1) {
            throw new Exception(sprintf('Invalid value for Currency provided "%s"', $value));
        }

        $this->value = $value;
    }

    public function getValue() : string
    {
        return $this->value;
    }
}
