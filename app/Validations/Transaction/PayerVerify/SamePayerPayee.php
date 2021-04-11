<?php

namespace App\Validations\Transaction\PayerVerify;

use App\Validations\Transaction\Contracts\PayerVerifiable;
use App\Validations\Transaction\Excetions\SamePayerException;

class SamePayerPayee implements PayerVerifiable
{
    private $nextPayerVerifiable;

    public function setNext(PayerVerifiable $nextPayerVerifiable)
    {
        $this->nextPayerVerifiable = $nextPayerVerifiable;
    }

    public function getPayer(int $payerId, int $payeeId)
    {
        if ($payerId === $payeeId) {
            throw new SamePayerException(
                __('It is not possible to accomplish transactions from a user to the same user')
            );
        }

        return $this->nextPayerVerifiable->getPayer($payerId, $payeeId);
    }
}
