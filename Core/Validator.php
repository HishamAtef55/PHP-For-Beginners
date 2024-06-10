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

    /**
     * email
     *
     * @param  mixed $email
     * @return bool
     */
    public static function email($email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
