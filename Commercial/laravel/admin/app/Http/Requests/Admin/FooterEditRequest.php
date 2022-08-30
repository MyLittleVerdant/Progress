<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FooterEditRequest extends FormRequest
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
    public function rules()
    {
        return [
            'policy' => 'string',
            'phone' => 'bail|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        ];
    }

    public function attributes()
    {
        return [

            'policy' => 'Политика обработки персональных данных',
            'phone' => "Номер телефона",

        ];
    }
}
