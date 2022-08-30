<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactStoreRequest extends FormRequest
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
            'data' => 'bail|required|string|max:255',
            'key' => 'bail|required|string|max:255',
            'sort' => 'integer',

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Заголовок',
            'data' => 'Данные',
            'key' => 'Ключ',
            'sort' => 'Сортировка',

        ];
    }
}
