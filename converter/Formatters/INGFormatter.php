<?php

require_once 'Formatter.php';

class INGFormatter implements Formatter
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

    public function formatRow($row)
    {
        $transaction = [];
        $transaction[0] = $this->formatDate($row[0]); // Date
        $transaction[1] = $this->formatPayee($row[1]); // Payee
        $transaction[2] = $this->formatMemo($row); // Memo
        [$transaction[3], $transaction[4]] = $this->getAmount($row[5], $row[6]);

        return $transaction;
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
}
