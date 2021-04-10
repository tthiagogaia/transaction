<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cpf implements Rule
{
    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return false;
        }

        $cpf = preg_replace("/[^0-9]/", "", $value);

        if (strlen($cpf) != 11) {
            return false;
        }

        $invalids = [
            '00000000000',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
            '66666666666',
            '77777777777',
            '88888888888',
            '99999999999',
        ];

        if (in_array($cpf, $invalids)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return __('Invalid CPF.');
    }
}
