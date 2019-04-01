<?php

require __DIR__ . '/vendor/autoload.php';

use App\Converters\CSVConverter;
use App\Formatters\INGFormatter;

$input = 'input.csv';
$output = 'output.csv';

/* If run from command line, the second argument is the input file */
if (php_sapi_name() == "cli") {
    if ($argc != 2) {
        die('No input given'.PHP_EOL);
    }

    $input = $argv[1];
}

$converter = new CSVConverter();
$converter->formatFile($input, new INGFormatter());
$converter->saveToFile($output);
