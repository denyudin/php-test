<?php

require_once __DIR__ . "/../Interfaces/BinValuesServiceInterface.php";

class BinValuesService implements BinValuesServiceInterface
{
    private string $baseApiUrl;
    private string $preloadApiFile;

    public function __construct(string $apiUrl, string $preloadApiFile = null)
    {
        $this->baseApiUrl = $apiUrl;
        $this->preloadApiFile = $preloadApiFile;
    }

    public function getCountryCodeForBin(string $bin): ?string
    {
        $result = null;

        try {
            $rawBinData = @file_get_contents("{$this->baseApiUrl}/$bin");

            if (!$rawBinData && $this->preloadApiFile) {
                $rawBinDataObject = json_decode(file_get_contents("{$this->preloadApiFile}"),true);
                $decodedBinResults = $rawBinDataObject[$bin] ?? '';
            } else {
            	$decodedBinResults = json_decode($rawBinData ?? '', true);
            }
           
            $result = $decodedBinResults['country']['alpha2'] ?? null;
        } catch (Exception $e) {
            echo('BinValuesService->getCountryCodeForBin(). Exception: ' . $e->getMessage());
        }

        return $result;
    }
}
