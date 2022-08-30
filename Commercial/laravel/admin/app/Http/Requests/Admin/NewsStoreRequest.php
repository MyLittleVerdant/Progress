<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsStoreRequest extends FormRequest
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
            'preview_title' => 'bail|required|string|max:255',
            'detail_title' => 'bail|required|string|max:255',
            'preview_description' => 'bail|required|string',
            'detail_description' => 'bail|required|string',
            'date' => 'before:next week',
            'main_picture' => 'bail|required|mimes:jpg,jpeg,bmp,png,webp',
            'preview_picture' => 'bail|required|mimes:jpg,jpeg,bmp,png,webp'
        ];
    }

    public function attributes()
    {
        return [
            'preview_title' => 'Заголовок анонса',
            'detail_title' => 'Детальный заголовок',
            'preview_description' => 'Описание анонса',
            'detail_description' => 'Детальное описание',
            'date' => 'Дата',
            'main_picture' => 'Заглавная картинка',
            'preview_picture' => 'Картинка анонса',
        ];
    }
}
