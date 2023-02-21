<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
    "NAME" => GetMessage("Расписание"),
    "DESCRIPTION" => GetMessage("Выводим расписание экзаменов"),
    "PATH" => array(
        "ID" => "verdant",
        "CHILD" => array(
            "ID" => "schedule",
            "NAME" => "Расписание экзаменов"
        )
    ),
    "ICON" => "/images/icon.gif",
);