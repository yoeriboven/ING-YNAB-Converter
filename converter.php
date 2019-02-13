<?php

$input = 'input.csv';
$output = 'output.csv';

/* If run from command line, the second argument is the input file */
if (php_sapi_name() == "cli") {
    if ($argc != 2) {
        die('No input given'.PHP_EOL);
    }

    $input = $argv[1];
}

$converter = new Converter();
$converter->convertFile($input);
$converter->saveTo($output);

class Converter
{
    /**
     * Turns your vague payees into
     * something more understandable.
     *
     * Edit this array for your own customization
     *
     * Example:
     * [
     *     "BOL.COM BV" => "Bol.com",
     *     "BELASTINGDIENST" => "Belastingdienst",
     *     "Videoland door Buckaroo" => "Videoland"
     * ]
     *
     *
     * @var array
     */
    protected $payeesList = [

    ];


    /**
     * Contains formatted arrays of transactions
     *
     * @var array
     */
    protected $transactions = [];


    /**
     * Normalizes the transaction data
     */
    public function convertFile($input)
    {
        $csv = $this->readInput($input);

        foreach ($csv as $row) {
            $transaction = [];
            $transaction[0] = $this->formatDate($row[0]); // Date
            $transaction[1] = $this->formatPayee($row[1]); // Payee
            $transaction[2] = $this->formatMemo($row); // Memo

            $transaction = array_merge($transaction, $this->getAmount($row[5], $row[6])); // Inflow and outflow

            $this->transactions[] = $transaction;
        }
    }


    /**
     * Writes all transactions to a csv file
     *
     * @param  string $output
     */
    public function saveTo($output)
    {
        $fp = fopen($output, 'w');
        fputcsv($fp, ['Date', 'Payee', 'Memo', 'Outflow', 'Inflow']);

        foreach ($this->transactions as $transaction) {
            fputcsv($fp, $transaction);
        }

        if (fclose($fp)) {
            echo 'Conversion succeeded'. PHP_EOL;
        } else {
            echo 'Conversion failed'. PHP_EOL;
        }
    }


    /**
     * Turns 20190210 into 10-02-2019
     *
     * @param  string $date
     * @return string
     */
    protected function formatDate($date)
    {
        return date_format(date_create_from_format('Ymd', $date), 'd-m-Y');
    }


    /**
     * Convert the abstract payee to something more recognizable
     *
     * @param  string $payee
     * @return string
     */
    protected function formatPayee($payee)
    {
        if (array_key_exists($payee, $this->payeesList)) {
            return $this->payeesList[$payee];
        }

        return $payee;
    }


    /**
     * Allows for customization of the 'memo' column
     *
     * @param  array $row
     * @return string
     */
    protected function formatMemo($row)
    {
        return $row[8];
    }


    /**
     * Converts the integer month into a string representation
     *
     * @param  int    $month
     * @return string
     */
    protected function formatMonth(int $month)
    {
        $dates = [
            1 => 'Januari', 'Februari', 'Maart',
            'April', 'Mei', 'Juni',
            'Juli', 'Augustus', 'September',
            'Oktober', 'November', 'December'
        ];

        if ($month == 13) {
            $month = 1;
        }

        return $dates[$month];
    }


    /**
     * Checks the type of transaction and
     * adds the amount to Inflow or Outflow
     *
     * @param  string $type
     * @param  string $amount
     * @return array
     */
    protected function getAmount($type, $amount)
    {
        $transaction = [];

        switch ($type) {
            case 'Af':
                $transaction[0] = $amount;
                $transaction[1] = '0';
                break;
            case 'Bij':
                $transaction[0] = '0';
                $transaction[1] = $amount;
        }

        return $transaction;
    }


    /**
     * Reads the CSV file and loads it into an array
     *
     * @param  string $filename
     * @return array
     */
    protected function readInput($filename)
    {
        $csv = array_map('str_getcsv', file($filename));
        array_shift($csv);

        return $csv;
    }
}
