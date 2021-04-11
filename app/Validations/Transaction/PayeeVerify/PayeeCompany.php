<?php

namespace App\Validations\Transaction\PayeeVerify;

use App\Models\Company;
use App\Validations\Transaction\Contracts\PayeeVerifiable;

class PayeeCompany implements PayeeVerifiable
{
    private $nextPayeeVerifiable;

    public function setNext(PayeeVerifiable $nextPayeeVerifiable)
    {
        $this->nextPayeeVerifiable = $nextPayeeVerifiable;
    }

    public function getPayee(int $payeeId)
    {
        $company = Company::query()->find($payeeId);

        return $company ? $company : $this->nextPayeeVerifiable->get($payeeId);
    }
}
