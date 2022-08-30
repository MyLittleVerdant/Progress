<?php
require 'vendor/autoload.php';

$kernel = new \TgRedmine\Kernel();
$result = $kernel->tasksLifetime();

header('Content-type: application/json');
echo json_encode(['result' => $result]);