<?php
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', E_ALL);

use FormHandler\helpers\Logging;
use FormHandler\services\MailService;

require $_SERVER["DOCUMENT_ROOT"] . '/form-handler/vendor/autoload.php';
Logging::write_in_csv([
    ['Время', 'Логин', 'Пароль', "Почта отправителя", "Имя отправителя", "Получатель", "Тема", "Сообщение", "html"],
    [
        date('Y-m-d H:i:s'),
        $_REQUEST['username'],
        $_REQUEST['password'],
        $_REQUEST['from'],
        $_REQUEST['fromName'],
        $_REQUEST['to'],
        $_REQUEST['subject'],
        $_REQUEST['message'],
        $_REQUEST['html'] ? "true" : "false",
    ],
    [],
    []
], "logs/mail/" . date('Y-m-d H') . ".csv");
$response = MailService::sendMail($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['from'],
    $_REQUEST['fromName'], $_REQUEST['to'], $_REQUEST['subject'], $_REQUEST['message'], $_REQUEST['html']);
echo "<pre>", var_dump($response), "</pre>";