<?php
require __DIR__ . "/vendor/autoload.php";

const INITIAL = [
    "apple" => 10,
    "pear" => 15
];

use Model\{Garden, Apple, Pear};

/**
 * Первичная инициализация
 */
$garden = new Garden();

foreach (INITIAL as $treeType => $count) {
    for ($i = 0; $i < $count; $i++) {
        $tempTree=null;
        if ($treeType === "apple") {
            $tempTree = new Apple();

        } elseif ($treeType === "pear") {
            $tempTree = new Pear();
        }
        $garden->addNewTree($tempTree);
    }
}

/**
 * Выводим кол-во деревьев в саду
 */
$garden->countTree();

/**
 * Собираем фрукты
 */
$garden->harvest();

/**
 * Выводим кол-во собранных фруктов
 */
$garden->countFruits();