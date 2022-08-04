<?php

use App\App;
use App\Factories\ExchangeRatesFactory;
use App\Models\ValueObjects\Currency;
use App\Services\BinlistService;
use App\Services\ExchangeRatesService;
use App\Services\InputReaderService;
use GuzzleHttp\Client;

require_once('./vendor/autoload.php');

(new App(
    new InputReaderService(),
    new ExchangeRatesService(
        'https://api.apilayer.com/exchangerates_data/latest',
        'VuVzyHvnSRP3KRjsuYBxoJTAnd043cOs',
        new Client(),
        new ExchangeRatesFactory(),
        new Currency('EUR')
    ),
    new BinlistService('https://lookup.binlist.net', new Client())
))->run($argv[1]);
