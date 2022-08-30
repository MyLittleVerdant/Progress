<?php

namespace TgRedmine\services;

use TgRedmine\helpers\Telegram;
use TgRedmine\models\User;

class GlobalWatcherService
{
    public static function notify($text)
    {
        foreach ((new User())->getGlobalWatchers() as $watcher) {
            $name = explode(' ', $watcher['name'])[0];
            $text = str_replace('Хей, парень', "Хей, $name", $text);
            Telegram::send($watcher['telegram'], $text);
        }
    }

    /**
     * Оповещает определенных наблюдателей
     * @param $watchers array массив наблюдателей
     * @param $text
     * @return void
     */
    public static function notifyCertain($watchers, $text)
    {

        foreach ($watchers as $watcherID) {
            $watcher = UserService::getUserByRedmineId($watcherID);
            $name = explode(' ', $watcher['name'])[0];
            $text = str_replace('Хей, парень', "Хей, $name", $text);
            Telegram::send($watcher['telegram'], $text);
        }
    }

    public static function collectIDs()
    {
        $IDs = [];
        foreach ((new User())->getGlobalWatchers() as $watcher) {
            $IDs[] = $watcher["redmine"];
        }

        return array_combine($IDs, $IDs);
    }

    /**
     * Возвращает массив глобальных наблюдателей,которых нет в массиве пользователей
     * @param $users array массив ID пользователей для проверки
     * @return bool
     */
    public static function isWatcher($users)
    {
        $watchers = self::collectIDs();
        foreach ($users as $userID) {
            if (!empty($userID)) {
                if (in_array($userID, $watchers)) {
                    unset($watchers[$userID]);
                }
            }
        }
        return $watchers;
    }
}