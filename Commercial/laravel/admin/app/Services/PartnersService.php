<?php

namespace App\Services;

use App\Models\Partners;
use Illuminate\Http\Request;
date_default_timezone_set('Europe/Moscow');

class PartnersService
{

    public function create(Request $request)
    {

        $PictureFilePath = null;

        $path = '/partners/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $partner = new Partners([
            'name' => $request['name'],
            'description' => $request['description'],
            'picture' => $PictureFilePath,
            'link' => $request['link'],
            'color' => $request['color'],
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'sort' => $request['sort'],
        ]);
        $partner->save();
        return $partner->id;
    }

    public function update(Partners $partner, $request)
    {
        $PictureFilePath = null;
        $path = '/partners/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $partner->fill([
            'name' => $request['name'],
            'description' => $request['description'],
            'picture' => $PictureFilePath??$partner->picture,
            'link' => $request['link'],
            'color' => $request['color'],
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            'sort' => $request['sort'],

        ]);

        $partner->save();
        return $partner->id;

    }

    public function delete(Partners $partner)
    {
        return $partner->delete();
    }
}
