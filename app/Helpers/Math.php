<?php

namespace App\Helpers;

class Math
{

    private static string $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function to_base_10(string $value, $b = 62): int
    {
        $limit = strlen($value);
        $result = strpos(static::$base, $value[0]);
        for ($i = 1; $i < $limit; $i++) {
            $result = $b * $result + strpos(static::$base, $value[$i]);
        }
        return $result;
    }

    public static function to_base(int $value, $b = 62): string
    {
        $r = $value % $b;
        $result = static::$base[$r];
        $q = floor($value / $b);
        while ($q) {
            $r = $q % $b;
            $q = floor($q / $b);
            $result = static::$base[$r] . $result;
        }
        return $result;
    }

}
