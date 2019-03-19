<?php

require_once 'Formatters/Formatter.php';
require_once 'Csv.php';

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

        foreach ($csv as $row) {
            $this->transactions[] = $formatter->formatRow($row);
        }
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
