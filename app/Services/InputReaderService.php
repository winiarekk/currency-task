<?php

namespace App\Services;

use App\Interfaces\InputReaderServiceInterface;
use App\Models\InputData;
use App\Models\ValueObjects\Amount;
use App\Models\ValueObjects\BIN;
use App\Models\ValueObjects\Currency;
use Exception;

class InputReaderService implements InputReaderServiceInterface
{
    /**
     * @inheritDoc
     */
    public function read(string $filename): array
    {
        $resource = fopen($filename, 'r');

        $result = [];

        while ($line = fgets($resource)) {
            try {
                $result[] = $this->readLine($line);
            } catch (Exception $exception) {
                echo sprintf('WARNING: Exception catched with message "%s". Skipping the line.%s', $exception->getMessage(), PHP_EOL);
            }
        }

        return $result;
    }

    private function readLine(string $json): InputData
    {
        $rawData = json_decode($json, true);

        if (!is_array($rawData) || !isset($rawData['bin'], $rawData['amount'], $rawData['currency'])) {
            throw new Exception(sprintf('Invalid input data provided "%s"', trim($json)));
        }

        return new InputData(
            new BIN($rawData['bin']),
            new Amount($rawData['amount']),
            new Currency($rawData['currency']),
        );
    }
}
