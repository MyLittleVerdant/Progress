<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/newsList?page={pageNum}&&sort={direction}",
     *     tags={"News"},
     *     summary="Get a list of news",
     *     description="Get a list of news",
     *     operationId="getNews",
     *     @OA\Parameter(
     *         name="pageNum",
     *         in="path",
     *         description="Page of news list that needs to be fetched",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="direction",
     *         in="path",
     *         description="Direction of sort (asc/desc). Default - asc by ID",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of news list array",
     *     ),
     * )
     */
    public function getNews(Request $request)
    {
        if (!empty($_GET) && !empty($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            $news = News::orderBy('date', $_GET['sort'])->paginate(config('database.paginator.count'));
        } else {
            $news = News::query()->paginate(config('database.paginator.count'));
        }
        echo json_encode($news);
    }

    /**
     * @OA\Get(
     *     path="/api/newsList/{newsID}",
     *     tags={"News"},
     *     description="Get news by id",
     *     summary="Get news by id",
     *     operationId="getSpecificNews",
     *     @OA\Parameter(
     *         name="newsID",
     *         in="path",
     *         description="ID of news that needs to be fetched",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of news array",
     *
     *     ),
     * @OA\Response(
     *         response=404,
     *         description="News not found"
     *     )
     * )
     */
    public function getSpecificNews(News $news)
    {
        $data = $news->attributesToArray();
        echo json_encode($data);
    }
}
