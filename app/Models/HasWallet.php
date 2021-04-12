<?php

namespace App\Models;

trait HasWallet
{
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'account');
    }
}
