<?php

namespace App\Http\Controllers;

use App\Actions\Transaction\CreateCreditTransaction;
use App\Http\Requests\CreditTransactionRequest;

class TransactionController extends Controller
{
    public function credit(CreditTransactionRequest $request)
    {
        try {
            return (new CreateCreditTransaction())->create($request->all());
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
