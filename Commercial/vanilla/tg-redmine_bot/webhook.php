<?php
require 'vendor/autoload.php';

$kernel = new \TgRedmine\Kernel();
$info = $kernel->getWebhookInfo();
print_r($info);
