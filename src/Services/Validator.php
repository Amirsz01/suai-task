<?php

namespace App\Services;

class Validator {
    public static function checkInt($param) {
        return !is_int($param) ? (ctype_digit($param)) : true;
    }
}