<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Careers;
use App\Models\Values;
use Illuminate\Http\Request;

class CareersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/careersList?sort={direction}",
     *     tags={"Careers"},
     *     summary="Get full list of career values",
     *     description="Get full list of career values",
     *     operationId="getCareers",
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
     *         description="Return json of career values array",
     *     ),
     * )
     */
    public function getCareers(Request $request)
    {
        $career = Careers::find(1);
        if (!empty($_GET) && !empty($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            $values = $career->values()->orderBy('sort', $_GET['sort'])->get();
            $career['values'] = $values;
        } else {
            $career->values;
        }
        echo json_encode($career);
    }

    /**
     * @OA\Get(
     *     path="/api/careersListPage?page={pageNum}",
     *     tags={"Careers"},
     *     summary="Get a list of career values by page",
     *     description="Get a list of career values by page",
     *     operationId="getCareersByPage",
     *     @OA\Parameter(
     *         name="pageNum",
     *         in="path",
     *         description="Page of list values that needs to be fetched",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return array of list values on career page as json",
     *     ),
     * )
     */
    public function getCareersByPage(Request $request)
    {
        $career = Careers::find(1);
        $values = Values::query()->paginate(config('database.paginator.count'));
        $data['main_description'] = $career->description;
        $data['values'] = $values;
        echo json_encode($data);
    }
}
