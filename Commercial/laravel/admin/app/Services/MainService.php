<?php

namespace App\Services;

use App\Models\Main;
use Illuminate\Http\Request;

date_default_timezone_set('Europe/Moscow');

class MainService
{

    public function update(Main $main, $request)
    {

        $path = '/main/';
        $desktopFilePath = null;
        if (!empty($request->file('desktop_video'))) {
            $fileName = uniqid() . '_' . $request->file('desktop_video')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('desktop_video')->storeAs($path, $fileName, 'public');
            $desktopFilePath = '/storage' . $path . $fileName;
        }
        $mobileFilePath = null;
        if (!empty($request->file('mobile_video'))) {
            $fileName = uniqid() . '_' . $request->file('mobile_video')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('mobile_video')->storeAs($path, $fileName, 'public');
            $mobileFilePath = '/storage' . $path . $fileName;
        }

        $main->fill([
            'desktop_video' => $desktopFilePath ?? $main->desktop_video,
            'mobile_video' => $mobileFilePath ?? $main->mobile_video,
            'created_at' => $request['created_at'],
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        $main->save();
        return $main->id;

    }

}
