<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function delete($socialID)
    {
        $result = Social::find($socialID)->delete();
        if (!$result) {
            return response()->json([
                'error' => true,
                'msg' => 'Не удалось удалить соц. сеть'
            ]);
        }
        return response()->json([
            'error' => false,
            'msg' => 'Соц. сеть успешно удален'
        ]);

    }
}
