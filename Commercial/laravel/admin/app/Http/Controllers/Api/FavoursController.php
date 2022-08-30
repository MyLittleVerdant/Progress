<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FavourDetails;
use App\Models\Favours;
use Illuminate\Http\Request;

class FavoursController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/favoursList?sort={direction}",
     *     tags={"Favours"},
     *     summary="Get full list of favours",
     *     description="Get full list of favours",
     *     operationId="getFavours",
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
     *         description="Return json of favours list array favours{$key=>[...,medias[],details[],posters[]]}. Posters[] have a structure [posterID=>posterData[]].",
     *     ),
     * )
     */
    public function getFavours(Request $request)
    {
        $videos = [];
        if (!empty($_GET) && !empty($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            $favours = Favours::orderBy('sort', $_GET['sort'])->get();
            foreach ($favours as $key => $favour) {
                $mainMedias = $favour->medias()->orderBy('sort', $_GET['sort'])->get();
                $favour['medias'] = $mainMedias;
                foreach ($mainMedias as $media) {
                    if ($media->type === 'video') {
                        $videos[$key][] = $media->id;
                    }
                }
                $details = $favour->details()->orderBy('sort', $_GET['sort'])->get();
                $favour['details'] = $details;
                foreach ($details as $detail) {
                    $subMedias = $detail->medias()->orderBy('sort', $_GET['sort'])->get();
                    $detail['medias'] = $subMedias;
                    foreach ($subMedias as $media) {
                        if ($media->type === 'video') {
                            $videos[$key][] = $media->id;
                        }
                    }
                }

            }
        } else {
            $favours = Favours::all();
            foreach ($favours as $key => $favour) {
                $mainMedias = $favour->medias;
                foreach ($mainMedias as $media) {
                    if ($media->type === 'video') {
                        $videos[$key][] = $media->id;
                    }
                }
                $details = $favour->details;
                foreach ($details as $detail) {
                    $subMedias = $detail->medias;
                    foreach ($subMedias as $media) {
                        if ($media->type === 'video') {
                            $videos[$key][] = $media->id;
                        }
                    }
                }

            }
        }

        $favours = $favours->jsonSerialize();
        foreach ($videos as $favourOrder => $video) {
            foreach ($video as $videoID) {
                $poster = \App\Models\Medias::query()->where([
                    'relation_id' => $videoID,
                    'relation_name' => 'video'
                ])->first();
                if ($poster) {
                    $favours[$favourOrder]['posters'][$videoID] = $poster;
                }
            }
        }
        echo json_encode($favours);
    }

    /**
     * @OA\Get(
     *     path="/api/favourByKey?key={key}",
     *     tags={"Favours"},
     *     summary="Get favour by key",
     *     description="Get favour by key",
     *     operationId="getFavourByKey",
     *     @OA\Parameter(
     *         name="key",
     *         in="path",
     *         description="Key of favour that needs to be fetched",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Return json of favour{...,medias[],details[],posters[]}. Posters[] have a structure [posterID=>posterData[]]",
     *     ),
     * )
     */
    public function getFavourByKey(Request $request)
    {
        $videos = [];
        $favour = Favours::query()
            ->with([
                'medias' => function ($medias) {
                    $medias->orderBy('sort', 'asc');
                },
                'details.medias' => function ($detailsMedias) {
                    $detailsMedias->orderBy('sort', 'asc');
                },
            ])
            ->where(['key' => $request->key])
            ->first();
        foreach ($favour['medias'] as $media) {
            if ($media->type === 'video') {
                $videos[] = $media->id;
            }
        }
        foreach ($favour['details'] as $detail) {
            foreach ($detail['medias'] as $media) {
                if ($media->type === 'video') {
                    $videos[] = $media->id;
                }
            }
        }
        $favour = $favour->jsonSerialize();
        foreach ($videos as $video) {
            $poster = \App\Models\Medias::query()->where([
                'relation_id' => $video,
                'relation_name' => 'video'
            ])->first();
            if ($poster) {
                $favour['posters'][$video] = $poster;
            }
        }
        echo json_encode($favour);
    }
}
