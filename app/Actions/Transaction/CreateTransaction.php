<?php

namespace App\Actions\Transaction;

use App\Facades\TransactionAuthorization;
use App\Models\Operation;
use App\Validations\Transaction\PayeeVerify\PayeeVerify;
use App\Validations\Transaction\PayerVerify\PayerVerify;
use Illuminate\Support\Facades\DB;

class CreateTransaction
{
    public function create(array $input)
    {
        return DB::transaction(function () use ($input) {
            $payee = (new PayeeVerify())->verify($input['payee_id']);

            $payer = (new PayerVerify())->verify($input['payer_id'], $input['payee_id']);

            $operation = Operation::query()->create([
                'type'   => $input['operation'],
                'amount' => $input['amount'],
            ]);

            $authorization = TransactionAuthorization::authorize();

            return $payee->transactions()->create([
                'payer_id'           => $payer->id,
                'operation_id'       => $operation->id,
                'authorization_code' => $authorization['authorization_code'],
            ]);
        });
    }
}
