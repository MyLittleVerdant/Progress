<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');

// Early exit if no element are specified
if (!$_REQUEST['element'] || $_REQUEST['element'] == "false") {
    die("Пустой запрос");
}

// Чтобы не вылетало с таймаутом БД.
$_SESSION['STOP_INIT_FIELD_PROCESSING'] = true;
$product = $_REQUEST['element'];

$CATALOG_IBLOCK_ID = 8;
$CATALOG_ADDS_IBLOCK_SECTION_ID = 4571;
$arProducts = [];

if (!$product["ID"]) {
    echo json_encode([
        'success' => false,
        'id' => '',
        'description' => "Ошибка. Поле \"Ид9\" пустое",
        'num' => $product['NUM']
    ]);
} else {
    $arProduct = [
        'IBLOCK_ID' => $CATALOG_IBLOCK_ID,
        'IBLOCK_SECTION_ID' => $CATALOG_ADDS_IBLOCK_SECTION_ID,
        'CODE' => $product["ID"],
        'XML_ID' => $product["ID"],
        'NAME' => $product["NAME"]
    ];

    $iblockElement = new CIBlockElement();
    $addResult = $iblockElement->Add($arProduct);

    echo json_encode([
        'success' => (bool)$addResult,
        'id' => $addResult,
        'description' => $addResult ? "Добавление прошло успешно. ID элемента = " . $addResult : "Ошибка при добавлении. " . $iblockElement->LAST_ERROR,
        'num' => $product['NUM']
    ]);
}

