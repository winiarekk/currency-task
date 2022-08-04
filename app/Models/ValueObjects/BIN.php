<?php

namespace App\Models\ValueObjects;

use Exception;

class BIN
{
    private string $value;

    public function __construct(string $value)
    {
        if (preg_match('/[0-9]{6,8}/', $value) !== 1) {
            throw new Exception(sprintf('Invalid value for BIN provided "%s"', $value));
        }

        $this->value = $value;
    }

    public function getValue() : string
    {
        return $this->value;
    }
}
