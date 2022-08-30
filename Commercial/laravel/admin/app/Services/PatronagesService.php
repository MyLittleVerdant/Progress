<?php

namespace App\Services;

use App\Models\Patronages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

date_default_timezone_set('Europe/Moscow');

class PatronagesService
{

    public function create(Request $request)
    {
        $previewPictureFilePath = null;
        $detailPictureFilePath = null;

        $path = '/patronages/';
        if (!empty($request->file('preview_picture'))) {
            $fileName = uniqid() . '_' . $request->file('preview_picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('preview_picture')->storeAs($path, $fileName, 'public');
            $previewPictureFilePath = '/storage' . $path . $fileName;
        }
        if (!empty($request->file('detail_picture'))) {
            $fileName = uniqid() . '_' . $request->file('detail_picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('detail_picture')->storeAs($path, $fileName, 'public');
            $detailPictureFilePath = '/storage' . $path . $fileName;
        }

        $patronage = new Patronages([
            'name' => $request['name'],
            'preview_description' => $request['preview_description'],
            'detail_description' => $request['detail_description'],
            'link' => $request['link'],
            'color' => $request['color'],
            'preview_picture' => $previewPictureFilePath,
            'detail_picture' => $detailPictureFilePath,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'sort' => $request['sort'],

        ]);
        $patronage->save();
        return $patronage->id;
    }

    public function update(Patronages $patronage, $request)
    {
        $previewPictureFilePath = null;
        $detailPictureFilePath = null;

        $path = '/patronages/';
        if (!empty($request->file('preview_picture'))) {
            $fileName = uniqid() . '_' . $request->file('preview_picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('preview_picture')->storeAs($path, $fileName, 'public');
            $previewPictureFilePath = '/storage' . $path . $fileName;
        }
        if (!empty($request->file('detail_picture'))) {
            $fileName = uniqid() . '_' . $request->file('detail_picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('detail_picture')->storeAs($path, $fileName, 'public');
            $detailPictureFilePath = '/storage' . $path . $fileName;
        }

        $patronage->fill([
            'name' => $request['name'],
            'preview_description' => $request['preview_description'],
            'detail_description' => $request['detail_description'],
            'link' => $request['link'],
            'color' => $request['color'],
            'preview_picture' => $previewPictureFilePath ?? $patronage->preview_picture,
            'detail_picture' => $detailPictureFilePath ?? $patronage->detail_picture,
            'created_at' => $request['created_at'] ?? date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'sort' => $request['sort'],

        ]);

        $patronage->save();
        return $patronage->id;

    }

    public function delete(Patronages $patronage)
    {
        return $patronage->delete();
    }

    public function deleteDetailPicture(Patronages $patronage)
    {
        $name = explode('/', $patronage->detail_picture);
        $delRes = Storage::delete('public/patronages/' . $name[3]);
        if ($delRes) {
            $patronage->detail_picture = null;
            $patronage->save();
        }
        return $delRes;
    }


}
