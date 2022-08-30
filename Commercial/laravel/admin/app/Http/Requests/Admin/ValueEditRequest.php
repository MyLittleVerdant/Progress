<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ValueEditRequest extends FormRequest
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
            'name'=> 'bail|required|string|max:255',
            'description' => 'bail|required|string',
            'sort' => 'integer',
            'picture'=> 'mimes:jpg,jpeg,bmp,png,webp',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Заголовок',
            'description' => 'Описание',
            'sort' => 'Сортировка',
            'picture' => 'Картинка',
        ];
    }
}
