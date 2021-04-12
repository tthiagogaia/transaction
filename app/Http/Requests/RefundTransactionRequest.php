<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefundTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'transaction_id' => 'required|exists:transactions,id',
        ];
    }
}
