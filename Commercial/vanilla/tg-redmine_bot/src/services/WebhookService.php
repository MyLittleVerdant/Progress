<?php

namespace TgRedmine\services;

class WebhookService
{
    public static function getCommand($message)
    {
        preg_match("/\/[\d\w]*/", $message, $command);

        if (count($command) > 0) {
            return $command[0];
        }

        return false;
    }

    public static function parseParams($command, $text)
    {
        $params = [];
        switch ($command) {
            case '/report':
                $explodeText = explode(' ', $text);
                if (isset($explodeText[1])) {
                    $params['from'] = $explodeText[1];
                }
                if (isset($explodeText[2])) {
                    $params['to'] = $explodeText[2];
                }
                if (isset($explodeText[3]) && $explodeText[3] == '1') {
                    $params['fusion'] = true;
                } else {
                    $params['fusion'] = false;
                }
                if (isset($explodeText[4])) {
                    $params['projects'] = explode(',', $explodeText[4]);
                } else {
                    $params['projects'] = [];
                }
                if (isset($explodeText[5])) {
                    $params['spec'] = explode(',', $explodeText[5]);
                } else {
                    $params['spec'] = [];
                }
                if (isset($explodeText[6])) {
                    $params['users'] = explode(',', $explodeText[6]);
                } else {
                    $params['users'] = [];
                }
                break;
            case '/overtime':
                $explodeText = explode(' ', $text);
                if (isset($explodeText[1])) {
                    $params['from'] = $explodeText[1];
                }
                if (isset($explodeText[2])) {
                    $params['to'] = $explodeText[2];
                }
                break;
            case '/food':
                $explodeText = explode(' ', $text);
                if (count($explodeText) == 2) {
                    $params['name'] = $explodeText[1];
                } else {
                    if (count($explodeText) > 2) {
                        $params['rating'] = $explodeText[count($explodeText) - 1];
                        unset($explodeText[0]);
                        $explodeText = array_values($explodeText);
                        unset($explodeText[count($explodeText) - 1]);
                        $params['name'] = implode(' ', $explodeText);
                    }
                }

                break;
            case '/create':
                $explodeText = explode(' ', $text);
                if (isset($explodeText[1])) {
                    $params['domain'] = $explodeText[1];
                }
                break;
        }

        return $params;
    }
}