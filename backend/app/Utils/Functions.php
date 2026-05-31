<?php

namespace App\Utils;

class Functions {

    public static function formatValue(string $value)
    {
        return preg_replace('/[^0-9.]/', '', str_replace(',', '.', str_replace('.', '', $value)));
    }
}