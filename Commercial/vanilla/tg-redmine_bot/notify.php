<?php
require 'vendor/autoload.php';

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);
file_put_contents('./red.json', json_encode($data), FILE_APPEND);

if (!isset($data['event'])) {
  if (isset($data['object_kind'])) {
    switch ($data['object_kind']) {
      case 'push':
        $data['event'] = 'newCommit';
        break;
      case 'note':
        $data['event'] = 'newCommentGit';
        break;
    }
  }
}

$kernel = new \TgRedmine\Kernel();
$info = $kernel->notify($data);