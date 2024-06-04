<?php

declare(strict_types=1);

namespace Core;

use Core\Validation\FormValidation;

class Validator extends FormValidation
{

    public static function string($value, $min = 1, $max = INF)
    {
        $value = rtrim($value);
        return strlen($value) > $min && strlen($value) < $max;
    }

    public static function email($email)
    {
        if (filter_has_var(INPUT_POST, 'email')) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }
    }
}
