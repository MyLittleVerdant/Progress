<?php
require 'vendor/autoload.php';
$kernel = new \TgRedmine\Kernel();
$kernel->report($_GET['type'], isset($_GET['observer']));