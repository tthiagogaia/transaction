<?php

namespace App\Validations\Transaction\Contracts;

interface PayeePayerVerifiable
{
    public function setNext(PayeePayerVerifiable $nextPayeePayerVerifiable);

    public function get(int $payeeId);
}
