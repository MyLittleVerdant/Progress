<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Main;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/mainList",
     *     tags={"Main"},
     *     summary="Get videos of main page",
     *     description="Get videos of main page",
     *     operationId="getMain",
     *     @OA\Response(
     *         response=200,
     *         description="Return json of main's videos paths",
     *     ),
     * )
     */
    public function getMain(Request $request)
    {
        $main = Main::find(1);

        echo json_encode($main);
    }
}
