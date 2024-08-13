# Php-test

## Installation 

1) Clone project
2) run `cp .env.example .env`
3) run `php src/test.php src/input.txt`

## Tests

1) run `./vendor/bin/phpunit`


### FYI
This test app will try to get data from https://lookup.binlist.net/ (https://binlist.net/), in case of error (because of limitation 5 requests per hour) data will be mocked from `src/binlist.txt`
