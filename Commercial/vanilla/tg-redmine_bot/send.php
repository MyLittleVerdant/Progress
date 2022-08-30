<?php
require 'vendor/autoload.php';

$kernel = new \TgRedmine\Kernel();
$kernel->send($_GET['msg']);