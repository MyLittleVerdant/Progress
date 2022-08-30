<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medias;
use Illuminate\Http\Request;

class MediasController extends Controller
{

    public function delete($mediaID)
    {
        $result = Medias::find($mediaID)->delete();
        if (!$result) {
            return response()->json([
                'error' => true,
                'msg' => 'Не удалось удалить файл'
            ]);
        }
        return response()->json([
            'error' => false,
            'msg' => 'Файл успешно удален'
        ]);

    }
}
