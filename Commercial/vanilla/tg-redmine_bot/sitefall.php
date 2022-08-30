<?php
require 'vendor/autoload.php';

$kernel = new \TgRedmine\Kernel();
$info = $kernel->siteFallCheck();