<?php

declare(strict_types=1);

namespace App\Helper;

class Logger
{
    public static function Log(string $message)
    {
        $logPath = $_SERVER['DOCUMENT_ROOT'] . '/../logs/' . date("m.d.y") . '.txt';
        if (file_exists($logPath)) {
            file_put_contents($logPath, date("m.d.y H:i:s") . " - " . $message . PHP_EOL, FILE_APPEND);
        } else {
            file_put_contents($logPath, date("m.d.y H:i:s") . " - " . $message . PHP_EOL);
        }
    }
}