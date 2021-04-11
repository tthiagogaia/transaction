<?php

namespace App\Validations\Transaction\PayeeVerify;

use App\Validations\Transaction\Contracts\PayeePayerVerifiable;
use App\Validations\Transaction\Excetions\PayeeNotFoundException;

class NoPayee implements PayeePayerVerifiable
{
    public function setNext(PayeePayerVerifiable $nextPayeePayerVerifiable)
    {
    }

    public function get(int $id)
    {
        throw new PayeeNotFoundException(__('Payee not found'));
    }
}
