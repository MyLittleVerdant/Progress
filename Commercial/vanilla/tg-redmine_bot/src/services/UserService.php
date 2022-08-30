<?php

namespace TgRedmine\services;


use TgRedmine\helpers\Cfg;
use TgRedmine\helpers\Telegram;
use TgRedmine\models\ProjectsNotifications;
use TgRedmine\models\User;

class UserService
{
    public static function getAllFromRedmine()
    {
        $users = (new User())->getAllUsersFromRedmine();

        return $users;
    }

    public static function getAllUser()
    {
        $users = new User();
        return $users->all();
    }

    public static function getUserByRedmineId($redmineID)
    {
        $users = new User();
        return $users->getByRedID($redmineID)[0];
    }

    public static function getUserByTgId($tgId)
    {
        $users = new User();
        return $users->getByTelegramID($tgId)[0];
    }

    public static function getUserByName($name)
    {
        $users = new User();
        return $users->getByName($name)[0];
    }

    public static function getUserByEmail($email)
    {
        $users = new User();
        return $users->getByEmail($email)[0];
    }

    public static function getDisableNotifyUsers()
    {
        $config = Cfg::getInstance();
        $filePath = $config->get('path.disable_notify');
        $data = json_decode(file_get_contents($filePath), true);

        return $data;
    }

    public static function setDisableNotifyUsers($users)
    {
        $config = Cfg::getInstance();
        $filePath = $config->get('path.disable_notify');
        file_put_contents($filePath, json_encode($users));

        return true;
    }

    /**
     * Оповещение всех пользователей, прикрепленных к проекту
     * @param $text string текст оповещения
     * @param $projID int redmineID проекта
     * @return void
     */
    public static function notify($text, $projID = null)
    {
        $users = new User();
        $members = $users->all();
        $projects = (new ProjectsNotifications())->all();
        foreach ($members as $member) {
            if (!$member['admin'] && in_array($member['redmine'], $projects[$projID]['members'])) {
                $name = @explode(' ', $member['name'])[0];
                $text = str_replace('Хей, парень', "Хей, $name", $text);
                Telegram::send($member['telegram'], $text);
            }
        }
    }

    public static function getSpecialtis()
    {
        $specialtis = [];
        foreach ((new User())->getSpecialtis() as $spec) {
            $specialtis[] = $spec["specialty"];
        }
        return $specialtis;
    }
}