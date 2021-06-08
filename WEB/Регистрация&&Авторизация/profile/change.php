<?php

$host = 'localhost'; // адрес сервера 
$database = 'dsgn'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

$mysql=new mysqli($host, $user, $password, $database); 
$login=$_COOKIE['user'];

//echo json_encode(file_get_contents($_FILES['avatar']['tmp_name']));
if(!empty($_FILES['avatar']['tmp_name']))
{
    $image=addslashes(file_get_contents($_FILES['avatar']['tmp_name']));
    $res =$mysql->query("UPDATE `users` SET `Sname` = '{$_POST['sname']}',`Name` = '{$_POST['name']}',`Mname` = '{$_POST['mname']}',`Email` = '{$_POST['email']}',`Login` = '{$_POST['login']}',`Avatar` = '$image' WHERE `Login`='$login'");
    
}
else
$res =$mysql->query("UPDATE `users` SET `Sname` = '{$_POST['sname']}',`Name` = '{$_POST['name']}',`Mname` = '{$_POST['mname']}',`Email` = '{$_POST['email']}',`Login` = '{$_POST['login']}' WHERE `Login`='$login'");

    echo json_encode("OK!");


$mysql->close();

?>