<?php require $_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"; ?>
<?php
$APPLICATION->IncludeComponent(
    "verdant:exams.list",
    "",
    Array(
        "IBLOCK_ID" => "7"
    )
);
?>

<?php require $_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"; ?>