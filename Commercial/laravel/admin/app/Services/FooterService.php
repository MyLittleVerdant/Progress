<?php

namespace App\Services;

use App\Models\Footer;
use App\Models\Social;
use Illuminate\Http\Request;

date_default_timezone_set('Europe/Moscow');

class FooterService
{
    private function addPicture($picture, $path)
    {
        $pictureFilePath = null;
        $fileName = uniqid() . '_' . $picture->getClientOriginalName();
        $fileName = str_replace(' ', '_', $fileName);
        $picture->storeAs($path, $fileName, 'public');
        $pictureFilePath = '/storage' . $path . $fileName;

        return $pictureFilePath;
    }

    private function parseKeys($request)
    {
        $parse = [
            'newList' => [],
            'oldList' => [],
        ];

        /**
         * Парсинг инпутов
         */
        foreach ($request->except('_token') as $key => $value) {

            //Новые поля формы с соц.сетями
            if (strpos($key, '_new_') !== false) {
                $id = intval(preg_replace('/[^0-9]+/', '', $key), 10);
                if (!empty($value)) {
                    $parse['newList'][$id][$key] = $value;
                }
            }
            //Старые поля формы с соц.сетями
            if (strpos($key, '_old_') !== false) {
                $id = intval(preg_replace('/[^0-9]+/', '', $key), 10);
                $parse['oldList'][$id][$key] = $value;
            }

        }
        return $parse;
    }

    public function update(Footer $footer, $request)
    {

        $footer->fill([
            'policy' => $request->policy ?? $footer->policy,
            'phone' => $request->phone ?? $footer->phone,
            'created_at' => $request['created_at'],
            'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
        ]);

        $footer->save();

        $parse = self::parseKeys($request);

        /**
         * Добавление новых соц. сетей
         */
        if (!empty($parse['newList'])) {
            foreach ($parse['newList'] as $socialKey => $socialItem) {
                if (!empty($socialItem)) {
                    $pictureFilePath = null;
                    //Картинка пункта
                    if (!empty($socialItem['picture_new_' . $socialKey])) {
                        $socialIconsPath = '/footer/social/img/';
                        $pictureFilePath = self::addPicture($socialItem['picture_new_' . $socialKey], $socialIconsPath);
                    }
                    $social = new Social([
                        'name' => $socialItem['name_new_' . $socialKey],
                        'link' => $socialItem['link_new_' . $socialKey],
                        'picture' => $pictureFilePath,
                        'footer_id' => $footer->id ?? 1,
                    ]);
                    $social->save();

                }
            }
        }

        /**
         * Обновление старых пунктов списка
         */
        if (!empty($parse['oldList'])) {
            foreach ($parse['oldList'] as $socialKey => $socialItem) {
                $social = Social::find($socialKey);
                $pictureFilePath = null;
                //Картинка пункта
                if (!empty($socialItem['picture_old_' . $socialKey])) {
                    $socialIconsPath = '/favours/social/img/';
                    $pictureFilePath = self::addPicture($socialItem['picture_old_' . $socialKey], $socialIconsPath);
                }

                $social->fill([
                    'name' => $socialItem['name_old_' . $socialKey],
                    'link' => $socialItem['link_old_' . $socialKey],
                    'picture' => $pictureFilePath ?? $social->picture,
                    'footer_id' => $footer->id ?? 1,
                ]);

                $social->save();


            }
        }
        return $footer->id;

    }

    public function delete(Footer $footer)
    {
        $socials = $footer->details;
        if ($socials) {
            foreach ($socials as $social) {

                $social->delete();
            }
        }

        return $footer->delete();
    }

}
