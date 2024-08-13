<?php
require_once __DIR__ . '/../src/Services/BinValuesService.php';

use PHPUnit\Framework\TestCase;

class BinValuesServiceTest extends TestCase
{
    private $apiUrl;
    private $preloadFile;

    protected function setUp(): void
    {
        $this->apiUrl = sys_get_temp_dir();

        $this->preloadFile = tempnam(sys_get_temp_dir(), 'preload');
        file_put_contents($this->preloadFile, json_encode([
            "123456" => ["country" => ["alpha2" => "US"]],
            "654321" => ["country" => ["alpha2" => "GB"]],
        ]));
    }

    public function testGetCountryCodeForBinFromApi()
    {
        $bin = "123456";
        $expectedCountryCode = "US";

        $apiResponseFile = $this->apiUrl . "/$bin.json";
        file_put_contents($apiResponseFile, json_encode(["country" => ["alpha2" => $expectedCountryCode]]));

        $service = new BinValuesService($this->apiUrl, $this->preloadFile);
        $result = $service->getCountryCodeForBin($bin);

        $this->assertEquals($expectedCountryCode, $result);

        unlink($apiResponseFile);
    }

    public function testGetCountryCodeForBinFromPreloadFile()
    {
        $bin = "123456";

        $service = new BinValuesService($this->apiUrl, $this->preloadFile);
        $result = $service->getCountryCodeForBin($bin);

        $this->assertEquals("US", $result);
    }

    public function testGetCountryCodeForBinNotFound()
    {
        $bin = "999999";

        $service = new BinValuesService($this->apiUrl, $this->preloadFile);
        $result = $service->getCountryCodeForBin($bin);

        $this->assertNull($result);
    }
}
