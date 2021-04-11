<?php

namespace App\Actions\Transaction;

use App\Models\Operation;
use App\Validations\Transaction\PayeeVerify\PayeeVerify;
use App\Validations\Transaction\PayerVerify\PayerVerify;

class CreateTransaction
{
    public function create(array $input)
    {
        $payee = (new PayeeVerify())->verify($input['payee_id']);

        $payer = (new PayerVerify())->verify($input['payer_id'], $input['payee_id']);

        $operation = Operation::query()->create([
            'type'   => $input['operation'],
            'amount' => $input['amount'],
        ]);

        return $payee->transactions()->create([
            'payer_id'     => $payer->id,
            'operation_id' => $operation->id,
        ]);
    }
}
