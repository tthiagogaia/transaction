<?php

namespace App\Actions\Transaction;

use App\Facades\TransactionAuthorization;
use App\Jobs\Transaction\CreditNotification;
use App\Models\Operation;
use App\Validations\Transaction\Exceptions\InsufficientCreditsException;
use App\Validations\Transaction\PayeeVerify\PayeeVerify;
use App\Validations\Transaction\PayerVerify\PayerVerify;
use Illuminate\Support\Facades\DB;

class CreateCreditTransaction
{
    public function create(array $input)
    {
        return DB::transaction(function () use ($input) {
            $payee = (new PayeeVerify())->verify($input['payee_id']);

            $payer = (new PayerVerify())->verify(auth()->id(), $input['payee_id']);

            $operation = Operation::query()->create([
                'type'   => Operation::CREDIT,
                'amount' => $input['amount'],
            ]);

            $this->checksPayerHasSufficientCredits($payer, $operation);

            $authorization = TransactionAuthorization::authorize();

            $this->makeCreditDebit($payer, $payee, $operation);

            $transaction = $payee->transactions()->create([
                'payer_id'           => $payer->id,
                'operation_id'       => $operation->id,
                'authorization_code' => $authorization['authorization_code'],
            ]);

            CreditNotification::dispatch($payee)->afterCommit();

            return $transaction;
        });
    }

    private function checksPayerHasSufficientCredits($payer, $operation): void
    {
        $payerHasCredit = $payer->wallet->amount >= $operation->amount;

        if (!$payerHasCredit) {
            throw new InsufficientCreditsException();
        }
    }

    private function makeCreditDebit($payer, $payee, $operation): void
    {
        $payer->wallet->amount = floatval($payer->wallet->amount) - $operation->amount;
        $payer->wallet->save();

        $payee->wallet->amount = floatval($payee->wallet->amount) + $operation->amount;
        $payee->wallet->save();
    }
}
