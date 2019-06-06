<?php

namespace Yoeriboven\YNABConverter\Formatters;

abstract class Formatter
{
    /*
    A row consists of the following data:
    [0] = Date
    [1] = Payee
    [2] = Memo
    [3] = Outflow
    [4] = Inflow
    */


    /**
     * Returns a formatted row for every transaction
     *
     * @param  array $row
     * @return array
     */
    abstract public function getFormattedTransaction($row);


    /**
     * Convert the abstract payee to something more recognizable
     *
     * @param  string $payee
     * @return string
     */
    protected function formatPayee($payee)
    {
        return $payee;
    }


    /**
     * Allows for customization of the 'memo' column
     *
     * @param  string $memo
     * @return string
     */
    protected function formatMemo($memo)
    {
        return $memo;
    }
}
