<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Http\Request;
date_default_timezone_set('Europe/Moscow');

class TeamService
{

    public function create(Request $request)
    {

        $PictureFilePath = null;

        $path = '/team/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $member = new Team([
            'name' => $request['name'],
            'post' => $request['post'],
            'sort' => $request['sort'],
            'picture' => $PictureFilePath,
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);
        $member->save();
        return $member->id;
    }

    public function update(Team $member, $request)
    {
        $PictureFilePath = null;
        $path = '/team/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $member->fill([
            'name' => $request['name'],
            'post' => $request['post'],
            'sort' => $request['sort'],
            'picture' => $PictureFilePath??$member->picture,
            'created_at' => $request['created_at'] ?? date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        $member->save();
        return $member->id;

    }

    public function delete(Team $member)
    {
        return $member->delete();
    }
}
