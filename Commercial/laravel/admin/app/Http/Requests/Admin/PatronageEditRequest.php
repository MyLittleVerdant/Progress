<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PatronageEditRequest extends FormRequest
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
            'preview_description' => 'bail|required|string',
            'detail_description' => 'bail|required|string',
            'link' => 'bail|required|string',
            'color' => 'bail|required|string',
            'preview_picture' => 'mimes:jpg,jpeg,bmp,png,webp',
            'detail_picture' => 'mimes:jpg,jpeg,bmp,png,webp',
            'sort' => 'integer',

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Заголовок',
            'preview_description' => 'Описание анонса',
            'detail_description' => 'Детальное описание',
            'link' => 'Подробнее',
            'color' => 'Цвет блока',
            'preview_picture' => 'Картинка анонса',
            'detail_picture' => 'Детальная картинка',
            'sort' => 'Сортировка',

        ];
    }
}
