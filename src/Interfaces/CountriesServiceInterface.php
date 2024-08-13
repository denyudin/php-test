<?php

interface CountriesServiceInterface {
    public function isEuropeCountry(string $code): bool;
}
