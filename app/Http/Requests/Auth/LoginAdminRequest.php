<?php

namespace App\Http\Requests\Auth;

use App\Helpers\Functions;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginAdminRequest extends FormRequest
{
    use ApiResponse;

    public function attributes()
    {
        return [
            'email' => 'correo electrónico',
            'password' => 'clave digital'
        ];
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse(Functions::getValidatorMessage($validator), 422));
    }
}
