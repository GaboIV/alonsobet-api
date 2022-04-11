<?php

namespace App\Http\Requests\Bank;

use App\Helpers\Functions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BankRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'initial' => 'iniciales'
        ];
    }

    public function rules()
    {
        return [
            'name'                  => 'required|unique:banks,name',
            'initial'               => 'required|unique:banks,initial',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse(Functions::getValidatorMessage($validator), 422));
    }
}
