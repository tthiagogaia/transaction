<?php

namespace App\Validations\Transaction\PayeeVerify;

use App\Models\User;
use App\Validations\Transaction\Contracts\PayeeVerifiable;

class PayeeUser implements PayeeVerifiable
{
    private $nextPayeePayerVerifiable;

    public function setNext(PayeeVerifiable $nextPayeePayerVerifiable)
    {
        $this->nextPayeePayerVerifiable = $nextPayeePayerVerifiable;
    }

    public function getPayee(int $payeeId)
    {
        $user = User::query()->find($payeeId);

        return $user ? $user : $this->nextPayeePayerVerifiable->get($payeeId);
    }
}
