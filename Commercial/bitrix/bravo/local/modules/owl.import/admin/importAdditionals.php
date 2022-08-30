<?php
/**
 * @global $APPLICATION
 */
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

use Bitrix\Main\Application,
    PhpOffice\PhpSpreadsheet\IOFactory;


$APPLICATION->SetTitle("Импорт комплектов");
CModule::IncludeModule('iblock');
?>
    <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/5e38591a3b.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    <style>
        .products tr {
            transition: background-color .3s;
        }

        .products tr:hover {
            background-color: rgba(255, 82, 0, 0.3);
        }

    </style>
<?php
/**
 * Массив допустимых расширений
 */
$allowedExt = [
    "xls",
    "xlsx"
];
/**
 * Валидация файла
 */
$isUploaded = $_FILES['file']['error'] == UPLOAD_ERR_OK
    && is_uploaded_file($_FILES['file']['tmp_name']);
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$showErr = false;

if ($isUploaded === true && in_array($ext, $allowedExt)) {
    /**
     * Сохранение и чтение файла
     */
    $showErr = false;
    @mkdir(Application::getDocumentRoot() . "/upload/owl.import", 0777);
    $newName = "Komplecty_".time() . "." . $ext;
    $res = move_uploaded_file($_FILES['file']['tmp_name'],
        Application::getDocumentRoot() . "/upload/owl.import/" . $newName);

    $inputFileName = Application::getDocumentRoot() . "/upload/owl.import/" . $newName;
    $inputFileType = IOFactory::identify($inputFileName);
    $reader = IOFactory::createReader($inputFileType);
    $reader->setReadDataOnly(true);
    $reader->setReadEmptyCells(false);
    $spreadsheet = $reader->load($inputFileName);

    $sheets = $spreadsheet->getSheetNames();
    $sheetNames = [
        "Вероника",
        "Елена",
        "Грация",
        "Камила",
        "Жасмин",
        "Камелия",
        "Карина",
        "Клеопатра",
        "Натали",
        "Детские кровати из массива"
    ];
    $arProducts = [];
    $errors = [];
    foreach ($sheetNames as $sheetName) {

        $activeSheet = $spreadsheet->getSheetByName($sheetName);

        $rows = [];
        foreach ($activeSheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $key => $cell) {
                $cellValue = $cell->getValue();
                $cells[] = trim($cellValue);
            }
            $rows[] = $cells;
        }

        $keys = array_shift($rows);
        $rows = array_map(function ($v) use ($keys) {
            return array_combine($keys, $v);
        }, $rows);

        $groupId = null;
        $first = true;
        foreach ($rows as $key => $row) {
            // Фильтруем пустые и невалидные строки

            preg_match_all('/\b[А-Я]+\b/', $row["Наименование10"], $matches, PREG_SET_ORDER);

            if ((!$row["Ид9"] || !$row["Наименование10"]) && (!$row['ВерсияСхемы'] && $row["Наименование10"] != "Можем комплектовать двусторонним матрасом")) {
                continue;
            }

            // Находим начало комплекта
            $isPrevEmpty = ($rows[$key - 1]["Наименование8"] == ""
                    && $rows[$key - 1]["Наименование10"] != "Можем комплектовать двусторонним матрасом")
                || $first === true;
            $first = false;

            // Товар, к которому относится комплект
            if ($isPrevEmpty) {
                $groupId = $key;
                $arProducts[$sheetName][$groupId][] = [
                    'type' => 'product',
                    'XML_ID' => $row["Ид9"],
                    'NAME' => $row["Наименование10"],
                ];
                // Товар найден, дальше уже не интересно. Пропускаем строку
                continue;
            }

            //# Устанавливаем тип коплектующего. Это будет селект, чекбокс или попап
            $type = ($row['Наименование10'] != "Можем комплектовать двусторонним матрасом")
                ? "addon"
                : "mattress";

            if (stripos($row['Наименование10'], "ДОП ОПЦИЯ")) {
                $type = "checkbox";
            }

            // Если это товар, то ставим ему XML_ID, иначе ставим метку, что это матрас.
            $xmlId = ($type !== "mattress")
                ? $row["Ид9"]
                : 'mattress';

            $sheetName = $sheetName === "Детские кровати из массива" ? "Детские_кровати_из_массива" : $sheetName;
            $arProducts[$sheetName][$groupId][] = [
                'type' => $type,
                'XML_ID' => $xmlId,
                'NAME' => $row["Наименование10"],
            ];

        }

    }

    /**
     * Переиндексация масссива
     */
    foreach ($arProducts as $sheetKey => $sheet) {
        $arProducts[$sheetKey] = array_values($sheet);
    }
    /**
     * Валидация данных файла
     */
    foreach ($arProducts as $sheet => $elements) {
        foreach ($elements as $index => $products) {
            foreach ($products as $key => $instance) {
                if (!$instance["XML_ID"] && $instance['NAME'] !== "Можем комплектовать двусторонним матрасом") {
                    $errors[$sheet][$index][$key] = "Поле \"Ид9\" пустое";
                }

                if (!$instance["NAME"]) {
                    $errors[$sheet][$index][$key] = "Поле \"Наименование10\" пустое";
                }
            }
        }
    }

} else {
    $isUploaded = false;
    $showErr = true;
}

?>
<? if (!empty($_FILES) && $showErr): ?>
    <span>Неверный формат файла</span>
<? endif; ?>

<?php
if ($isUploaded === false):?>
    <form action="" method="post" enctype="multipart/form-data" class="row">
        <label class="form-label col">
            <span>Импортировать каталог</span>
            <input type="file" name="file" id="excel-import">
        </label>
        <div class="btn-group flex-column" role="group">
            <button type="submit" class="btn btn-primary" name="make-preview" value="start">Загрузить</button>
        </div>
    </form>
<? else: ?>
    <form action="" method="post" enctype="multipart/form-data" class="row">
        <div class="btn-group flex-column" role="group" id="start">
            <button type="button" class="btn btn-primary" name="make-preview" value="start">Импортировать</button>
        </div>
    </form>
<?php
endif ?>
<? if (isset($arProducts)): ?>

    <div class="container">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="background: white;top: 52px;" class="sticky-top">Модель</th>
                <th style="background: white;top: 52px;" class="sticky-top">Товар</th>
                <? if (!empty($errors)): ?>
                    <th style="background: white;top: 52px;" class="sticky-top">Валидация</th>
                <? endif; ?>

                <th style="background: white;top: 52px;" class="sticky-top">Результат</th>
            </tr>
            </thead>
            <tbody class="products">
            <? foreach ($arProducts as $sheet => $elements): ?>
                <tr scope="row">
                    <td class="element"><?= $sheet ?></td>
                </tr>
                <? foreach ($elements as $index => $products):
                    foreach ($products as $key => $instance): ?>
                        <tr scope="row" class="<?= $sheet ?> <?= $index ?> ">
                            <td class="element"></td>
                            <td class="element"><?= $instance['NAME'] ?></td>
                            <? if (!empty($errors)): ?>
                                <td class="validation"
                                    style="word-wrap:break-word;"><?= $errors[$sheet][$index][$key] ?></td>
                            <? endif; ?>
                            <td class="result" style="word-wrap:break-word;"></td>
                        </tr>
                    <?endforeach;
                endforeach;
            endforeach; ?>
            </tbody>
        </table>
    </div>
<? endif; ?>
    <script>
        let book = <?=json_encode($arProducts)?>,
            globalCounter = 0,
            length = 0,
            currentSheet = "";

        /**
         * Вычисление кол-ва элементов в документе
         */
        for (var sheet in book) {
            for (var group in book[sheet]) {
                length += book[sheet][group].length;
            }
        }

        /**
         * Перебор всех листов документа
         */
        function throughSheets() {
            for (var sheet in book) {
                currentSheet = sheet;
                for (var group in book[sheet]) {
                    addAdditionals(book[sheet][group], group);
                }

            }
        }

        /**
         * Добавление группы в ИБ
         * @param group полный комплект
         * @param num ID для связи с таблицей валидации
         * @returns {boolean}
         */
        function addAdditionals(group, num) {
            $.ajax({
                async: false,
                url: '/local/modules/owl.import/lib/importAdditionals/apply.php',
                method: 'post',
                dataType: 'json',
                data: {
                    'group': group,
                    'num': num
                },
                success: json => {
                    $('.' + currentSheet + '.' + json['num']).find('.result').text(json['description']);
                    globalCounter += group.length;
                    let percent = (globalCounter / length) * 100;
                    if (percent === 100)
                        document.title = "Готово";
                    else
                        document.title = Math.ceil(percent) + "% импортировано";
                }
            });
            return false;

        }

        $('#start').click((event) => {
            throughSheets();
        });

    </script>
<? require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
