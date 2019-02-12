<?php

namespace Invertus\PsTraining\Tests\Unit\Currency;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\ResponseInterface;
use Invertus\PsTraining\Currency\ExchangeRatesCurrencyRateUpdater;
use Invertus\PsTraining\Currency\RateNotFoundException;
use PHPUnit\Framework\TestCase;

class ExchangeRatesCurrencyRateUpdaterTest extends TestCase
{
    public function test_exchange_rate_is_being_updated()
    {
        $exchangeRateUpdater = new ExchangeRatesCurrencyRateUpdater($this->createMockedClient());

        $newEURRate = $exchangeRateUpdater->update('EUR');
        $newGBPRate = $exchangeRateUpdater->update('GBP');
        $newUSDRate = $exchangeRateUpdater->update('USD');

        $this->assertEquals(0.8842514811, $newEURRate);
        $this->assertEquals(0.7747369352, $newGBPRate);
        $this->assertEquals(1, $newUSDRate);
    }

    public function test_it_throws_exception_when_exchange_rate_is_not_found()
    {
        $this->expectException(RateNotFoundException::class);

        $exchangeRateUpdater = new ExchangeRatesCurrencyRateUpdater($this->createMockedClient());

        $exchangeRateUpdater->update('AAA');
    }

    private function createMockedClient()
    {
        $fakeResponse = $this->createMock(ResponseInterface::class);
        $fakeResponse->method('getBody')
            ->willReturn($this->getFakeResponseBody())
        ;

        $mockClient = $this->createMock(ClientInterface::class);
        $mockClient->method('get')
            ->willReturn($fakeResponse)
        ;

        return $mockClient;
    }

    private function getFakeResponseBody()
    {
        return '{
            "base": "USD",
            "date": "2019-02-11",
            "rates": {
                "ISK": 120.7887523212,
                "CAD": 1.3268193474,
                "MXN": 19.0916084534,
                "CHF": 1.0037138562,
                "AUD": 1.4132991423,
                "CNY": 6.7893712972,
                "GBP": 0.7747369352,
                "USD": 1,
                "SEK": 9.2720841807,
                "NOK": 8.6824652931,
                "TRY": 5.2690777257,
                "IDR": 14080.8647979485,
                "ZAR": 13.7363162083,
                "HRK": 6.5500928464,
                "EUR": 0.8842514811,
                "HKD": 7.847731895,
                "ILS": 3.6427624016,
                "NZD": 1.4827128835,
                "MYR": 4.0725086215,
                "JPY": 110.2042620921,
                "CZK": 22.8455212662,
                "SGD": 1.3585639756,
                "RUB": 65.5880272349,
                "RON": 4.1917941463,
                "HUF": 282.6598284552,
                "BGN": 1.7294190468,
                "INR": 71.1362631532,
                "KRW": 1125.2984348749,
                "DKK": 6.5997877796,
                "THB": 31.4201078787,
                "PHP": 52.1478468476,
                "PLN": 3.8162525422,
                "BRL": 3.7377310107
            }
        }';
    }
}
