<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AboutEditRequest extends FormRequest
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
            'picture' => 'nullable|mimes:jpg,jpeg,bmp,png,webp',
            'key' => 'bail|required|string|max:255',
            'title' => 'bail|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'string',
            'signature' => 'nullable',
            'CEO_name' => 'bail|string|max:255|nullable',
            'first_quarter_num' => 'bail|string|max:5|nullable',
            'first_quarter_title' => 'bail|string|max:255|nullable',
            'second_quarter_num' => 'bail|string|max:5|nullable',
            'second_quarter_title' => 'bail|string|max:255|nullable',
            'third_quarter_num' => 'bail|string|max:5|nullable',
            'third_quarter_title' => 'bail|string|max:255|nullable',
            'fourth_quarter_num' => 'bail|string|max:5|nullable',
            'fourth_quarter_title' => 'bail|string|max:255|nullable',
            'sort' => 'integer',

        ];
    }

    public function attributes()
    {
        return [

            'key' => 'Ключ',
            'title' => "Заголовок",
            'subtitle' => "Подзаголовок",
            'description' => "Описание",
            'picture' => "Картинка",
            'signature' => "Подпись",
            'CEO_name' => "Имя CEO",
            'first_quarter_num' => "Значение первой четверти",
            'first_quarter_title' => "Заголовок первой четверти",
            'second_quarter_num' => "Значение второй четверти",
            'second_quarter_title' => "Заголовок второй четверти",
            'third_quarter_num' => "Значение третьей четверти",
            'third_quarter_title' => "Заголовок третьей четверти",
            'fourth_quarter_num' => "Значение четвертой четверти",
            'fourth_quarter_title' => "Заголовок четвертой четверти",
            'sort' => 'Сортировка',

        ];
    }
}
