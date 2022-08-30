<?php
require __DIR__ . '/vendor/autoload.php';

if ($_REQUEST['type'] == 'collect') {
    unset($_REQUEST['type']);
    $spreadsheetId = $_REQUEST['spreadsheetId'];
    unset($_REQUEST['spreadsheetId']);
    $range = $_REQUEST['range'];
    unset($_REQUEST['range']);
    $resCol = $_REQUEST['resultRow'];
    unset($_REQUEST['resultRow']);

    $keys = [];
    foreach ($_REQUEST as $key => $param) {
        $keys[] = --$param;
    }

    if ($spreadsheetId) {
        $googleAccountKeyFilePath = 'service_key.json';
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);

        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope('https://www.googleapis.com/auth/spreadsheets');

        $service = new Google_Service_Sheets($client);

        $data = [];
        $forms['forms'] = [];
        $response = $service->spreadsheets->get($spreadsheetId);
        if (!empty($range)) {
            $data = $service->spreadsheets_values->get($spreadsheetId, $range);
            $forms['forms'] = sheetToArray($data["values"], $keys, $resCol - 1);

        } else {
            // Обход всех листов
            foreach ($response->getSheets() as $sheet) {
                // Получаем свойства листа
                $sheetProperties = $sheet->getProperties();
                $data = $service->spreadsheets_values->get($spreadsheetId, $sheetProperties->title);
                $forms['forms'] = sheetToArray($data["values"], $keys, $resCol - 1);
            }
        }
        $jsonForms = json_encode($forms);
        $result = file_put_contents("jsonTable.json", $jsonForms);
        if ($result) {
            echo json_encode(["error" => false, "msg" => $forms]);
        } else {
            json_encode(["error" => true, "msg" => "GG"]);
        }

    }
} elseif ($_REQUEST['type'] == 'calc') {
    unset($_REQUEST['type']);
    $table = file_get_contents("jsonTable.json");
    echo json_encode(["error" => false, "msg" => $table]);
//    $table = json_decode($table, true);
//
//    $keys = [];
//    foreach ($_REQUEST as $key => $param) {
//        $keys[] = $param;
//    }
//    $data = getResult($table['forms'], $keys, 0, count($keys));

//    echo "<pre>", var_dump($data), "</pre>";
}


/**
 * Чтение страницы таблицы в массив
 * @param $sheetData array данные страницы
 * @param $keys array ключи в порядке создания структуры
 * @param $resultCol int порядковый номер колонки итогового занчения
 * @return array
 */
function sheetToArray($sheetData, $keys, $resultCol)
{
    $data = [];
    $temp = [];
    $header = null;
    $skip = true;
    $depth = count($keys);
    foreach ($sheetData as $row) {
        if ($skip === true) {
            $header = $row[$resultCol];
            if (!array_key_exists($header, $data)) {
                $data[$header] = [];
            }
            $skip = false;
            continue;
        } elseif (empty($row)) {
            $skip = true;
        } elseif (!$skip) {
            extendArray($data[$header], $row, $keys, $row[$resultCol], 0, $depth);
        }
    }
    return $data;
}

/**
 * Рекурсивная функция углубления результирующего массива
 * @param $arr array результирующий массив
 * @param $rowData array строка таблицы
 * @param $keys array ключи в порядке создания структуры
 * @param $value mixed итоговое занчение
 * @param $num int текущий уровень массива
 * @param $lvl int максимальный уровень массива
 * @return mixed
 */
function extendArray(&$arr, $rowData, $keys, $value, $num, $lvl)
{
    if ($num == $lvl) {
        return $value;
    } else {
        $arr[$rowData[$keys[$num]]] = extendArray($arr[$rowData[$keys[$num]]], $rowData, $keys, $value, ++$num, $lvl);
        return $arr;
    }

}

/**
 * Рекурсивно находит данные по ключам
 * @param $data array массив данных
 * @param $keys array ключи
 * @param $curlvl int текущий уровень
 * @param $lvl int максимальный уровень массива
 * @return mixed
 */
function getResult($data, $keys, $curlvl, $lvl)
{
    if ($curlvl != $lvl) {
        foreach ($keys as $num => $key) {
            if (!empty($data[$key])) {
                $newKeys = $keys;
                unset($newKeys[$num]);
                return getResult($data[$key], $newKeys, ++$curlvl, $lvl);
            }
        }
        return $data;

    } else {
        return $data;
    }

}

?>
