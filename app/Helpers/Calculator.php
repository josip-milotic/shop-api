<?php

namespace App\Helpers;

class Calculator
{
    public static function add(string $first, string $second, int $precision = 2): string
    {
        return bcadd($first, $second, $precision);
    }

    public static function subtract(string $first, string $second, int $precision = 2): string
    {
        return bcsub($first, $second, $precision);
    }

    public static function multiply(string $first, string $second, int $precision = 2): string
    {
        return bcmul($first, $second, $precision);
    }
}
