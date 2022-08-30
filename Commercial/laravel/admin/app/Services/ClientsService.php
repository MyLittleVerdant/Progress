<?php

namespace App\Services;

use App\Models\Clients;
use Illuminate\Http\Request;

date_default_timezone_set('Europe/Moscow');

class ClientsService
{

    public function create(Request $request)
    {
        $PictureFilePath = null;

        $path = '/clients/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $client = new Clients(
            [
                'sort' => $request['sort'],
                'name' => $request['name'],
                'type' => $request['type'],
                'picture' => $PictureFilePath,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]
        );
        $client->save();
        return $client->id;
    }

    public function update(Clients $client, $request)
    {
        $PictureFilePath = null;
        $path = '/clients/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $client->fill(
            [
                'sort' => $request['sort'],
                'name' => $request['name'],
                'type' => $request['type'],
                'picture' => $PictureFilePath ?? $client->picture,
                'created_at' => $request['created_at'] ?? date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ]
        );

        $client->save();
        return $client->id;
    }

    public function delete(Clients $client)
    {
        return $client->delete();
    }
}
