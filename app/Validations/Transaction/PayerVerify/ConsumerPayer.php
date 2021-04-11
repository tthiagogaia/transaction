<?php

namespace App\Validations\Transaction\PayerVerify;

use App\Models\Role;
use App\Models\User;
use App\Validations\Transaction\Contracts\PayerVerifiable;

class ConsumerPayer implements PayerVerifiable
{
    private $nextPayerVerifiable;

    public function setNext(PayerVerifiable $nextPayerVerifiable)
    {
        $this->nextPayerVerifiable = $nextPayerVerifiable;
    }

    public function getPayer(int $payerId, int $payeeId)
    {
        $user = User::query()
            ->where(
                'role_id',
                Role::query()->select('id')->where('label', Role::CONSUMER)->first()->id
            )
            ->find($payerId);

        return $user ? $user : $this->nextPayerVerifiable->getPayer($payerId, $payeeId);
    }
}
