<?php

namespace App\Validations\Transaction\PayerVerify;

class PayerVerify
{
    public function verify(int $payerId, int $payeeId)
    {
        $samePayerPayee  = new SamePayerPayee();
        $consumerPayer   = new ConsumerPayer();
        $shopKeeperPayer = new ShopKeeperPayer();
        $noPayer         = new NoPayer();

        $samePayerPayee->setNext($consumerPayer);
        $consumerPayer->setNext($shopKeeperPayer);
        $shopKeeperPayer->setNext($noPayer);

        return $samePayerPayee->getPayer($payerId, $payeeId);
    }
}
