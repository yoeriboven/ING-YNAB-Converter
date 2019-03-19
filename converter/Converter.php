<?php

namespace App;

use App\Formatters\Formatter;

class Converter
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
    public function formatFile($input, Formatter $formatter)
    {
        $csv = CSV::readInput($input);

        $this->transactions = collect($csv)->map(function ($row) use ($formatter) {
            return $formatter->formatRow($row);
        });
    }


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
