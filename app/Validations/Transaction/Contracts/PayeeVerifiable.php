<?php

namespace App\Validations\Transaction\Contracts;

interface PayeeVerifiable
{
    public function setNext(PayeeVerifiable $nextPayeePayerVerifiable);

    public function getPayee(int $payeeId);
}
