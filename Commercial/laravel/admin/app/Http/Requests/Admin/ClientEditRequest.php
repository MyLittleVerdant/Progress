<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientEditRequest extends FormRequest
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
            'sort' => 'integer',
            'name' => 'bail|required|string|max:255',
            'picture' => 'mimes:jpg,jpeg,bmp,png,webp',
        ];
    }

    public function attributes()
    {
        return [
            'sort' => 'Сортировка',
            'name' => 'Название',
            'picture' => 'Лого',
        ];
    }
}
