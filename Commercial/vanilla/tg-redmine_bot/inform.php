<?php
require 'vendor/autoload.php';
if (!empty($_REQUEST)) {
    $data = array_merge($_REQUEST, $_FILES);
    $data['user'] = explode(";", $data['user']);
} else {
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);
}
$kernel = new \TgRedmine\Kernel();
$result = $kernel->inform($data);

header('Content-type: application/json');
echo json_encode($result);