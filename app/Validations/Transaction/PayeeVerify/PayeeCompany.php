<?php

namespace App\Validations\Transaction\PayeeVerify;

use App\Models\Company;
use App\Validations\Transaction\Contracts\PayeePayerVerifiable;

class PayeeCompany implements PayeePayerVerifiable
{
    private $nextPayeePayerVerifiable;

    public function setNext(PayeePayerVerifiable $nextPayeePayerVerifiable)
    {
        $this->nextPayeePayerVerifiable = $nextPayeePayerVerifiable;
    }

    public function get(int $payeeId)
    {
        $company = Company::query()->find($payeeId);

        return $company ? $company : $this->nextPayeePayerVerifiable->get($payeeId);
    }
}
