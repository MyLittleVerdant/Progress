<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contacts;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/contactsList?sort={direction}",
     *     tags={"Contacts"},
     *     summary="Get full list of contacts",
     *     description="Get full list of contacts",
     *     operationId="getContacts",
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
     *         description="Return json of contacts list array",
     *     ),
     * )
     */
    public function getContacts(Request $request)
    {
        if (!empty($_GET) && !empty($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            $contacts = Contacts::orderBy('sort', $_GET['sort'])->get();
        } else {
            $contacts = Contacts::all();
        }
        echo json_encode($contacts);
    }

    /**
     * @OA\Get(
     *     path="/api/contactsListPage?page={pageNum}",
     *     tags={"Contacts"},
     *     summary="Get a list of contacts by page",
     *     description="Get a list of contacts by page",
     *     operationId="getContactsByPage",
     *     @OA\Parameter(
     *         name="pageNum",
     *         in="path",
     *         description="Page of contacts list that needs to be fetched",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of contacts list array",
     *     ),
     * )
     */
    public function getContactsByPage(Request $request)
    {
        $contacts = Contacts::query()->paginate(config('database.paginator.count'));
        echo json_encode($contacts);
    }
}
