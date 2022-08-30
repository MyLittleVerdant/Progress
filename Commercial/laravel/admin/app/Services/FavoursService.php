<?php

namespace App\Services;

use App\Models\FavourDetails;
use App\Models\Favours;
use App\Models\Medias;
use Illuminate\Http\Request;

date_default_timezone_set('Europe/Moscow');

class FavoursService
{
    /**
     * Добавляет в таблицу medias все файлы массива
     * @param $gallery array массив файлов
     * @param $type string тип файла
     * @param $parentID int id родительского элемента
     * @param $parentName string имя родительского элемента
     * @param $path string путь хранения файлов
     * @return void
     */
    private function addGallery($gallery, $type, $parentID, $parentName, $path)
    {
        $mediaFilePath = null;
        foreach ($gallery as $key => $mediaFile) {

            $fileName = uniqid() . '_' . $mediaFile->getClientOriginalName();
            $fileName = str_replace(' ', '_', $fileName);
            $mediaFile->storeAs($path, $fileName, 'public');
            $mediaFilePath = '/storage' . $path . $fileName;

            $media = new Medias([
                'file' => $mediaFilePath,
                'type' => $type,
//                'title' => $mediaFile->getClientOriginalName(),
                'relation_id' => $parentID !== false ? $parentID : $key,
                'relation_name' => $parentName,
            ]);
            $media->save();
        }
    }

    private function addPicture($picture, $path)
    {
        $pictureFilePath = null;
        $fileName = uniqid() . '_' . $picture->getClientOriginalName();
        $fileName = str_replace(' ', '_', $fileName);
        $picture->storeAs($path, $fileName, 'public');
        $pictureFilePath = '/storage' . $path . $fileName;

        return $pictureFilePath;
    }

    private function delPoster($gallery)
    {
        foreach ($gallery as $key => $mediaFile) {
            $poster = \App\Models\Medias::query()->where(['relation_id' => $key, 'relation_name' => 'video']);
            $poster->delete();
        }
    }

    private function parseKeys($request)
    {
        $parse = [
            'picTitles' => [],
            'picSubtitles' => [],
            'picSort' => [],
            'posters' => [],
            'newList' => [],
            'oldList' => [],
        ];

        /**
         * Парсинг инпутов
         */
        foreach ($request->except('_token') as $key => $value) {
            //Подзаголовки картинок в фотогалерее
            if (strpos($key, 'picture_subtitle_') !== false) {
                $id = intval(preg_replace('/[^0-9]+/', '', $key), 10);
                $parse['picSubtitles'][$id] = $value;
            }
            //Заголовки картинок в фотогалерее
            if (strpos($key, 'picture_title_') !== false) {
                $id = intval(preg_replace('/[^0-9]+/', '', $key), 10);
                $parse['picTitles'][$id] = $value;
            }
            //Сортировка картинок в фотогалерее
            if (strpos($key, 'picture_sort_') !== false) {
                $id = intval(preg_replace('/[^0-9]+/', '', $key), 10);
                $parse['picSort'][$id] = $value;
            }
            //Сортировка видео в видеогалерее
            if (strpos($key, 'video_sort_') !== false) {
                $id = intval(preg_replace('/[^0-9]+/', '', $key), 10);
                $parse['videoSort'][$id] = $value;
            }
            //Новые поля формы с пунктами
            if (strpos($key, '_new_') !== false) {
                $id = intval(preg_replace('/[^0-9]+/', '', $key), 10);
                if (!empty($value)) {
                    $parse['newList'][$id][$key] = $value;
                }
            }
            //Старые поля формы с пунктами
            if (strpos($key, '_old_') !== false) {
                $id = intval(preg_replace('/[^0-9]+/', '', $key), 10);
                $parse['oldList'][$id][$key] = $value;
            }
            //Постеры к видеогалерее
            if (strpos($key, 'poster_') !== false) {
                $id = intval(preg_replace('/[^0-9]+/', '', $key), 10);
                $parse['posters'][$id] = $value;
            }

        }
        return $parse;
    }

    public function create(Request $request)
    {
        $previewPicturePath = null;
        $path = '/favour/';
        if (!empty($request->file('preview_picture'))) {
            $previewPicturePath = self::addPicture($request->file('preview_picture'), $path);
        }

        $favour = new Favours([
            'sort' => $request['sort'],
            'title' => $request['title'],
            'description' => $request['description'],
            'link' => $request['link'],
            'list' => $request['useList'] === 'on' ? 1 : 0,
            'key' => $request['key'],
            'whale' => $request['whale'],
            'preview_picture' => $previewPicturePath,
        ]);
        $favour->save();
        $favourID = $favour->id;

        /**
         * Фотогалерея
         */
        $path = '/favours/img/';
        if ($request->file("pictures")) {
            self::addGallery($request->file("pictures"), 'photo', $favourID, 'favour', $path);
        }

        /**
         * Видеогалерея
         */
        $path = '/favours/video/';
        if ($request->file("videos")) {
            self::addGallery($request->file("videos"), 'video', $favourID, 'favour', $path);
        }

        $parse = self::parseKeys($request);
        /**
         * Добавление новых пунктов списка
         */
        if (!empty($parse['newList'])) {
            foreach ($parse['newList'] as $pointKey => $point) {
                if (!empty($point)) {

                    $pictureFilePath = null;
                    //Картинка пункта
                    if (!empty($point['picture_new_' . $pointKey])) {
                        $pointPath = '/favours/point/img/';
                        $pictureFilePath = self::addPicture($point['picture_new_' . $pointKey], $pointPath);
                    }

                    $detail = new FavourDetails([
                        'title' => $point['title_new_' . $pointKey],
                        'sort' => $point['sort_new_' . $pointKey],
                        'description' => $point['description_new_' . $pointKey],
                        'subtitle' => $point['subtitle_new_' . $pointKey],
                        'list' => $point['list_new_' . $pointKey],
                        'picture' => $pictureFilePath,
                        'relation_id' => $favourID,
                        'relation_name' => 'favour',
                    ]);
                    $detail->save();
                    $pointID = $detail->id;
                    /**
                     * Фотогалерея
                     */
                    $path = '/favours/point/img/';
                    if (!empty($point['photo_gallery_new_' . $pointKey])) {
                        self::addGallery($point['photo_gallery_new_' . $pointKey], 'photo', $pointID, 'favour_detail',
                            $path);
                    }

                    /**
                     * Видеогалерея
                     */
                    $path = '/favours/point/video/';
                    if (!empty($point['video_gallery_new_' . $pointKey])) {
                        self::addGallery($point['video_gallery_new_' . $pointKey], 'video', $pointID, 'favour_detail',
                            $path);
                    }
                }
            }
        }

        return $favourID;
    }

    public function update(Favours $favour, $request)
    {
        $previewPicturePath = null;
        $path = '/favour/';
        if (!empty($request->file('preview_picture'))) {
            $previewPicturePath = self::addPicture($request->file('preview_picture'), $path);
        }

        $favour->fill([
            'title' => $request['title'],
            'description' => $request['description'],
            'link' => $request['link'],
            'list' => $request['useList'] === 'on' ? 1 : 0,
            'key' => $request['key'],
            'sort' => $request['sort'],
            'whale' => $request['whale'],
            'preview_picture' => $previewPicturePath ?? $favour->preview_picture,
        ]);
        $favour->save();
        $favourID = $favour->id;

        $parse = self::parseKeys($request);

        /**
         * Фотогалерея
         */
        $path = '/favours/img/';
        if ($request->file("pictures")) {
            self::addGallery($request->file("pictures"), 'photo', $favourID, 'favour', $path);
        }

        /**
         * Видеогалерея
         */
        $path = '/favours/video/';
        if ($request->file("videos")) {
            self::addGallery($request->file("videos"), 'video', $favourID, 'favour', $path);
        }

        $path = '/favours/video/posters/';
        if (!empty($parse['posters'])) {
            self::delPoster($parse['posters']);
            self::addGallery($parse['posters'], 'photo', false, 'video', $path);
        }

        /**
         * Добавление сортировки,заголовков и подзаголовков картинкам
         */
        if (!empty($parse['picTitles'])) {


            foreach ($parse['picTitles'] as $picID => $title) {
                $picture = Medias::find($picID);
                $picture->title = $title;
                $picture->save();
            }
        }
        if (!empty($parse['picSubtitles'])) {
            foreach ($parse['picSubtitles'] as $picID => $subtitle) {
                $picture = Medias::find($picID);
                $picture->subtitle = $subtitle;
                $picture->save();
            }
        }
        if (!empty($parse['picSort'])) {
            foreach ($parse['picSort'] as $picID => $sortValue) {
                $picture = Medias::find($picID);
                $picture->sort = $sortValue;
                $picture->save();
            }
        }
        if (!empty($parse['videoSort'])) {
            foreach ($parse['videoSort'] as $videoID => $sortValue) {
                $video = Medias::find($videoID);
                $video->sort = $sortValue;
                $video->save();
            }
        }


        /**
         * Добавление новых пунктов списка
         */
        if (!empty($parse['newList'])) {
            foreach ($parse['newList'] as $pointKey => $point) {
                if (!empty($point)) {
                    $pictureFilePath = null;
                    //Картинка пункта
                    if (!empty($point['picture_new_' . $pointKey])) {
                        $pointPath = '/favours/point/img/';
                        $pictureFilePath = self::addPicture($point['picture_new_' . $pointKey], $pointPath);
                    }

                    $detail = new FavourDetails([
                        'title' => $point['title_new_' . $pointKey],
                        'sort' => $point['sort_new_' . $pointKey],
                        'description' => $point['description_new_' . $pointKey],
                        'subtitle' => $point['subtitle_new_' . $pointKey],
                        'list' => $point['list_new_' . $pointKey],
                        'picture' => $pictureFilePath,
                        'relation_id' => $favourID,
                        'relation_name' => 'favour',
                    ]);
                    $detail->save();
                    $pointID = $detail->id;
                    /**
                     * Фотогалерея
                     */
                    $path = '/favours/point/img/';
                    if (!empty($point['photo_gallery_new_' . $pointKey])) {
                        self::addGallery($point['photo_gallery_new_' . $pointKey], 'photo', $pointID, 'favour_detail',
                            $path);
                    }
                    /**
                     * Добавление подзаголовков картинкам
                     */
                    foreach ($parse['picSubtitles'] as $picID => $subtitle) {
                        $picture = Medias::find($picID);
                        $picture->subtitle = $subtitle;
                        $picture->save();
                    }
                    /**
                     * Видеогалерея
                     */
                    $path = '/favours/point/video/';
                    if (!empty($point['video_gallery_new_' . $pointKey])) {
                        self::addGallery($point['video_gallery_new_' . $pointKey], 'video', $pointID, 'favour_detail',
                            $path);
                    }
                }
            }
        }

        /**
         * Обновление старых пунктов списка
         */
        if (!empty($parse['oldList'])) {
            foreach ($parse['oldList'] as $pointID => $point) {
                $detail = FavourDetails::find($pointID);
                //Картинка пункта
                if (!empty($point['picture_old_' . $pointID])) {
                    $pointPath = '/favours/point/img/';
                    $pictureFilePath = self::addPicture($point['picture_old_' . $pointID], $pointPath);
                }

                $detail->fill([
                    'title' => $point['title_old_' . $pointID] ?? $detail->title,
                    'sort' => $point['sort_old_' . $pointID] ?? $detail->sort,
                    'description' => $point['description_old_' . $pointID] ?? $detail->description,
                    'subtitle' => $point['subtitle_old_' . $pointID] ?? $detail->subtitle,
                    'list' => $point['list_old_' . $pointID] ?? $detail->list,
                    'picture' => $pictureFilePath ?? $detail->picture,
                    'relation_id' => $favourID,
                    'relation_name' => 'favour',
                ]);

                $detail->save();

                /**
                 * Фотогалерея
                 */
                $path = '/favours/point/img/';
                if (!empty($point['photo_gallery_old_' . $pointID])) {
                    self::addGallery($point['photo_gallery_old_' . $pointID], 'photo', $pointID, 'favour_detail',
                        $path);
                }

                /**
                 * Видеогалерея
                 */
                $path = '/favours/point/video/';
                if (!empty($point['video_gallery_old_' . $pointID])) {
                    self::addGallery($point['video_gallery_old_' . $pointID], 'video', $pointID, 'favour_detail',
                        $path);
                }
            }
        }

        return $favourID;

    }

    public function delete(Favours $favour)
    {
        $details = $favour->details;
        if ($details) {
            foreach ($details as $detail) {
                $medias = $detail->medias;
                foreach ($medias as $media) {
                    $media->delete();
                }
                $detail->delete();
            }
        }
        $medias = $favour->medias;
        if ($medias) {
            foreach ($medias as $media) {
                $media->delete();
            }
        }
        return $favour->delete();
    }
}
