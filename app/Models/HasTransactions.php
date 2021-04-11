<?php

namespace App\Models;

trait HasTransactions
{
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'payee');
    }
}
