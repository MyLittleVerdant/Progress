<?php
/**
 * @global $APPLICATION
 */
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");

use Bitrix\Main\Application,
    PhpOffice\PhpSpreadsheet\IOFactory;


$APPLICATION->SetTitle("Импорт продуктов");
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
    $newName = "Producty_".time() . "." . $ext;
    $res = move_uploaded_file($_FILES['file']['tmp_name'],
        Application::getDocumentRoot() . "/upload/owl.import/" . $newName);

    $inputFileName = Application::getDocumentRoot() . "/upload/owl.import/" . $newName;
    $inputFileType = IOFactory::identify($inputFileName);
    $reader = IOFactory::createReader($inputFileType);
    $reader->setReadDataOnly(true);
    $reader->setReadEmptyCells(false);
    $spreadsheet = $reader->load($inputFileName);
    foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
        $worksheets[] = $worksheet->toArray();
    }

    /**
     * Данные (св-ва)
     */
    $array = $worksheets[0];

    $errors = [];

    /**
     * Названия св-в
     */
    $humanHeaders = array_shift($array);
    $machineHeaders = array_shift($array);

    /**
     * Валидация данных документа
     */
    $skipValidation = ["ID товара", "Символьный код"];
    for ($i = 0; $i < count($array); $i++) {
        for ($j = 0; $j < count($array[$i]); $j++) {
            if (empty($array[$i][$j]) && !in_array($humanHeaders[$j], $skipValidation)) {
                $errors[$i][] = "Поле \"" . $humanHeaders[$j] . "\" пустое";
            }
        }
    }

    if (count($array) === 0) {
        die('Пустой файл');
    }
    $arResult = array_map(fn($row) => array_combine($machineHeaders, $row), $array);
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
<? if (isset($arResult)): ?>
    <div class="container">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="background: white;top: 52px;" class="sticky-top">Название товара</th>
                <? if (!empty($errors)): ?>
                    <th style="background: white;top: 52px;" class="sticky-top">Валидация</th>
                    <th style="background: white;top: 52px; width:30px" class="sticky-top plus-head"></th>
                <? endif; ?>

                <th style="background: white;top: 52px;" class="sticky-top">Результат</th>
            </tr>
            </thead>
            <tbody class="products">
            <?php
            foreach ($arResult as $key => $arElement):
                ?>
                <tr scope="row" id="<?= $key ?>">
                    <td class="element">[<?= $key ?>] <?= $arElement['NAME'] ?></td>
                    <? if (!empty($errors)): ?>
                        <td class="validation closed" style="word-wrap:break-word;"><?= $errors[$key][0] ?></td>
                        <td class="disclosure"><i class="fas fa-plus-circle"></i></td>
                    <? endif; ?>

                    <td class="result"></td>
                </tr>
            <?php
            endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        let elements = <?=json_encode($arResult)?>,
            counter = 0,
            total = <?=count($arResult)?>;

        function optimizeImage() {
            if (typeof elements[counter] != "undefined") {
                let element = elements[counter],
                    percent = (counter / elements.length) * 100;
                $.ajax({
                    url: '/local/modules/owl.import/lib/importProducts/apply.php',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        'element': element
                    },
                    success: json => {
                        if (typeof json['success'] != "undefined") {
                            $('#' + counter).find('.result').text("Готово: " + json['type']);
                        } else {
                            $('#' + counter).find('.result').text("Ошибка");
                        }
                        counter++;
                        document.title = Math.ceil(percent) + "% импортировано";
                        optimizeImage();
                    }
                });
            } else {
                document.title = "Готово";
            }
            return false;
        }


        $('#start').click((event) => {
            optimizeImage();
        });

        function implode(glue, pieces) {
            return ((pieces instanceof Array) ? pieces.join(glue) : pieces);
        }

        var errors = <?=json_encode($errors, JSON_UNESCAPED_UNICODE)?>;

        /**
         * Обработка нажатия на кнопку раскрытия/закрытия ошибок валидации
         */
        $('.disclosure').click(function () {
            var descr = $(this).closest('tr').find('.validation');
            var sign = $(this).find('.fas');
            var index = $(this).closest('tr').attr("id");

            if ($(descr).hasClass("closed")) {
                $(descr).removeClass('closed');
                $(descr).addClass('opened');

                $(sign).removeClass('fa-plus-circle');
                $(sign).addClass('fa-minus-circle');

                $(descr).html(implode("<br>", errors[index]))
            } else {
                $(descr).removeClass('opened');
                $(descr).addClass('closed');

                $(sign).removeClass('fa-minus-circle');
                $(sign).addClass('fa-plus-circle');

                $(descr).html(errors[index][0])
            }

        })

    </script>
<? endif; ?>

<? require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");