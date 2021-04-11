<?php

namespace App\Validations\Transaction\PayeeVerify;

use App\Models\Company;
use App\Validations\Transaction\Contracts\PayeeVerifiable;

class PayeeCompany implements PayeeVerifiable
{
    private $nextPayeePayerVerifiable;

    public function setNext(PayeeVerifiable $nextPayeePayerVerifiable)
    {
        $this->nextPayeePayerVerifiable = $nextPayeePayerVerifiable;
    }

    public function getPayee(int $payeeId)
    {
        $company = Company::query()->find($payeeId);

        return $company ? $company : $this->nextPayeePayerVerifiable->get($payeeId);
    }
}
