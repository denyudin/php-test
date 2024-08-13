<?php

require_once __DIR__ . "/../src/Services/CurlHandler.php";
require_once __DIR__ . "/../src/Services/RatesService.php";
use PHPUnit\Framework\TestCase;

class RatesServiceTest extends TestCase
{
    public function testFetchRatesReturnsCorrectData()
    {
        $mockCurlHandler = $this->createMock(CurlHandler::class);

        $mockCurlHandler->method('execute')
            ->willReturn(json_encode([
                'rates' => [
                    'USD' => 1.0,
                    'EUR' => 0.85,
                ]
            ]));

        $env = [
            'RATESERVICE_API_URL' => 'http://mockapi.com/rates',
            'RATESERVICE_API_KEY' => 'mockapikey',
        ];

        $service = new RatesService($env, $mockCurlHandler);

        $this->assertFalse($service->hasNoRates());
        $this->assertEquals(1.0, $service->getRate('USD'));
        $this->assertEquals(0.85, $service->getRate('EUR'));
        $this->assertEquals(0.0, $service->getRate('GBP'));
    }

    public function testFetchRatesHandlesEmptyResponse()
    {
        $mockCurlHandler = $this->createMock(CurlHandler::class);

        $mockCurlHandler->method('execute')
            ->willReturn(json_encode([]));

        $env = [
            'RATESERVICE_API_URL' => 'http://mockapi.com/rates',
            'RATESERVICE_API_KEY' => 'mockapikey',
        ];

        $service = new RatesService($env, $mockCurlHandler);

        $this->assertTrue($service->hasNoRates());
    }
}
