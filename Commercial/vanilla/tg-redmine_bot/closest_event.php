<?php
require 'vendor/autoload.php';

$kernel = new \TgRedmine\Kernel();
$result = $kernel->closestEvent();

echo json_encode(['result' => $result]);