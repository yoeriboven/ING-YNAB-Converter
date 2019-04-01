<?php

namespace App\Converters;

use App\CSV;
use App\Formatters\Formatter;

class CSVConverter extends Converter
{
    /**
     * Normalizes the transaction data
     */
    public function formatFile($input, Formatter $formatter)
    {
        $csv = CSV::readInput($input);

        $this->transactions = collect($csv)->map(function ($row) use ($formatter) {
            return $formatter->formatRow($row);
        });
    }
}
