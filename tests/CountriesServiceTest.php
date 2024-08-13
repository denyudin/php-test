<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../src/Services/CountriesService.php";

class CountriesServiceTest extends TestCase
{
    private $countriesService;

    protected function setUp(): void
    {
        $this->countriesService = new CountriesService();
    }

    public function testIsEuropeCountryReturnsTrueForEuropeanCountry(): void
    {
        $europeanCountryCode = 'FR';

        $result = $this->countriesService->isEuropeCountry($europeanCountryCode);

        $this->assertTrue($result, "The method should return true for a European country code.");
    }

    public function testIsEuropeCountryReturnsFalseForNonEuropeanCountry(): void
    {
        $nonEuropeanCountryCode = 'US';

        $result = $this->countriesService->isEuropeCountry($nonEuropeanCountryCode);

        $this->assertFalse($result, "The method should return false for a non-European country code.");
    }

    public function testIsEuropeCountryReturnsFalseForEmptyString(): void
    {
        $emptyCountryCode = '';

        $result = $this->countriesService->isEuropeCountry($emptyCountryCode);

        $this->assertFalse($result, "The method should return false for an empty string.");
    }

    public function testIsEuropeCountryReturnsFalseForInvalidCountryCode(): void
    {
        $invalidCountryCode = 'XX';

        $result = $this->countriesService->isEuropeCountry($invalidCountryCode);

        $this->assertFalse($result, "The method should return false for an invalid country code.");
    }
}
