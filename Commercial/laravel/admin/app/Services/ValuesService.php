<?php

namespace App\Services;

use App\Models\Values;
use Illuminate\Http\Request;

date_default_timezone_set('Europe/Moscow');

class ValuesService
{

    public function create(Request $request)
    {
        $PictureFilePath = null;

        $path = '/values/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $values = new Values([
            'sort' => $request['sort'],
            'name' => $request['name'],
            'description' => $request['description'],
            'picture' => $PictureFilePath,
            'relation_id' => 1,
            'relation_name' => 'career',
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
        $values->save();
        return $values->id;
    }

    public function update(Values $values, $request)
    {
        $PictureFilePath = null;
        $path = '/values/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $values->fill([
            'sort' => $request['sort'],
            'name' => $request['name'],
            'description' => $request['description'],
            'picture' => $PictureFilePath??$values->picture,
            'created_at' => $request['created_at'] ?? date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        $values->save();
        return $values->id;

    }

    public function delete(Values $values)
    {
        return $values->delete();
    }

}
