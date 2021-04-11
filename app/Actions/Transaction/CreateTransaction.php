<?php

namespace App\Actions\Transaction;

use App\Models\Operation;
use App\Models\User;
use App\Validations\Transaction\PayeeVerify\PayeeVerify;

class CreateTransaction
{
    public function create(array $input)
    {
        $payee = (new PayeeVerify())->verify($input['payee_id']);

        $operation = Operation::query()->create([
            'type'   => $input['operation'],
            'amount' => $input['amount'],
        ]);

        return $payee->transactions()->create([
            'payer_id'     => $input['payer_id'],
            'operation_id' => $operation->id,
        ]);
    }
}
