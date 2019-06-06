<?php

namespace Yoeriboven\YNABConverter\Converters;

use Yoeriboven\YNABConverter\CSV;
use Yoeriboven\YNABConverter\Formatters\Formatter;

abstract class Converter
{
    /**
     * Contains formatted arrays of transactions
     *
     * @var array
     */
    protected $transactions = [];

    /**
     * Normalizes the transaction data
     */
    abstract public function formatFile($input, Formatter $formatter);

    /**
     * Writes all transactions to a csv file
     *
     * @param  string $output
     */
    public function saveToFile($output)
    {
        CSV::saveToFile($this->transactions, $output);
    }

    /**
     * Writes all transactions to a csv file
     * which is immediately downloaded by the user
     *
     * @param  string $output
     */
    public function downloadFile($output)
    {
        CSV::downloadFile($this->transactions, $output);
    }
}
