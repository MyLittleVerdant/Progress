<?php
/**
 * @global $APPLICATION
 */
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

use Bitrix\Main\Application,
    PhpOffice\PhpSpreadsheet\IOFactory;


$APPLICATION->SetTitle("Импорт комплектующих");
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
    $newName = "Koplectuyshie_".time() . "." . $ext;
    $res = move_uploaded_file($_FILES['file']['tmp_name'],
        Application::getDocumentRoot() . "/upload/owl.import/" . $newName);

    $inputFileName = Application::getDocumentRoot() . "/upload/owl.import/" . $newName;
    $inputFileType = IOFactory::identify($inputFileName);
    $reader = IOFactory::createReader($inputFileType);
    $reader->setReadDataOnly(true);
    $reader->setReadEmptyCells(false);
    $spreadsheet = $reader->load($inputFileName);

    $sheets = $spreadsheet->getSheetNames();
    $sheetName = "Комплектующие для кроватей под ";
    $activeSheet = $spreadsheet->getSheetByName($sheetName);

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

    if (count($rows) === 0) {
        die('Пустая страница');
    }

    $errors = [];
    $arrCheck = [];
    foreach ($rows as $index => $row) {
        if (!$row["Ид9"] && !$row["Наименование10"]) {
            continue;
        }
        if (!$row["Ид9"]) {
            $errors[$index] = "Поле \"Ид9\" пустое";
        }

        if (!$row["Наименование10"]) {
            $errors[$index] = "Поле \"Наименование10\" пустое";
        }

        $arrCheck[$index]['NAME'] = $row["Наименование10"];
        $arrCheck[$index]['ID'] = $row["Ид9"];
        $arrCheck[$index]['NUM'] = $index;

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
<? if (isset($arrCheck)): ?>

    <div class="container">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="background: white;top: 52px;" class="sticky-top">Товар</th>
                <? if (!empty($errors)): ?>
                    <th style="background: white;top: 52px;" class="sticky-top">Валидация</th>
                <? endif; ?>

                <th style="background: white;top: 52px;" class="sticky-top">Результат</th>
            </tr>
            </thead>
            <tbody class="products">
            <? foreach ($arrCheck as $key => $arElement): ?>
                <tr scope="row" id="<?= $key ?>">
                    <td class="element"><?= $arElement['NAME']?:$arElement["ID"] ?></td>
                    <? if (!empty($errors)): ?>
                        <td class="validation" style="word-wrap:break-word;"><?= $errors[$key] ?></td>
                    <? endif; ?>
                    <td class="result" style="word-wrap:break-word;"></td>
                </tr>
            <?php
            endforeach; ?>
            </tbody>
        </table>
    </div>
<? endif; ?>
    <script>
        let elements = <?=json_encode($arrCheck)?>,
            counter = 0,
            length = Object.keys(elements).length;

        function addComplects() {
            for (var index in elements) {
                $.ajax({
                    url: '/local/modules/owl.import/lib/importComplects/apply.php',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        'element': elements[index]
                    },
                    success: json => {
                        $('#' + json['num']).find('.result').text(json['description']);
                        counter++;
                        let percent = (counter / length) * 100;
                        if (percent === 100)
                            document.title = "Готово";
                        else
                            document.title = Math.ceil(percent) + "% импортировано";
                    }
                });
            }

            return false;
        }

        $('#start').click((event) => {
            addComplects();
        });

    </script>
<? require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
