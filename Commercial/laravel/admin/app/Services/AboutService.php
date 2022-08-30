<?php

namespace App\Services;

use App\Models\About;
use Illuminate\Http\Request;


class AboutService
{
    public function create(Request $request)
    {
        $PictureFilePath = null;
        $path = '/about/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $SignatureFilePath = null;
        $path = '/about/';
        if (!empty($request->file('signature'))) {
            $fileName = uniqid() . '_' . $request->file('signature')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('signature')->storeAs($path, $fileName, 'public');
            $SignatureFilePath = '/storage' . $path . $fileName;
        }

        $aboutBlock = new About([
            'key' => $request['key'],
            'title' => $request['title'],
            'description' => $request['description'],
            'short_description' => $request['short_description'] ?? null,
            'subtitle' => $request['subtitle'] ?? null,
            'picture' => $PictureFilePath ?? null,
            'signature' => $SignatureFilePath ?? null,
            'CEO_name' => $request['CEO_name'] ?? null,
            'first_quarter_num' => $request['first_quarter_num'] ?? null,
            'first_quarter_title' => $request['first_quarter_title'] ?? null,
            'second_quarter_num' => $request['second_quarter_num'] ?? null,
            'second_quarter_title' => $request['second_quarter_title'] ?? null,
            'third_quarter_num' => $request['third_quarter_num'] ?? null,
            'third_quarter_title' => $request['third_quarter_title'] ?? null,
            'fourth_quarter_num' => $request['fourth_quarter_num'] ?? null,
            'fourth_quarter_title' => $request['fourth_quarter_title'] ?? null,
            'sort' => $request['sort'],
            'whale' => $request['whale'],

        ]);
        $aboutBlock->save();
        return $aboutBlock->id;
    }

    public function update(About $aboutBlock, $request)
    {
        $PictureFilePath = null;
        $path = '/about/';
        if (!empty($request->file('picture'))) {
            $fileName = uniqid() . '_' . $request->file('picture')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('picture')->storeAs($path, $fileName, 'public');
            $PictureFilePath = '/storage' . $path . $fileName;
        }

        $SignatureFilePath = null;
        $path = '/about/';
        if (!empty($request->file('signature'))) {
            $fileName = uniqid() . '_' . $request->file('signature')->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $request->file('signature')->storeAs($path, $fileName, 'public');
            $SignatureFilePath = '/storage' . $path . $fileName;
        }

        $aboutBlock->fill([
            'key' => $request['key'],
            'title' => $request['title'],
            'description' => $request['description'],
            'short_description' => $request['short_description'] ?? null,
            'subtitle' => $request['subtitle'] ?? null,
            'picture' => $PictureFilePath ?? $aboutBlock->picture,
            'signature' => $SignatureFilePath ?? $aboutBlock->signature,
            'CEO_name' => $request['CEO_name'] ?? null,
            'first_quarter_num' => $request['first_quarter_num'] ?? null,
            'first_quarter_title' => $request['first_quarter_title'] ?? null,
            'second_quarter_num' => $request['second_quarter_num'] ?? null,
            'second_quarter_title' => $request['second_quarter_title'] ?? null,
            'third_quarter_num' => $request['third_quarter_num'] ?? null,
            'third_quarter_title' => $request['third_quarter_title'] ?? null,
            'fourth_quarter_num' => $request['fourth_quarter_num'] ?? null,
            'fourth_quarter_title' => $request['fourth_quarter_title'] ?? null,
            'sort' => $request['sort'] ?? 500,
            'whale' => $request['whale'],
        ]);

        $aboutBlock->save();
        return $aboutBlock->id;
    }

    public function delete(About $aboutBlock)
    {
        return $aboutBlock->delete();
    }
}
