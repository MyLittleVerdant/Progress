<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WhaleStoreRequest extends FormRequest
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
            'picture' => 'bail|required|mimes:jpg,jpeg,bmp,png,webp',
            'key' => 'bail|required|string|max:255',
        ];
    }

    public function attributes()
    {
        return [

            'key' => 'Ключ',
            'picture' => "Картинка",

        ];
    }
}
