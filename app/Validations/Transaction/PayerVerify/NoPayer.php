<?php

namespace App\Validations\Transaction\PayerVerify;

use App\Validations\Transaction\Contracts\PayerVerifiable;
use App\Validations\Transaction\Excetions\PayerNotFoundException;

class NoPayer implements PayerVerifiable
{
    public function setNext(PayerVerifiable $nextPayerVerifiable)
    {
    }

    public function getPayer(int $payerId, int $payeeId)
    {
        throw new PayerNotFoundException();
    }
}
