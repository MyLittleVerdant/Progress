<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/teamList?sort={direction}",
     *     tags={"Team"},
     *     summary="Get full list of team",
     *     description="Get full list of team",
     *     operationId="getTeam",
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
     *         description="Return json of team list array",
     *     ),
     * )
     */
    public function getTeam(Request $request)
    {
        if (!empty($_GET) && !empty($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            $team = Team::orderBy('sort', $_GET['sort'])->get();
        } else {
            $team = Team::all();
        }
        echo json_encode($team);
    }

    /**
     * @OA\Get(
     *     path="/api/teamListPage?page={pageNum}",
     *     tags={"Team"},
     *     summary="Get a list of team by page",
     *     description="Get a list of team by page",
     *     operationId="getTeamByPage",
     *     @OA\Parameter(
     *         name="pageNum",
     *         in="path",
     *         description="Page of team list that needs to be fetched",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of team list array",
     *     ),
     * )
     */
    public function getTeamByPage(Request $request)
    {
        $team = Team::query()->paginate(config('database.paginator.count'));
        echo json_encode($team);
    }
}
