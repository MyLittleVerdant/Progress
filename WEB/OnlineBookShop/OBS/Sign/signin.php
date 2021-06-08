<?php

$host = 'localhost'; // адрес сервера 
$database = 'books_shop'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

  $mysql=new mysqli($host, $user, $password, $database);  



$mail=$_POST['email'];
$pass=$_POST['password'];

   //Проверка ввода
$errors=array();
$userArr=array();
if($mail)
{
    //проверка существующих значений
$res =$mysql->query("SELECT `Email`,`PassHash`,`Status` FROM `books_users` WHERE `Email`='$mail' ");
if($res->num_rows==0)
{
    $errors[]='Пользователь с таким email не найден!';
} else
    $userArr=$res->fetch_assoc();

}

if($mail=='')
    {
        $errors[]='Введите email!';
    }
if($pass=='')
    {
        $errors[]='Введите пароль!';
    }
 
if($userArr)
{
    if(!password_verify($pass,$userArr['PassHash']))
        $errors[]= 'Неверный пароль';
}
        

if(empty($errors))
    {
        //авторизация
setcookie('user',$userArr['Email'],time()+3600,"/");
setcookie('status',$userArr['Status'],time()+3600,"/");

$array = array('OK',$userArr['Email']);
         
echo json_encode($array);
        
    }
    else
    {
        echo json_encode(array_shift($errors));
 
    } 
    

$mysql->close();

?>