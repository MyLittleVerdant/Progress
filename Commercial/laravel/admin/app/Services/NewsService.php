<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Http\Request;


class NewsService
{

    public function create(Request $request)
    {
        $mainPictureFilePath = null;
        $previewPictureFilePath = null;
        $path = '/news/';
        if (!empty($request->file('main_picture'))) {
            $fileName = uniqid() . '_' . $request->file('main_picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('main_picture')->storeAs($path, $fileName, 'public');
            $mainPictureFilePath = '/storage' . $path . $fileName;
        }
        if (!empty($request->file('preview_picture'))) {
            $fileName = uniqid() . '_' . $request->file('preview_picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('preview_picture')->storeAs($path, $fileName, 'public');
            $previewPictureFilePath = '/storage' . $path . $fileName;
        }

        $news = new News([
            'preview_title' => $request['preview_title'],
            'detail_title' => $request['detail_title'],
            'date' => $request['date'],
            'preview_description' => $request['preview_description'],
            'detail_description' => $request['detail_description'],
            'main_picture' => $mainPictureFilePath,
            'preview_picture' => $previewPictureFilePath,
        ]);
        $news->save();
        return $news->id;
    }

    public function update(News $news, $request)
    {
        $mainPictureFilePath = null;
        $previewPictureFilePath = null;
        $path = '/news/';
        if (!empty($request->file('main_picture'))) {
            $fileName = uniqid() . '_' . $request->file('main_picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('main_picture')->storeAs($path, $fileName, 'public');
            $mainPictureFilePath = '/storage' . $path . $fileName;
        }
        if (!empty($request->file('preview_picture'))) {
            $fileName = uniqid() . '_' . $request->file('preview_picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('preview_picture')->storeAs($path, $fileName, 'public');
            $previewPictureFilePath = '/storage' . $path . $fileName;
        }

        $news->fill([
            'preview_title' => $request['preview_title'],
            'detail_title' => $request['detail_title'],
            'date' => $request['date'],
            'preview_description' => $request['preview_description'],
            'detail_description' => $request['detail_description'],
            'main_picture' => $mainPictureFilePath ?? $news->main_picture,
            'preview_picture' => $previewPictureFilePath ?? $news->preview_picture,
        ]);

        $news->save();
        return $news->id;
    }

    public function delete(News $news)
    {
        return $news->delete();
    }
}
