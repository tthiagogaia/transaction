<?php

namespace App\Http\Controllers;

use App\Actions\Transaction\CreateTransaction;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    public function store(TransactionRequest $request)
    {
        try {
            return (new CreateTransaction())->create($request->all());
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
