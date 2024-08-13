<?php

require_once __DIR__ . '/Services/BinValuesService.php';
require_once __DIR__ . '/Services/CountriesService.php';
require_once __DIR__ . '/Services/RatesService.php';
require_once __DIR__ . '/Services/TransactionsService.php';
require_once __DIR__ . '/Services/CurlHandler.php';


$env = parse_ini_file('.env');
$curlHandler = new CurlHandler();
$ratesService = new RatesService($env, $curlHandler);

if ($ratesService->hasNoRates()) {
    exit("No rates information.\n");
}

$countriesService = new CountriesService();
$binValuesService = new BinValuesService($env["BINLIST_API_URL"], $env["BINLIST_PRELOAD_API_FILE"]);
$transactionsService = new TransactionsService($ratesService, $binValuesService, $countriesService);

$inputRows = explode("\n", file_get_contents($argv[1]));

foreach ($inputRows as $row) {
    if (empty(trim($row))) {
        continue;
    }

    $inputValues = json_decode($row, true);

    $commission = $transactionsService->calculateCommission($inputValues);

    if ($commission !== null) {
        echo sprintf('%0.2f', $commission) . "\n";
    }
}
