<?php

namespace App\Http\Requests;

use App\Helpers\SanitizeHelper;
use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;

class RegisteredUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'cpf'      => ['required', 'unique:users', new Cpf],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'cpf' => (new SanitizeHelper($this->cpf))->cpfCnpj()->sanitize(),
        ]);
    }
}
