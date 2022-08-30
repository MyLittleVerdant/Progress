<?php

namespace FormHandler\services;

use FormHandler\models\Table;

class TableService
{
    public static function writeToTable($spreadsheetId, $range, $data, $column = 'false')
    {
        $tabler = new Table();
        return $tabler->write($spreadsheetId, $range, $data, $column);
    }

    public static function readFromTable($spreadsheetId, $range = null)
    {
        $tabler = new Table();
        if (empty($range)) {
            return $tabler->read($spreadsheetId);
        } else {
            return $tabler->readRange($spreadsheetId, $range);
        }

    }
}