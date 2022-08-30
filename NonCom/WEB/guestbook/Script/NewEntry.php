<?php


$host = 'localhost'; // адрес сервера
$database = 'guestbook'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

$mysql = new PDO("mysql:host=localhost;dbname=guestbook", $user, $password);

$client = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote = @$_SERVER['REMOTE_ADDR'];


$Browser = $_SERVER["HTTP_USER_AGENT"];

$datetime = getdate();
$datetime = $datetime['mday'] . "/" . $datetime['mon'] . "/" . $datetime['year'] .
            "  " . $datetime['hours'] . ":" . $datetime['minutes'] . ":" . $datetime['seconds'];


if (filter_var($client, FILTER_VALIDATE_IP)) {
    $IP = $client;
} elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
    $IP = $forward;
} else {
    $IP = $remote;
}

$UsrName = htmlspecialchars($_POST['UsrNm']);
$Email = htmlspecialchars($_POST['Email']);
$HPage = htmlspecialchars($_POST['HP']);
$Msg = htmlspecialchars($_POST['MSG']);

$params = ['UsrName' => $UsrName, 'Email' => $Email, 'HPage' => $HPage, 'Msg' => $Msg];


$query = $mysql->prepare(
    "INSERT INTO `entry`(`UserName`,`E-mail`,`Homepage`,`Text`,`IP`,`BrowInfo`,`DateTime`) 
            VALUES(:UsrName,:Email,:HPage,:Msg,'$IP','$Browser','$datetime' )"
);

$query->execute($params);

echo json_encode($query->errorInfo());
