<?php

require_once __DIR__ . '/../Interfaces/RatesServiceInterface.php';
require_once __DIR__ . '/../Interfaces/BinValuesServiceInterface.php';
require_once __DIR__ . '/../Interfaces/CountriesServiceInterface.php';

class TransactionsService
{
    const COEFFICIENT_REGULAR = 0.02;
    const COEFFICIENT_TARGET = 0.01;
    const TARGET_CURRENCY = 'EUR';

    private RatesServiceInterface $ratesService;
    private BinValuesServiceInterface $binValuesService;
    private CountriesServiceInterface $countriesService;

    public function __construct(
        RatesServiceInterface $ratesService,
        BinValuesServiceInterface $binValuesService,
        CountriesServiceInterface $countriesService
    ) {
        $this->ratesService = $ratesService;
        $this->binValuesService = $binValuesService;
        $this->countriesService = $countriesService;
    }

    public function calcCommission(float $amount, float $rate, string $currency, bool $isEuropeCountry): float
    {
        $amountFixed = $amount;

        if ($currency !== self::TARGET_CURRENCY && $rate > 0) {
            $amountFixed /= $rate;
        }

        return $amountFixed * ($isEuropeCountry ? self::COEFFICIENT_TARGET : self::COEFFICIENT_REGULAR);
    }

    public function calculateCommission(array $row): ?float
    {
        $countryCode = $this->binValuesService->getCountryCodeForBin($row['bin']);

        if (empty($countryCode)) {
            echo "There is no information for BIN = {$row['bin']}\n";
            return null;
        }

        $rate = $this->ratesService->getRate($row['currency']);
        $isEuropeCountry = $this->countriesService->isEuropeCountry($countryCode);

        return $this->calcCommission($row['amount'], $rate, $row['currency'], $isEuropeCountry);
    }
}
