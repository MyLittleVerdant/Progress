<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FavourDetails;
use Illuminate\Http\Request;

class FavourDetailsController extends Controller
{
    public function delete($detailID)
    {
        $result = FavourDetails::find($detailID)->delete();
        if (!$result) {
            return response()->json([
                'error' => true,
                'msg' => 'Не удалось удалить пункт'
            ]);
        }
        return response()->json([
            'error' => false,
            'msg' => 'Пункт успешно удален'
        ]);

    }
}
