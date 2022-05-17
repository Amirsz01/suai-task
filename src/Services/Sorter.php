<?php

namespace App\Services;

class Sorter {
    public static function usortEx(&$array, $key, $type = 'ASC')
    {
        usort($array, self::build_sorter($key, $type));
        return $array;
    }

    private static function build_sorter($key, $sortType = 'ASC') {
        return function ($a, $b) use ($key, $sortType) {
            return ($a[$key] <=> $b[$key]) * ($sortType == 'ASC' ? 1 : -1);
        };
    }
}