<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patronages;
use Illuminate\Http\Request;

class PatronagesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/patronagesList?sort={direction}",
     *     tags={"Patronages"},
     *     summary="Get full list of patronages",
     *     description="Get full list of patronages",
     *     operationId="getPatronages",
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
     *         description="Return json of patronages list array",
     *     ),
     * )
     */
    public function getPatronages(Request $request)
    {
        if (!empty($_GET) && !empty($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            $patronages = Patronages::orderBy('sort', $_GET['sort'])->get();
        } else {
            $patronages = Patronages::all();
        }
        echo json_encode($patronages);
    }

    /**
     * @OA\Get(
     *     path="/api/patronagesListPage?page={pageNum}",
     *     tags={"Patronages"},
     *     summary="Get a list of patronages by page",
     *     description="Get a list of patronages by page",
     *     operationId="getPatronagesByPage",
     *     @OA\Parameter(
     *         name="pageNum",
     *         in="path",
     *         description="Page of patronages list that needs to be fetched",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of patronages list array",
     *     ),
     * )
     */
    public function getPatronagesByPage(Request $request)
    {
        $patronages = Patronages::query()->paginate(config('database.paginator.count'));
        echo json_encode($patronages);
    }
}
