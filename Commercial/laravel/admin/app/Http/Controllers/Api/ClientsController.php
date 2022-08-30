<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clientsList?sort={direction}",
     *     tags={"Clients"},
     *     summary="Get full list of clients",
     *     description="Get full list of clients",
     *     operationId="getClients",
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
     *         description="Return json of clients list array",
     *     ),
     * )
     */
    public function getClients(Request $request)
    {
        if (!empty($_GET) && !empty($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            $clients = Clients::orderBy('sort', $_GET['sort'])->get();
        } else {
            $clients = Clients::all();
        }
        echo json_encode($clients);
    }

    /**
     * @OA\Get(
     *     path="/api/clientsListPage?page={pageNum}",
     *     tags={"Clients"},
     *     summary="Get a list of clients by page",
     *     description="Get a list of clients by page",
     *     operationId="getClientsByPage",
     *     @OA\Parameter(
     *         name="pageNum",
     *         in="path",
     *         description="Page of clients list that needs to be fetched",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of clients list array",
     *     ),
     * )
     */
    public function getClientsByPage(Request $request)
    {
        $clients = Clients::query()->paginate(config('database.paginator.count'));
        echo json_encode($clients);
    }
}
