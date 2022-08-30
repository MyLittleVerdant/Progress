<?php

if($_POST['UserCode']==$_POST['code'])
{
    $host = 'localhost'; // адрес сервера 
$database = 'dsgn'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

$mysql=new mysqli($host, $user, $password, $database);  

$pass=password_hash($_POST['pass'],PASSWORD_DEFAULT);
$res =$mysql->query("UPDATE `users` SET `PassHash` = '$pass' WHERE `Login`='{$_POST['login']}'");
if(empty($res->error))
    echo json_encode("OK!");
else
echo json_encode($res->error);

$mysql->close();
}
else
    echo json_encode("Неверный код!");

?>