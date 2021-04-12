<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payee_id' => 'required',
            'amount'   => 'required|numeric|gt:0',
        ];
    }
}
