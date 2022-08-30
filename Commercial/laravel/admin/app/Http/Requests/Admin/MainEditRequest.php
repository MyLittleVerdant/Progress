<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MainEditRequest extends FormRequest
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
            'desktop_video' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4',
            'mobile_video' => 'mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4',

        ];
    }

    public function attributes()
    {
        return [
            'desktop_video' => 'Видео для десктоп экрана',
            'mobile_video' => "Видео для мобильного экрана",
        ];
    }
}
