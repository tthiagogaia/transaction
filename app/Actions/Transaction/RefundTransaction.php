<?php

namespace App\Actions\Transaction;

use App\Models\Operation;
use App\Models\Transaction;
use App\Validations\Transaction\Exceptions\InvalidRefundTransactionException;
use App\Validations\Transaction\Exceptions\RefundedTransactionException;
use Illuminate\Support\Facades\DB;

class RefundTransaction
{
    public function refund(int $transactionId)
    {
        return DB::transaction(function () use ($transactionId) {
            $transaction = Transaction::query()
                ->with('payer')
                ->with('payee')
                ->with('operation')
                ->find($transactionId);

            $this->validateTransaction($transaction);

            $this->makeCreditDebit($transaction->payer, $transaction->payee, $transaction->operation);

            $transaction->refunded_at = now();
            $transaction->save();

            return $transaction;
        });
    }

    private function makeCreditDebit($payer, $payee, $operation): void
    {
        $payer->wallet->amount = floatval($payer->wallet->amount) + $operation->amount;
        $payer->wallet->save();

        $payee->wallet->amount = floatval($payee->wallet->amount) - $operation->amount;
        $payee->wallet->save();
    }

    private function validateTransaction($transaction)
    {
        if ($transaction->operation->type !== Operation::CREDIT) {
            throw new InvalidRefundTransactionException();
        }

        if ($transaction->refunded_at !== null) {
            throw new RefundedTransactionException();
        }
    }
}
