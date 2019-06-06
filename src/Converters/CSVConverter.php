<?php

namespace Yoeriboven\YNABConverter\Converters;

use Yoeriboven\YNABConverter\CSV;
use Yoeriboven\YNABConverter\Formatters\Formatter;

class CSVConverter extends Converter
{
    /**
     * Normalizes the transaction data
     */
    public function formatFile($input, Formatter $formatter)
    {
        $csv = CSV::readInput($input);

        $this->transactions = collect($csv)->map(function ($row) use ($formatter) {
            return $formatter->getFormattedTransaction($row);
        });
    }
}
