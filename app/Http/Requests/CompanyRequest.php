<?php

namespace App\Http\Requests;

use App\Helpers\SanitizeHelper;
use App\Rules\Cnpj;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'cnpj' => ['required', 'unique:companies', new Cnpj],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cnpj' => (new SanitizeHelper($this->cnpj))->cpfCnpj()->sanitize(),
        ]);
    }
}
