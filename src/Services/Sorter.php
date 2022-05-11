<?php

namespace App\Services;

class Sorter {
    public function usortEx(&$array, $key, $type = 'ASC')
    {
        usort($array, $this->build_sorter($key, $type));
        return $array;
    }

    private function build_sorter($key, $sortType = 'ASC') {
        return function ($a, $b) use ($key, $sortType) {
            return ($a[$key] <=> $b[$key]) * ($sortType == 'ASC' ? 1 : -1);
        };
    }
}