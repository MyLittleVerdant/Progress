<?php

namespace App\Services;

use App\Models\Careers;
use Illuminate\Http\Request;

date_default_timezone_set('Europe/Moscow');

class CareersService
{

    public function update(Careers $career, $request)
    {
        $career->fill([
            'description' => $request['description'],
            'created_at' => $request['created_at'],
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        $career->save();
        return $career->id;

    }

}
