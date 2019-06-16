<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CveGetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'offset'    => 'numeric',
            'limit'     => 'numeric|digits_between:1,4',
            'year'      => 'date_format:Y|digits:4'
        ];
    }

    public function response(array $errors){
        return response()->json($errors, 422);
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'offset.numeric'        => 'You must specify the offset as a numeric literal',
            'limit.numeric'         => 'You must specify the limit as a numeric literal',
            'limit.digits_between'  => 'The limit value must be between 1 and 4 in numeric literals',
            'year.date_format'      => 'The field {year} must be a date using this format {Y}',
            'year.digits'           => 'The field {year} must contain only 4 digits',
        ];
    }
}
