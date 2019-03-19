<?php

class Csv
{
    /**
     * Writes all transactions to a csv file
     *
     * @param  string $output
     */
    public static function saveToFile($transactions, $output)
    {
        $fp = fopen($output, 'w');
        fputcsv($fp, ['Date', 'Payee', 'Memo', 'Outflow', 'Inflow']);

        foreach ($transactions as $transaction) {
            fputcsv($fp, $transaction);
        }

        if (fclose($fp)) {
            echo 'Conversion succeeded'. PHP_EOL;
        } else {
            echo 'Conversion failed'. PHP_EOL;
        }
    }


    /**
     * Writes all transactions to a csv file
     * which is immediately downloaded by the user
     *
     * @param  string $output
     */
    public static function downloadFile($transactions, $output)
    {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$output.'";');

        $fp = fopen('php://output', 'w');
        fputcsv($fp, ['Date', 'Payee', 'Memo', 'Outflow', 'Inflow']);

        foreach ($transactions as $transaction) {
            fputcsv($fp, $transaction);
        }
    }

    /**
     * Reads the CSV file and loads it into an array
     *
     * @param  string $filename
     * @return array
     */
    public static function readInput($filename)
    {
        $csv = array_map('str_getcsv', file($filename));
        array_shift($csv);

        return $csv;
    }
}
