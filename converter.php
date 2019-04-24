<?php

require __DIR__ . '/vendor/autoload.php';

use App\Converters\CSVConverter;

use App\Formatters\INGFormatter;
use App\Formatters\RaboFormatter;

$input = 'input.csv';
$output = 'output.csv';
$bank = 'ing';

/* If run from command line, the second argument is the input file */
if (php_sapi_name() == "cli") {
    if ($argc < 2) {
        die('No input given'.PHP_EOL);
    }

    $input = $argv[1];
    $bank = $argv[2];
}

$formatters = [
    'ing' => INGFormatter::class,
    'rabobank' => RaboFormatter::class
];

$converter = new CSVConverter();
$converter->formatFile($input, new $formatters[$bank]());
$converter->saveToFile($output);
