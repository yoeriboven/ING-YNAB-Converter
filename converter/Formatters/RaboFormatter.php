<?php

namespace App\Formatters;

class RaboFormatter extends Formatter
{
    /**
     * Returns a formatted row for every transaction
     *
     * @param  array $row
     * @return array
     */
    public function getFormattedTransaction($row)
    {
        $transaction = [];
        $transaction[0] = $this->formatDate($row[4]);
        $transaction[1] = $this->formatPayee($row[9]);
        $transaction[2] = $this->formatMemo($row[19]);
        [$transaction[3], $transaction[4]] = $this->getAmount($row[6]);

        return $transaction;
    }

    /**
     * Turns 2019-02-10 into 10-02-2019
     *
     * @param  string $date
     * @return string
     */
    private function formatDate($date)
    {
        return date_format(date_create_from_format('Y-m-d', $date), 'd-m-Y');
    }


    /**
     * Returns the data for inflow/outflow
     *
     * The amount can be negative (-) or positive (no prefix)
     *
     * @param  string $amount
     * @return array
     */
    private function getAmount($amount)
    {
        $transaction = [];

        $prefix = mb_substr($amount, 0, 1);
        $amount = mb_substr($amount, 1);

        if ($prefix == '-') {
            $transaction[0] = $amount;
            $transaction[1] = '0';
        } else {
            $transaction[0] = '0';
            $transaction[1] = $amount;
        }

        return $transaction;
    }
}
