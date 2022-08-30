<?php
namespace TgRedmine\services;

class NotifyService
{
  public static function prepareNotifyMessage($title, $source, $message)
  {
    if (!$title) {
      $messageText = "<b>❗️❗️❗️УВЕДОМЛЕНИЕ❗️❗️❗️</b>\n";
    } else {
      $messageText = "$title\n";
    }

    if ($source) {
      $messageText .= "<code>Сайт:</code> <u>$source</u>\n";
    }
    $messageText .= "<code>Текст:</code>\n$message";

    return $messageText;
  }
}