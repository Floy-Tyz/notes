<?php

namespace App\Infrastructure\Utils;

class CaseConverter
{
    /**
     * @param int $n
     * @param string $first
     * @param string $second
     * @param string $third
     * @return string
     */
    public static function changeStringCase(int $n, string $first, string $second, string $third): string
    {
        $n = abs($n) % 100;
        $n1 = $n % 10;
        $changedStr = $first;

        if ($n > 10 && $n < 20) {
            return $changedStr;
        } else if ($n1 > 1 && $n1 < 5) {
            $changedStr = $second;
        } else if ($n1 === 1) {
            $changedStr = $third;
        }
        return $changedStr;
    }

    /**
     * @param int $n
     * @param string $first
     * @param string $second
     * @return string
     */
    public static function changeBeforeStringCase(int $n, string $first, string $second): string
    {
        if ($n < 2) {
            return $first;
        }
        return $second;
    }
}