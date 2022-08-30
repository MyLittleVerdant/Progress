<?php


$host = 'localhost';
$database = 'guestbook';
$user = 'root';
$password = 'greenhood13';

$mysql = new PDO("mysql:host=localhost;dbname=guestbook", $user, $password);


if (isset($_POST['Info'])) {
    $query = $mysql->prepare("SELECT `UserName`,`E-mail`,`Homepage`,`DateTime`, `Text`FROM `entry`");
    $query->execute();

    $get_entries = $query->fetchAll();

    echo json_encode($get_entries);
}
