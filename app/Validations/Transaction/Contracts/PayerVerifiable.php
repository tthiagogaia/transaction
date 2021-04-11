<?php

namespace App\Validations\Transaction\Contracts;

interface PayerVerifiable
{
    public function setNext(PayerVerifiable $nextPayerVerifiable);

    public function getPayer(int $payerId, int $payeeId);
}
