<?php

namespace App\Formatters;

interface Formatter
{
    /*
    A row consists of the following data:
    [0] = Date
    [1] = Payee
    [2] = Memo
    [3] = Outflow
    [4] = Inflow
    */
    public function formatRow($row);
}
