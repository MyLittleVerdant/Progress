<?php

namespace App\Services;

use App\Models\Contacts;
use Illuminate\Http\Request;

date_default_timezone_set('Europe/Moscow');

class ContactsService
{

    public function create(Request $request)
    {
        $contact = new Contacts([
            'name' => $request['name'],
            'sort' => $request['sort'],
            'data' => $request['data'],
            'key' => $request['key'],
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        $contact->save();
        return $contact->id;
    }

    public function update(Contacts $contact, $request)
    {
        $contact->fill([
            'name' => $request['name'],
            'sort' => $request['sort'],
            'data' => $request['data'],
            'key' => $request['key'],
            'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        $contact->save();
        return $contact->id;

    }

    public function delete(Contacts $contact)
    {
        return $contact->delete();
    }
}
