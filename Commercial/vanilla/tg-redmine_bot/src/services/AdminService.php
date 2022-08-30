<?php

namespace TgRedmine\services;

use TgRedmine\helpers\Telegram;
use TgRedmine\models\User;

class AdminService
{
    public static function notify($text)
    {
        foreach ((new User())->all() as $member) {
            if ($member['admin']) {
                $name = explode(' ', $member['name'])[0];
                $text=str_replace('Хей, парень', "Хей, $name", $text);
                Telegram::send($member['telegram'], $text);
            }
        }
    }
}