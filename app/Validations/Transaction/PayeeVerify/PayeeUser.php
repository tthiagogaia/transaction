<?php

namespace App\Validations\Transaction\PayeeVerify;

use App\Models\User;
use App\Validations\Transaction\Contracts\PayeePayerVerifiable;

class PayeeUser implements PayeePayerVerifiable
{
    private $nextPayeePayerVerifiable;

    public function setNext(PayeePayerVerifiable $nextPayeePayerVerifiable)
    {
        $this->nextPayeePayerVerifiable = $nextPayeePayerVerifiable;
    }

    public function get(int $payeeId)
    {
        $user = User::query()->find($payeeId);

        return $user ? $user : $this->nextPayeePayerVerifiable->get($payeeId);
    }
}
