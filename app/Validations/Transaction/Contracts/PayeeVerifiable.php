<?php

namespace App\Validations\Transaction\Contracts;

interface PayeeVerifiable
{
    public function setNext(PayeeVerifiable $nextPayeeVerifiable);

    public function getPayee(int $payeeId);
}
