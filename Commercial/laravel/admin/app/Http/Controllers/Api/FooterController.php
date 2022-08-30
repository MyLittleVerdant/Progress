<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/footerList",
     *     tags={"Footer"},
     *     summary="Get footer's elements",
     *     description="Get footer's elements",
     *     operationId="getFooter",
     *     @OA\Response(
     *         response=200,
     *         description="Return json of footer's elements",
     *     ),
     * )
     */
    public function getFooter(Request $request)
    {
        $footer = Footer::find(1);
        $footer->socials;
        echo json_encode($footer);
    }
}
