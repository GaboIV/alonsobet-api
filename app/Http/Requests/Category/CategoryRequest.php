<?php

namespace App\Http\Requests\Category;

use App\Helpers\Functions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'name' => 'nombre de categoría',
            'name_id' => 'código de sincronización',
            'acro_3' => 'acrónimo',
            'importance' => 'importance'
        ];
    }

    public function rules()
    {
        return [
            'name'                  => 'required|unique:categories,name',
            'name_id'               => '',
            'acro_3'                => 'required|string',
            'importance'            => ''
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse(Functions::getValidatorMessage($validator), 422));
    }
}
