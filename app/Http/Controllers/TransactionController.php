<?php

namespace App\Http\Controllers;

use App\Actions\Transaction\CreateCreditTransaction;
use App\Actions\Transaction\RefundTransaction;
use App\Http\Requests\CreditTransactionRequest;
use App\Http\Requests\RefundTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Jobs\Transaction\CreditNotification;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function credit(CreditTransactionRequest $request)
    {
        try {
            $transaction = (new CreateCreditTransaction())->create($request->all());

            CreditNotification::dispatch($transaction->payee);

            return TransactionResource::make($transaction);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function refund(RefundTransactionRequest $request)
    {
        try {
            $transaction = (new RefundTransaction())->refund($request->transaction_id);

            return TransactionResource::make($transaction);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
