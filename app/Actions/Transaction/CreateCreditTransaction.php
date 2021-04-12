<?php

namespace App\Actions\Transaction;

use App\Facades\TransactionAuthorization;
use App\Jobs\Transaction\CreditNotification;
use App\Models\Operation;
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

            $authorization = TransactionAuthorization::authorize();

            $transaction = $payee->transactions()->create([
                'payer_id'           => $payer->id,
                'operation_id'       => $operation->id,
                'authorization_code' => $authorization['authorization_code'],
            ]);

            CreditNotification::dispatch($payee)->afterCommit();

            return $transaction;
        });
    }
}
