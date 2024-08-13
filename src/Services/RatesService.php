<?php

require_once __DIR__ . "/../Interfaces/RatesServiceInterface.php";
require_once __DIR__ . "/CurlHandler.php";

class RatesService implements RatesServiceInterface
{
    private array $rates = [];
    private CurlHandler $curlHandler;

    public function __construct(array $env, CurlHandler $curlHandler)
    {
        $this->curlHandler = $curlHandler;
        $this->rates = $this->fetchRates($env);
    }

    private function fetchRates(array $env): array
    {
        $result = [];

        try {
            $response = $this->curlHandler->execute(
                $env['RATESERVICE_API_URL'],
                [
                    "Content-Type: text/plain",
                    "apikey: {$env['RATESERVICE_API_KEY']}"
                ]
            );

            $result = json_decode($response, true)['rates'] ?? [];
        } catch (Exception $e) {
            echo('RatesService->fetchRates(). Exception: ' . $e->getMessage());
        }

        return $result;
    }

    public function hasNoRates(): bool
    {
        return empty($this->rates);
    }

    public function getRate(string $currency): float
    {
        return $this->rates[$currency] ?? 0.0;
    }
}
