<?php

namespace App\Services;

use App\Models\Whales;
use Illuminate\Http\Request;

date_default_timezone_set('Europe/Moscow');

class WhalesService
{

    public function create(Request $request)
    {
        $PictureFilePath = null;

        $path = '/whales/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $whale = new Whales([
            'key' => $request['key'],
            'picture' => $PictureFilePath,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
        $whale->save();
        return $whale->id;
    }

    public function update(Whales $whale, $request)
    {
        $PictureFilePath = null;
        $path = '/clients/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $whale->fill([
            'key' => $request['key'],
            'picture' => $PictureFilePath ?? $whale->picture,
            'created_at' => $request['created_at'] ?? date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        $whale->save();
        return $whale->id;

    }

    public function delete(Whales $whale)
    {
        return $whale->delete();
    }
}
