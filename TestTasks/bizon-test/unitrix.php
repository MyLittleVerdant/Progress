<?php

//1.	Бинарный поиск
function search(array $data, int $number): int
{
    if (count($data) === 0) {
        return false;
    }
    $low = 0;
    $high = count($data) - 1;

    while ($low <= $high) {

        $mid = floor(($low + $high) / 2);

        if ($data[$mid] == $number) {
            return $mid;
        }

        if ($number < $data[$mid]) {
            $high = $mid - 1;
        } else {
            $low = $mid + 1;
        }
    }

    return -1;
}

//2.	Поиск выходных

function weekend(string $begin, string $end): int
{
    $dateBegin = new DateTime($begin);
    $dateEnd = new DateTime($end);

    $interval = $dateBegin->diff($dateEnd);

    $weeks = floor($interval->days / 7);

    $dateBegin = $dateBegin->format('w');
    $dateEnd = $dateEnd->format('w');

//0-никакая дата не выпадает на выходные,1-1 дата выпадает на выходные, 2- 2 даты выпадают на выходные
    $offday = 0;

    if ($dateEnd === '0' || $dateEnd === '6') {
        $offday++;
        if ($dateEnd === '0') {
            $weeks++;
        } else {
            $weeks += 0.5;
        }
    }


    if ($dateBegin === '0' || $dateBegin === '6') {
        $offday++;
        if ($dateBegin === '0') {
            $weeks += 0.5;
        } else {
            $weeks++;
        }
    }

    if ($offday == 2 && $weeks > 1) {
        $weeks--;
    }

    return $weeks * 2;
}

//3.	RGB
function rgb(int $r, int $g, int $b): int
{
    $result = '';
    foreach (array($r, $g, $b) as $row) {
        $result .= str_pad(dechex($row), 2, '0', STR_PAD_LEFT);
    }
    return hexdec($result);
}

//4.	Последовательность Фибоначчи

function fiborow(int $limit): string
{
    $row = "0 1 ";
    $one = 0;
    $two = 1;

    while ($one + $two < $limit) {
        $current = $one + $two;

        $one = $two;
        $two = $current;

        $row .= $current . " ";
    }
    return $row;
}