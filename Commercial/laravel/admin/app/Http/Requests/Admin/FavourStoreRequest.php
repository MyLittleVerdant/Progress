<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FavourStoreRequest extends FormRequest
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
            'title' => 'bail|required|string|max:255',
            'description' => 'bail|required|string',
            'link' => 'bail|required|string',
            'key' => 'bail|required|unique:favours|string',
            'sort' => 'integer',
            'preview_picture' => 'required|mimes:jpg,jpeg,bmp,png,webp',

        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'link' => 'Подробнее',
            'key' => 'Ключ',
            'sort' => 'Сортировка',
            'preview_picture' => 'Картинка анонса',

        ];
    }
}
