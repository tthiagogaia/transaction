<?php

namespace App\Validations\Transaction\PayeeVerify;

use App\Validations\Transaction\Contracts\PayeeVerifiable;
use App\Validations\Transaction\Excetions\PayeeNotFoundException;

class NoPayee implements PayeeVerifiable
{
    public function setNext(PayeeVerifiable $nextPayeeVerifiable)
    {
    }

    public function getPayee(int $id)
    {
        throw new PayeeNotFoundException(__('Payee not found'));
    }
}
