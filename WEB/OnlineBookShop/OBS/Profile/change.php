<?php

$host = 'localhost'; // адрес сервера 
$database = 'books_shop'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

$mysql=new mysqli($host, $user, $password, $database); 
$email=$_COOKIE['user'];


$res =$mysql->query("UPDATE `books_users` SET `Sname` = '{$_POST['sname']}',`Name` = '{$_POST['name']}',`Mname` = '{$_POST['mname']}',`Address` = '{$_POST['address']}' WHERE `Email`='$email'");

    echo json_encode("OK!");


$mysql->close();

?>