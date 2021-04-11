<?php

namespace App\Http\Requests;

use App\Models\Operation;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payer_id'  => 'required|exists:users,id',
            'payee_id'  => 'required',
            'amount'    => 'required|numeric|gt:0',
            'operation' => ['required', 'string', 'in:' . implode(',', Operation::ALLOWED_OPERATIONS)],
        ];
    }
}
