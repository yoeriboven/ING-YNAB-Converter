<?php

namespace Yoeriboven\YNABConverter\Formatters;

class INGFormatter extends Formatter
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
        $transaction[0] = $this->formatDate($row[0]);
        $transaction[1] = $this->formatPayee($row[1]);
        $transaction[2] = $this->formatMemo($row[8]);
        [$transaction[3], $transaction[4]] = $this->getAmount($row[5], $row[6]);

        return $transaction;
    }

    /**
     * Turns 20190210 into 10-02-2019
     *
     * @param  string $date
     * @return string
     */
    private function formatDate($date)
    {
        return date_format(date_create_from_format('Ymd', $date), 'd-m-Y');
    }

    /**
     * Checks the type of transaction and
     * adds the amount to Inflow or Outflow
     *
     * @param  string $type
     * @param  string $amount
     * @return array
     */
    private function getAmount($type, $amount)
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
}
