<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cnpj implements Rule
{
    private $cnpj;

    public function passes($attribute, $cnpj)
    {
        $this->cnpj = $cnpj;

        return $this->emptyVerify()
            && $this->lengthVerify()
            && $this->sameDigitsVerify()
            && $this->algorithmCnpjVerify();
    }

    private function emptyVerify(): bool
    {
        return !empty($this->cnpj);
    }

    private function lengthVerify(): bool
    {
        return strlen($this->cnpj) !== 13;
    }

    private function sameDigitsVerify(): bool
    {
        return !preg_match('/(\d)\1{13}/', $this->cnpj);
    }

    private function algorithmCnpjVerify()
    {
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $this->cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        if ($this->cnpj[12] != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $this->cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        return $this->cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
    }

    public function message()
    {
        return __('Invalid CNPJ.');
    }
}
