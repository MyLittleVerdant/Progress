<?php
require 'vendor/autoload.php';
ini_set('display_erros', E_ALL);
error_reporting(E_ALL);

$kernel = new \TgRedmine\Kernel();
$kernel->test();