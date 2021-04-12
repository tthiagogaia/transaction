<?php

namespace App\Http\Controllers;

use App\Actions\Transaction\CreateCreditTransaction;
use App\Actions\Transaction\RefundTransaction;
use App\Http\Requests\CreditTransactionRequest;
use App\Http\Requests\RefundTransactionRequest;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function credit(CreditTransactionRequest $request)
    {
        try {
            return (new CreateCreditTransaction())->create($request->all());
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function refund(RefundTransactionRequest $request)
    {
        try {
            return (new RefundTransaction())->refund($request->transaction_id);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
