<?php

namespace App\Support;

/**
 * Formatting helpers — numbers, prices and dates in FA/EN.
 */
class Fmt
{
    public static function digits(string $s): string
    {
        if (app()->getLocale() !== 'fa') {
            return $s;
        }
        return strtr($s, [
            '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴',
            '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹',
        ]);
    }

    public static function num($n): string
    {
        $s = number_format((float) $n);
        if (app()->getLocale() === 'fa') {
            $s = strtr($s, [',' => '٬']);
        }
        return self::digits($s);
    }

    public static function price($n): string
    {
        return self::num($n);
    }

    public static function date($d): string
    {
        $dt = \Carbon\Carbon::parse($d);
        return self::digits($dt->format('Y/m/d'));
    }

    public static function toman(): string
    {
        return app()->getLocale() === 'fa' ? 'تومان' : 'Toman';
    }
}
