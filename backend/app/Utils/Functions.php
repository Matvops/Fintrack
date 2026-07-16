<?php

namespace App\Utils;

use App\Exceptions\ValidationException;

class Functions {

    public static function formatValue(string $value)
    {
        return preg_replace('/[^0-9.]/', '', str_replace(',', '.', str_replace('.', '', $value)));
    }

    public static function getPercentage(float $part, float $base)
    {
        return floor($part / $base * 100);
    }

    public static function getInitialDateOfMonth(string $date): string
    {
        $initialDate = date('Y-m-01 H:i:s', round($date / 1000));
        return $initialDate;
    }

    public static function getFinishDateOfMonth(string $date): string
    {
        $finishDate = date('Y-m-t H:i:s', round($date / 1000));
        return $finishDate;
    }

    public static function validateEmail(string $email): void 
    {
        if(substr_count($email, '@') !== 1) throw new ValidationException('Email inválido');

        $partsEmail = mb_split('@', $email);

        $needles = ['&', '=', '\'', '&', '<', '>', ','];

        foreach($needles as $needle) {
            if(str_contains($email, $needle)) throw new ValidationException('Email inválido');
        }

        $domain = $partsEmail[1];

        if(str_contains('..', $domain)) throw new ValidationException('Email inválido');
 
    }
}