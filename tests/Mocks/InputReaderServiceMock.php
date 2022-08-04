<?php

namespace Tests\Mocks;

use App\Interfaces\InputReaderServiceInterface;
use App\Models\InputData;
use App\Models\ValueObjects\Amount;
use App\Models\ValueObjects\BIN;
use App\Models\ValueObjects\Currency;

class InputReaderServiceMock implements InputReaderServiceInterface
{
    private array $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function read(string $filename): array
    {
        return array_map(fn(array $rawData) => new InputData(
            new BIN($rawData['bin']),
            new Amount($rawData['amount']),
            new Currency($rawData['currency']),
        ), $this->values);
    }
}
