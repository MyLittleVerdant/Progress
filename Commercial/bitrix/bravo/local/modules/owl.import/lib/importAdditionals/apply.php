<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');

// Early exit if no element are specified
if (!$_REQUEST['group'] || $_REQUEST['group'] == "false") {
    die("Пустой запрос");
}

//Чтобы не вылетало с таймаутом БД.
$_SESSION['STOP_INIT_FIELD_PROCESSING'] = true;
$group = $_REQUEST['group'];

$COMPLECTS_IBLOCK_ID = 22;

// Заливаем всё это дело в базу
$productSets = [];

foreach ($group as $key => $element) {
    if ($element['type'] === 'product') {
        $mainProduct = $element;
        unset($group[$key]);
        break;
    }
}

if (!$mainProduct['XML_ID']) {
    echo json_encode([
        'success' => false,
        'id' => '',
        'description' => "Ошибка. Поле \"Ид9\" для главного продукта пустое",
        'num' => $_REQUEST['num']
    ]);
}else{
    // Вытаскиваем все допы, матрасы и чекбоксы
    $addons = array_filter($group, fn($element) => $element['type'] === 'addon');
    $mattresses = array_filter($group, fn($element) => $element['type'] === 'mattress');
    $checkboxes = array_filter($group, fn($element) => $element['type'] === 'checkbox');

// Ставим порядковый номер для комплекта
    $existingSetsArray = array_column($productSets, 'MAIN_PRODUCT');
    $setsWithCurrentXML = array_filter($existingSetsArray, fn($productXML) => $productXML === $mainProduct['XML_ID']);
    $setCount = count($setsWithCurrentXML) + 1;

    $productSet = [
        "NAME" => "Комплект $setCount",
        "IBLOCK_ID" => $COMPLECTS_IBLOCK_ID,
        "MAIN_PRODUCT" => $mainProduct['XML_ID'],
        "PROPERTY_VALUES" => [
            "PRODUCTS" => [
                $mainProduct['XML_ID'],
            ],
            // Допы и чекбоксы привязываются по XML_ID. Матрасы ставятся как 'Y' / 'N'
            "ADDONS" => array_column($addons, 'XML_ID'),
            "CHECKBOXES" => array_column($checkboxes, 'XML_ID'),
            "HAS_MATTRESS" => !empty($mattresses) ? "Y" : "N",
        ],
    ];
    $productSets[] = $productSet;

    unset($productSet["MAIN_PRODUCT"]);

    $ibElement = new CIBlockElement();
    $result = $ibElement->Add($productSet);
    echo json_encode([
        'success' => (bool)$result,
        'id' => $result,
        'description' => $result ? "Добавление прошло успешно. ID элемента = " . $result : "Ошибка при добавлении. " . $ibElement->LAST_ERROR,
        'num' => $_REQUEST['num']
    ]);
}






