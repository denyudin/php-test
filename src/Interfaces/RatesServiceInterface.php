<?php

interface RatesServiceInterface {
    public function getRate(string $currency): float;
    public function hasNoRates(): bool;
}