<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MemberStoreRequest extends FormRequest
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
            'name' => 'bail|required|string|max:255',
            'post' => 'bail|required|string',
            'picture' => 'bail|required|mimes:jpg,jpeg,bmp,png,webp',
            'sort' => 'integer',

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Полное имя',
            'post' => 'Должность',
            'picture' => 'Фото',
            'sort' => 'Сортировка',

        ];
    }
}
