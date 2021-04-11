<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cpf implements Rule
{
    private $cpf;

    public function passes($attribute, $cpf)
    {
        $this->cpf = $cpf;

        return $this->emptyVerify()
            && $this->lengthVerify()
            && $this->sameDigitsVerify()
            && $this->algorithmCpfVerify();
    }

    private function emptyVerify(): bool
    {
        return !empty($this->cpf);
    }

    private function lengthVerify(): bool
    {
        return !strlen($this->cpf) !== 11;
    }

    private function sameDigitsVerify(): bool
    {
        return !preg_match('/(\d)\1{10}/', $this->cpf);
    }

    private function algorithmCpfVerify(): bool
    {
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $this->cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            return $this->cpf[$c] == $d;
        }

        return false;
    }

    public function message()
    {
        return __('Invalid CPF.');
    }
}
