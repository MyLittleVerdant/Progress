<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/aboutList?sort={direction}",
     *     tags={"About"},
     *     summary="Get full list of about blocks",
     *     description="Get full list of about blocks",
     *     operationId="getAbout",
     *     @OA\Parameter(
     *         name="direction",
     *         in="path",
     *         description="Direction of sort (asc/desc). Default- asc by ID",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of about blocks array",
     *     ),
     * )
     */
    public function getAbout(Request $request)
    {
        if (!empty($_GET) && !empty($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            $aboutBlocks = About::orderBy('sort', $_GET['sort'])->get();
        } else {
            $aboutBlocks = About::all();
        }

        echo json_encode($aboutBlocks);
    }

    /**
     * @OA\Get(
     *     path="/api/aboutListPage?page={pageNum}",
     *     tags={"About"},
     *     summary="Get a list of about blocks",
     *     description="Get a list of about blocks",
     *     operationId="getAboutByPage",
     *     @OA\Parameter(
     *         name="pageNum",
     *         in="path",
     *         description="Page of about blocks list that needs to be fetched",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of about blocks list array",
     *     ),
     * )
     */
    public function getAboutByPage(Request $request)
    {
        $aboutBlocks = About::query()->paginate(config('database.paginator.count'));
        echo json_encode($aboutBlocks);
    }
}
