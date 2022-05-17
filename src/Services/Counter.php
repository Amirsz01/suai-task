<?php

namespace App\Services;

class Counter {
    public static function mapCounter($array, $key){
        $result = array_reduce($array, function($carry, $item) use($key) {
            if(isset($carry[$item[$key]])) {
                $carry[$item[$key]]['count']++;
            } else {
                $carry[$item[$key]] = [
                    'count' => 1,
                    ...$item
                ];
            }
            return $carry;
        }, []);
        return $result;
    }
}