<?php

namespace Tests;

use App\App;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\BinlistServiceMock;
use Tests\Mocks\ExchangeRatesServiceMock;
use Tests\Mocks\InputReaderServiceMock;

class AppTest extends TestCase
{
    /**
     * @dataProvider runData
     */
    public function testRun(array $inputData, array $rates, array $binCountryCodes, string $expected): void
    {
        (new App(
            new InputReaderServiceMock($inputData),
            new ExchangeRatesServiceMock($rates),
            new BinlistServiceMock($binCountryCodes)
        ))->run('foo');

        $this->expectOutputString($expected);
    }

    public function runData(): array
    {
        return [
            [
                [
                    ['bin' => '45717360', 'amount' => 100.00, 'currency' => 'EUR'],
                    ['bin' => '516793', 'amount' => 50.00, 'currency' => 'USD'],
                    ['bin' => '45417360', 'amount' => 10000.00, 'currency' => 'JPY'],
                    ['bin' => '41417360', 'amount' => 130.00, 'currency' => 'USD'],
                    ['bin' => '4745030', 'amount' => 2000.00, 'currency' => 'GBP'],
                ],
                [
                    'EUR' => 1.0,
                    'USD' => 1.018792,
                    'JPY' => 136.090698,
                    'GBP' => 0.841155,
                ],
                [
                    '45717360' => 'DK',
                    '516793'   => 'LT',
                    '45417360' => 'JP',
                    '41417360' => 'US',
                    '4745030'  => 'GB',
                ],
                $this->formatOutputValues([1.00, 0.50, 1.47, 2.56, 47.56]),
            ],
            [
                [
                    ['bin' => '40567135', 'amount' => 100.00, 'currency' => 'EUR'],
                    ['bin' => '40567135', 'amount' => 500.00, 'currency' => 'PLN'],
                    ['bin' => '40567135', 'amount' => 200.00, 'currency' => 'USD'],
                ],
                [
                    'EUR' => 1.0,
                    'PLN' => 4.87,
                    'USD' => 1.018792,
                ],
                [
                    '40567135' => 'PL',
                ],
                $this->formatOutputValues([1.00, 1.03, 1.97]),
            ],
        ];
    }

    private function formatOutputValues(array $array): string
    {
        return implode(array_map(fn(float $value) => sprintf('%.2f%s', $value, PHP_EOL), $array));
    }
}
