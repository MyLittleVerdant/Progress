<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
create_ib_type();

function create_ib_type()
{
    $iblocktype = "fusion";


    $obIBlockType = new CIBlockType;
    $arFields = array(
        "ID" => $iblocktype,
        "SECTIONS" => "Y",
        "LANG" => array(
            "ru" => array(
                "NAME" => "Фьюжен",
            ),
            "en" => array(
                "NAME" => "Fusion",
            )
        )
    );
    $res = $obIBlockType->Add($arFields);
    if (!$res) {
        $error = $obIBlockType->LAST_ERROR;
        echo "<pre>", var_dump($error), "</pre>";
    } else {
        echo "&mdash; Тип инфоблока \"Fusion\" успешно создан<br />";
        create_catalog_iblock($iblocktype);
    }
}

function create_catalog_iblock($iblocktype)
{
    $ib = new CIBlock;

    $IBLOCK_TYPE = $iblocktype; // Тип инфоблока
    $SITE_ID = "s1"; // ID сайта

    /*
    // Айдишники групп, которым будем давать доступ на инфоблок
    $contentGroupId = $this->GetGroupIdByCode("CONTENT");
    $editorGroupId = $this->GetGroupIdByCode("EDITOR");
    $ownerGroupId = $this->GetGroupIdByCode("OWNER");
    */

    //===================================//
    // Создаем инфоблок каталога товаров //
    //===================================//

    // Настройка доступа
    $arAccess = array(
        "2" => "R", // Все пользователи
    );
    /*if ($contentGroupId) $arAccess[$contentGroupId] = "X"; // Полный доступ
    if ($editorGroupId) $arAccess[$editorGroupId] = "W"; // Запись
    if ($ownerGroupId) $arAccess[$ownerGroupId] = "X"; // Полный доступ*/

    $arFields = array(
        "ACTIVE" => "Y",
        "NAME" => "Расписание экзаменов",
        "CODE" => "schedule",
        "IBLOCK_TYPE_ID" => $IBLOCK_TYPE,
        "SITE_ID" => $SITE_ID,
        "SORT" => "5",
        "GROUP_ID" => $arAccess, // Права доступа
        "FIELDS" => array(
            "DETAIL_PICTURE" => array(
                "IS_REQUIRED" => "N", // не обязательное
                "DEFAULT_VALUE" => array(
                    "SCALE" => "Y",
                    // возможные значения: Y|N. Если равно "Y", то изображение будет отмасштабировано.
                    "WIDTH" => "600",
                    // целое число. Размер картинки будет изменен таким образом, что ее ширина не будет превышать значения этого поля.
                    "HEIGHT" => "600",
                    // целое число. Размер картинки будет изменен таким образом, что ее высота не будет превышать значения этого поля.
                    "IGNORE_ERRORS" => "Y",
                    // возможные значения: Y|N. Если во время изменения размера картинки были ошибки, то при значении "N" будет сгенерирована ошибка.
                    "METHOD" => "resample",
                    // возможные значения: resample или пусто. Значение поля равное "resample" приведет к использованию функции масштабирования imagecopyresampled, а не imagecopyresized. Это более качественный метод, но требует больше серверных ресурсов.
                    "COMPRESSION" => "95",
                    // целое от 0 до 100. Если значение больше 0, то для изображений jpeg оно будет использовано как параметр компрессии. 100 соответствует наилучшему качеству при большем размере файла.
                ),
            ),
            "PREVIEW_PICTURE" => array(
                "IS_REQUIRED" => "N", // не обязательное
                "DEFAULT_VALUE" => array(
                    "SCALE" => "Y",
                    // возможные значения: Y|N. Если равно "Y", то изображение будет отмасштабировано.
                    "WIDTH" => "140",
                    // целое число. Размер картинки будет изменен таким образом, что ее ширина не будет превышать значения этого поля.
                    "HEIGHT" => "140",
                    // целое число. Размер картинки будет изменен таким образом, что ее высота не будет превышать значения этого поля.
                    "IGNORE_ERRORS" => "Y",
                    // возможные значения: Y|N. Если во время изменения размера картинки были ошибки, то при значении "N" будет сгенерирована ошибка.
                    "METHOD" => "resample",
                    // возможные значения: resample или пусто. Значение поля равное "resample" приведет к использованию функции масштабирования imagecopyresampled, а не imagecopyresized. Это более качественный метод, но требует больше серверных ресурсов.
                    "COMPRESSION" => "95",
                    // целое от 0 до 100. Если значение больше 0, то для изображений jpeg оно будет использовано как параметр компрессии. 100 соответствует наилучшему качеству при большем размере файла.
                    "FROM_DETAIL" => "Y",
                    // возможные значения: Y|N. Указывает на необходимость генерации картинки предварительного просмотра из детальной.
                    "DELETE_WITH_DETAIL" => "Y",
                    // возможные значения: Y|N. Указывает на необходимость удаления картинки предварительного просмотра при удалении детальной.
                    "UPDATE_WITH_DETAIL" => "Y",
                    // возможные значения: Y|N. Указывает на необходимость обновления картинки предварительного просмотра при изменении детальной.
                ),
            ),
            "SECTION_PICTURE" => array(
                "IS_REQUIRED" => "N", // не обязательное
                "DEFAULT_VALUE" => array(
                    "SCALE" => "Y",
                    // возможные значения: Y|N. Если равно "Y", то изображение будет отмасштабировано.
                    "WIDTH" => "235",
                    // целое число. Размер картинки будет изменен таким образом, что ее ширина не будет превышать значения этого поля.
                    "HEIGHT" => "235",
                    // целое число. Размер картинки будет изменен таким образом, что ее высота не будет превышать значения этого поля.
                    "IGNORE_ERRORS" => "Y",
                    // возможные значения: Y|N. Если во время изменения размера картинки были ошибки, то при значении "N" будет сгенерирована ошибка.
                    "METHOD" => "resample",
                    // возможные значения: resample или пусто. Значение поля равное "resample" приведет к использованию функции масштабирования imagecopyresampled, а не imagecopyresized. Это более качественный метод, но требует больше серверных ресурсов.
                    "COMPRESSION" => "95",
                    // целое от 0 до 100. Если значение больше 0, то для изображений jpeg оно будет использовано как параметр компрессии. 100 соответствует наилучшему качеству при большем размере файла.
                    "FROM_DETAIL" => "Y",
                    // возможные значения: Y|N. Указывает на необходимость генерации картинки предварительного просмотра из детальной.
                    "DELETE_WITH_DETAIL" => "Y",
                    // возможные значения: Y|N. Указывает на необходимость удаления картинки предварительного просмотра при удалении детальной.
                    "UPDATE_WITH_DETAIL" => "Y",
                    // возможные значения: Y|N. Указывает на необходимость обновления картинки предварительного просмотра при изменении детальной.
                ),
            ),
            // Символьный код элементов
            "CODE" => array(
                "IS_REQUIRED" => "Y", // Обязательное
                "DEFAULT_VALUE" => array(
                    "UNIQUE" => "Y", // Проверять на уникальность
                    "TRANSLITERATION" => "Y", // Транслитерировать
                    "TRANS_LEN" => "30", // Максмальная длина транслитерации
                    "TRANS_CASE" => "L", // Приводить к нижнему регистру
                    "TRANS_SPACE" => "-", // Символы для замены
                    "TRANS_OTHER" => "-",
                    "TRANS_EAT" => "Y",
                    "USE_GOOGLE" => "N",
                ),
            ),
            // Символьный код разделов
            "SECTION_CODE" => array(
                "IS_REQUIRED" => "Y",
                "DEFAULT_VALUE" => array(
                    "UNIQUE" => "Y",
                    "TRANSLITERATION" => "Y",
                    "TRANS_LEN" => "30",
                    "TRANS_CASE" => "L",
                    "TRANS_SPACE" => "-",
                    "TRANS_OTHER" => "-",
                    "TRANS_EAT" => "Y",
                    "USE_GOOGLE" => "N",
                ),
            ),
            "DETAIL_TEXT_TYPE" => array(      // Тип детального описания
                "DEFAULT_VALUE" => "html",
            ),
            "SECTION_DESCRIPTION_TYPE" => array(
                "DEFAULT_VALUE" => "html",
            ),
            "LOG_SECTION_ADD" => array("IS_REQUIRED" => "Y"), // Журналирование
            "LOG_SECTION_EDIT" => array("IS_REQUIRED" => "Y"),
            "LOG_SECTION_DELETE" => array("IS_REQUIRED" => "Y"),
            "LOG_ELEMENT_ADD" => array("IS_REQUIRED" => "Y"),
            "LOG_ELEMENT_EDIT" => array("IS_REQUIRED" => "Y"),
            "LOG_ELEMENT_DELETE" => array("IS_REQUIRED" => "Y"),
        ),

        // Шаблоны страниц
        "LIST_PAGE_URL" => "#SITE_DIR#/schedule/",
        "SECTION_PAGE_URL" => "#SITE_DIR#/schedule/#SECTION_CODE#/",
        "DETAIL_PAGE_URL" => "#SITE_DIR#/schedule/#SECTION_CODE#/#ELEMENT_CODE#/",

        "INDEX_SECTION" => "Y", // Индексировать разделы для модуля поиска
        "INDEX_ELEMENT" => "Y", // Индексировать элементы для модуля поиска

        "VERSION" => 1, // Хранение элементов в общей таблице

        "ELEMENT_NAME" => "Экзамен",
        "ELEMENTS_NAME" => "Экзамен",
        "ELEMENT_ADD" => "Добавить экзамен",
        "ELEMENT_EDIT" => "Изменить экзамен",
        "ELEMENT_DELETE" => "Удалить экзамен",
        "SECTION_NAME" => "Категории",
        "SECTIONS_NAME" => "Категория",
        "SECTION_ADD" => "Добавить категорию",
        "SECTION_EDIT" => "Изменить категорию",
        "SECTION_DELETE" => "Удалить категорию",

        "SECTION_PROPERTY" => "Y",
    );

    $ID = $ib->Add($arFields);
    if ($ID > 0) {
        echo "&mdash; инфоблок \"Расписание эказменов\" успешно создан<br />";
    } else {
        echo "&mdash; ошибка создания инфоблока \"Расписание эказменов\"<br />";
        return false;
    }


    //=======================================//
    // Добавляем свойства к расписанию //
    //=======================================//

    // Определяем, есть ли у инфоблока свойства
    $dbProperties = CIBlockProperty::GetList(array(), array("IBLOCK_ID" => $ID));
    if ($dbProperties->SelectedRowsCount() <= 0) {
        $ibp = new CIBlockProperty;

        $arFields = array(
            "NAME" => "Аудитория",
            "ACTIVE" => "Y",
            "SORT" => 500,
            "CODE" => "AUDITORIUM",
            "PROPERTY_TYPE" => "N",
            "IBLOCK_ID" => $ID
        );
        $propId = $ibp->Add($arFields);
        if ($propId > 0) {
            $arFields["ID"] = $propId;
            $arCommonProps[$arFields["CODE"]] = $arFields;
            echo "&mdash; Добавлено свойство " . $arFields["NAME"] . "<br />";
        } else {
            echo "&mdash; Ошибка добавления свойства " . $arFields["NAME"] . "<br />";
        }


        $arFields = array(
            "NAME" => "Преподаватель",
            "ACTIVE" => "Y",
            "SORT" => 500,
            "CODE" => "TEACHER",
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID" => $ID,
        );
        $propId = $ibp->Add($arFields);
        if ($propId > 0) {
            $arFields["ID"] = $propId;
            $arCommonProps[$arFields["CODE"]] = $arFields;
            echo "&mdash; Добавлено свойство " . $arFields["NAME"] . "<br />";
        } else {
            echo "&mdash; Ошибка добавления свойства " . $arFields["NAME"] . "<br />";
        }
    } else {
        echo "&mdash; Для данного инфоблока уже существуют свойства<br />";
    }

    create_elements($ID);
    return $ID;
}

function create_elements($IBLOCK_ID)
{
    for ($i = 1; $i < 6; $i++) {
        $el = new CIBlockElement;

        $arLoadProductArray = array(
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $IBLOCK_ID,
            "CODE" => "subject_" . $i,
            "PROPERTY_VALUES" => [
                "AUDITORIUM" => $i,
                "TEACHER" => "Преподаватель " . $i
            ],
            "NAME" => "Предмет " . $i,
            "DATE_ACTIVE_FROM" => date('d.m.Y', strtotime("+" . $i . " days")),
            "ACTIVE" => "Y",
        );

        if ($SUBJECT_ID = $el->Add($arLoadProductArray)) {
            echo "ID предмета $i: " . $SUBJECT_ID . "<br>";
        } else {
            echo "Error: " . $el->LAST_ERROR . "<br>";
        }
    }
}

