<?php

namespace App\Validations\Transaction\PayeeVerify;

class PayeeVerify
{
    public function verify(int $payeeId)
    {
        $payeeUser    = new PayeeUser();
        $payeeCompany = new PayeeCompany();
        $noPayee      = new NoPayee();

        $payeeUser->setNext($payeeCompany);
        $payeeCompany->setNext($noPayee);

        return $payeeUser->get($payeeId);
    }
}
