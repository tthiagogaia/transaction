<?php

namespace App\Jobs\Transaction;

use App\Facades\TransactionNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreditNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $payee;

    public function __construct($payee)
    {
        $this->payee = $payee;
    }

    public function handle()
    {
        TransactionNotification::notify();
    }
}
