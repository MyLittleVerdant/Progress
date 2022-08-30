<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partners;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/partnersList?sort={direction}",
     *     tags={"Partners"},
     *     summary="Get full list of partners",
     *     description="Get full list of partners",
     *     operationId="getPartners",
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
     *         description="Return json of partners list array",
     *     ),
     * )
     */
    public function getPartners(Request $request)
    {
        if (!empty($_GET) && !empty($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            $partners = Partners::orderBy('sort', $_GET['sort'])->get();
        } else {
            $partners = Partners::all();
        }
        echo json_encode($partners);
    }

    /**
     * @OA\Get(
     *     path="/api/partnersListPage?page={pageNum}",
     *     tags={"Partners"},
     *     summary="Get a list of partners by page",
     *     description="Get a list of partners by page",
     *     operationId="getPartnersByPage",
     *     @OA\Parameter(
     *         name="pageNum",
     *         in="path",
     *         description="Page of partners list that needs to be fetched",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of partners list array",
     *     ),
     * )
     */
    public function getPartnersByPage(Request $request)
    {
        $partners = Partners::query()->paginate(config('database.paginator.count'));
        echo json_encode($partners);
    }
}
