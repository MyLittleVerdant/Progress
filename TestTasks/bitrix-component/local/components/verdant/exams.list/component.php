<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
CModule::IncludeModule("iblock");
$res = CIBlockElement::GetList(['date_active_from' => 'asc'], ["IBLOCK_ID" => $arParams["IBLOCK_ID"]],
    false,
    false,
    ["ID", "IBLOCK_ID", "NAME"]);
while ($ob = $res->GetNextElement()) {
    $arItem = $ob->GetFields();
    $arItem['PROPERTIES'] = [];
    $array[$arItem['ID']] = $arItem;
}
CIBlockElement::GetPropertyValuesArray($array, $arParams["IBLOCK_ID"], ['IBLOCK_ID' => $arParams["IBLOCK_ID"]]);
$arResult["ITEMS"] = $array;
$this->IncludeComponentTemplate();