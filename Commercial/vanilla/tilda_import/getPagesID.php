<?php
header("Content-Type: text/html; charset=utf-8");

include "tilda-php/classes/Tilda/Api.php";
const TILDA_PUBLIC_KEY = 'tcjj4m05ml2lppfa1m4y';
const TILDA_SECRET_KEY = '9d00cd8d41aa25e60df9';
const TILDA_PROJECT_ID = '5773884';

$api = new Tilda\Api(TILDA_PUBLIC_KEY, TILDA_SECRET_KEY);
$arPages = $api->getPagesList(TILDA_PROJECT_ID);
echo "<pre>",var_dump($arPages),"</pre>";