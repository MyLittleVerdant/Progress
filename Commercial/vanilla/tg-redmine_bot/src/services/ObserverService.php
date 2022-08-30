<?php
namespace TgRedmine\services;

use TgRedmine\helpers\Telegram;
use TgRedmine\models\User;

class ObserverService
{
    public static function notify($text)
    {
        foreach ((new User())->getObservers() as $observer) {
            $name = explode(' ', $observer['name'])[0];
            $text=str_replace('Хей, парень', "Хей, $name", $text);
            Telegram::send($observer['telegram'], $text);
        }
    }
}