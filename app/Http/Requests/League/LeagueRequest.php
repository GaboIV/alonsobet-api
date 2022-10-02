<?php

namespace App\Http\Requests\League;

use App\Helpers\Functions;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LeagueRequest extends FormRequest
{
    use ApiResponse;

    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'name' => 'nombre de liga',
            'name_uk' => 'nombre web de liga',
            'description' => 'descripción',
            'category_id' => 'categoría',
            'country_id' => 'país',
            'url' => 'Link de ruta',
            'match_structure_id' => 'estructura de partidos'
        ];
    }

    public function rules()
    {
        return [
            'name'                  => 'required|unique:leagues,name',
            'name_uk'               => '',
            'description'           => '',
            'category_id'           => 'required|numeric|exists:categories,id',
            'country_id'            => 'required|numeric|exists:countries,id',
            'url'                   => 'nullable|string|unique:leagues,url',
            'match_structure_id'    => ''
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse(Functions::getValidatorMessage($validator), 422));
    }
}
