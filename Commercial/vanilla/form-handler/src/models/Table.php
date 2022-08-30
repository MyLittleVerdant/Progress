<?php

namespace FormHandler\models;

use FormHandler\helpers\Logging;
use Google\Exception;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

require_once $_SERVER["DOCUMENT_ROOT"] . '/form-handler/vendor/autoload.php';

class Table
{
    private $client;
    private $service;

    public function __construct()
    {
        $googleAccountKeyFilePath = $_SERVER["DOCUMENT_ROOT"] . '/form-handler/service_key.json';
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath);

        $this->client = new Google_Client();
        $this->client->useApplicationDefaultCredentials();
        $this->client->addScope('https://www.googleapis.com/auth/spreadsheets');

        $this->service = new Google_Service_Sheets($this->client);
    }

    /**
     * Запись в таблицу
     * @param $spreadsheetId
     * @param $range string Страница|Страница!Первая ячейка
     * @param $data array 2D массив строк и ячеек
     * @param $column string 'true|false' true для записи по вертикали
     * @return void
     */
    public function write($spreadsheetId, $range, $data, $column)
    {
        try {
            // Объект - диапазон значений
            $ValueRange = new Google_Service_Sheets_ValueRange();
            if ($column === 'true') {
                $ValueRange->setMajorDimension('COLUMNS');
            }
            // Устанавливаем наши данные
            $ValueRange->setValues($data);
            // Указываем в опциях обрабатывать пользовательские данные
            $options = ['valueInputOption' => 'USER_ENTERED'];
            // Добавляем наши значения в последнюю строку (где в диапазоне A1:Z все ячейки пустые)
            $response = $this->service->spreadsheets_values->append($spreadsheetId, $range, $ValueRange, $options);
            Logging::write_in_csv([[], [print_r($response, 1)], ["___________________________________________"]],
                "logs/table/" . date('Y-m-d H') . ".csv");
            return $response;

        } catch (Exception $e) {
            Logging::write_in_csv([[], [$e], ["___________________________________________"]],
                "logs/table/" . date('Y-m-d H') . ".csv");
            return "Error. Details in log";
        }

    }


    /**
     * Читает документ по ID
     * @param $spreadsheetId
     * @return array Весь документ в виде массива
     */
    public function read($spreadsheetId)
    {
        $data = [];
        $response = $this->service->spreadsheets->get($spreadsheetId);
        // Обход всех листов
        foreach ($response->getSheets() as $sheet) {
            // Получаем свойства листа
            $sheetProperties = $sheet->getProperties();
            $data[] = $this->service->spreadsheets_values->get($spreadsheetId, $sheetProperties->title);
        }
        return $data;
    }

    /**
     * Читает диапазон документа
     * @param $spreadsheetId
     * @param $range string Страница|Страница!Диапазон
     * @return \Google\Service\Sheets\ValueRange
     */
    public function readRange($spreadsheetId, $range)
    {
        return $this->service->spreadsheets_values->get($spreadsheetId, $range);
    }

}