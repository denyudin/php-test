<?php

interface BinValuesServiceInterface {
    public function getCountryCodeForBin(string $bin): ?string;
}
