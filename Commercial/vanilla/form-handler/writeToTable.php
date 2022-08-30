<?php
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', E_ALL);

use FormHandler\helpers\Logging;
use FormHandler\services\TableService;

require $_SERVER["DOCUMENT_ROOT"] . '/form-handler/vendor/autoload.php';
Logging::write_in_csv([
    ['Время', 'ID листа', 'Диапазон', "Данные", "Расположение"],
    [
        date('Y-m-d H:i:s'),
        $_REQUEST['spreadsheetId'],
        $_REQUEST['range'],
        $_REQUEST['data'],
        $_REQUEST['column'] ? 'vertical' : 'horizontal'
    ],
    [],[]
], "logs/table/" . date('Y-m-d H') . ".csv");
$response = TableService::writeToTable($_REQUEST['spreadsheetId'], $_REQUEST['range'], json_decode($_REQUEST['data']),
    $_REQUEST['column']);
//$response = TableService::readFromTable($_REQUEST['spreadsheetId']);
//$response = TableService::readFromTable($_REQUEST['spreadsheetId'],$_REQUEST['range']);
echo "<pre>", var_dump($response), "</pre>";
