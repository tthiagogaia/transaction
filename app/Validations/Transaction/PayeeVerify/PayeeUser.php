<?php

namespace App\Validations\Transaction\PayeeVerify;

use App\Models\User;
use App\Validations\Transaction\Contracts\PayeeVerifiable;

class PayeeUser implements PayeeVerifiable
{
    private $nextPayeeVerifiable;

    public function setNext(PayeeVerifiable $nextPayeeVerifiable)
    {
        $this->nextPayeeVerifiable = $nextPayeeVerifiable;
    }

    public function getPayee(int $payeeId)
    {
        $user = User::query()->find($payeeId);

        return $user ? $user : $this->nextPayeeVerifiable->get($payeeId);
    }
}
