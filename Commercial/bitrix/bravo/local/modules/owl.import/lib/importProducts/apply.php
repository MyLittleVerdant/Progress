<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');

// Early exit if no element are specified
if (!$_REQUEST['element'] || $_REQUEST['element'] == "false") {
    die(json_encode($_REQUEST));
}

//Чтобы не вылетало с таймаутом БД.
$_SESSION['STOP_INIT_FIELD_PROCESSING'] = true;
$product = $_REQUEST['element'];

$product['NAME'] = trim($product['NAME']);

// Внешний код товара. По нему будут находиться товары в базе
$xmlCode = ($product['XML_ID'] != "")
    ? $product['XML_ID']
    : $product['VNESHNIY_KOD'];

// Поля, которые не являются пользовательскими. Вытаскиваем в отдельный массив и стираем из основного
$fields = [
    'CODE' => $product['CODE'],
    'XML_ID' => $xmlCode,
    'NAME' => $product['NAME'],
    // В XLSX шаблоне поля перепутаны. Так что тут теперь будут русские ключи
    'ROOMS_CATEGORY' => $product['Комнаты: Категория'],
    'ROOMS_SUBCATEGORY' => $product['Комнаты: Подкатегория'],
];
foreach (array_keys($fields) as $fieldKey) {
    unset($product[$fieldKey]);
}

// Ищем раздел первого уровня по названию
$properties = $product;
$section = CIBlockSection::GetList([], ['IBLOCK_ID' => 8, 'NAME' => $properties['RAZDEL']], '',
    ['ID', 'IBLOCK_ID'])->Fetch();

// Ищем раздел второго уровня по названию + по разделу первого уровня
if ($section['ID'] && $properties['KATEGORIYA']) {
    $section = CIBlockSection::GetList([],
        ['IBLOCK_ID' => 8, 'NAME' => $properties['KATEGORIYA'], 'SECTION_ID' => $section['ID']], '',
        ['ID', 'IBLOCK_ID'])->Fetch();
}

// Транслитерируем название в символьный код
$fields['CODE'] = Cutil::translit($fields['NAME'], "ru",
    ["replace_space" => "_", "change_case" => "L", "replace_other" => "_"]);

// Дописываем размеры в симв. код, чтобы не было пересечений
foreach ($fields as $fieldName => $fieldValue) {
    if ((stripos($fieldName, 'TSVET', 0) !== false || in_array($fieldName,
                ['DLINA', 'SHIRINA', 'VYSOTA'])) && $fieldValue != "") {
        $fields['CODE'] .= "_" . Cutil::translit(
                str_replace('/', '_', $fieldValue),
                "ru",
                ["replace_space" => "_", "change_case" => "L", "replace_other" => "_"]
            );
    }
}

// Куда вставлять данные. ID инфоблока раздела
$fields['IBLOCK_ID'] = 8;
$fields['IBLOCK_SECTION_ID'] = $section['ID'];
$fieldsRooms = null;

// TODO: Вынести поиск категорий в метод. Не горит.

// Если указан раздел категорий, то так же создаем в инфоблоке категорий.
if ($fields['ROOMS_CATEGORY']) {
    $fieldsRooms = $fields;
    $fieldsRooms['IBLOCK_ID'] = 21;

    $roomsCategory = CIBlockSection::GetList([],
        ['IBLOCK_ID' => $fieldsRooms['IBLOCK_ID'], 'NAME' => $fieldsRooms['ROOMS_CATEGORY']],
        '',
        ['ID', 'IBLOCK_ID']
    )->Fetch();
    $fieldsRooms['IBLOCK_SECTION_ID'] = $roomsCategory['ID'];

    // Ищем раздел второго уровня по названию + по разделу первого уровня
    if ($roomsCategory['ID'] && $fieldsRooms['ROOMS_SUBCATEGORY']) {
        $roomsSubCategory = CIBlockSection::GetList(
            [],
            ['IBLOCK_ID' => $fieldsRooms['IBLOCK_ID'], 'NAME' => $fieldsRooms['ROOMS_SUBCATEGORY'], 'SECTION_ID' => $roomsCategory['ID']],
            '',
            ['ID', 'IBLOCK_ID']
        )->Fetch();
        $fieldsRooms['IBLOCK_SECTION_ID'] = $roomsSubCategory['ID'];
    }
}

// Если в таблице указан ID товара, то апдейтим его.
// TODO: Апдейт товара по XML_ID
if ($fields['ID']) {
    $updateResult = (new CIBlockElement())->Update($product['ID'], $fields, false, false);
    CIBlockElement::SetPropertyValuesEx($product['ID'], 8, $properties);

    echo json_encode([
        'success' => true,
        'type' => 'update',
        'id' => $_REQUEST['element']['ID'],
        'array' => [$fields, $properties]
    ]);
} else {
    $fields['PROPERTY_VALUES'] = $properties;
    $ibElement = new CIBlockElement();
    $ibElement->Add($fields);

    $roomsId = null;
    if ($fieldsRooms){
        $fieldsRooms['PROPERTY_VALUES'] = $properties;
        $ibElementRooms = new CIBlockElement();
        $roomsId = $ibElementRooms->Add($fieldsRooms);
    }

    echo json_encode([
        'success' => $ibElement->LAST_ERROR !== "",
        'type' => 'add',
        'id' => $_REQUEST['element']['ID'],
        'lastError' => $ibElement->LAST_ERROR,
        'roomsLastError' => $ibElementRooms->LAST_ERROR,
        'roomsId' => $roomsId,
        '$fieldsRooms' => $fieldsRooms,
        'array' => [$fields, $properties]
    ]);
}
