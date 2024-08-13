<?php

require_once __DIR__ . "/../Interfaces/CountriesServiceInterface.php";

class CountriesService implements CountriesServiceInterface
{
    private const EUROPE_COUNTRIES = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
    ];

    public function isEuropeCountry(string $code): bool
    {
        return in_array($code, self::EUROPE_COUNTRIES);
    }
}