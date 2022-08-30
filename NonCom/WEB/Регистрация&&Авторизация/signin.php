<?php

$host = 'localhost'; // адрес сервера 
$database = 'dsgn'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

  $mysql=new mysqli($host, $user, $password, $database);  



$login=$_POST['login'];
$pass=$_POST['password'];

   //Проверка ввода
    $errors=array();
$userArr=null;
if($login)
{
    //проверка существующих значений
$res =$mysql->query("SELECT `Login`,`PassHash` FROM `users` WHERE `Login`='$login' ");
if($res->num_rows==0)
{
    $errors[]='Пользователь с таким логином не найден!';
} else
    $userArr=$res->fetch_assoc();

}

if($login=='')
    {
        $errors[]='Введите логин!';
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
setcookie('user',$userArr['Login'],time()+3600,"/");
$array = array('OK',$userArr['Login']);
         
echo json_encode($array);
        
    }
    else
    {
        echo json_encode(array_shift($errors));
 
    } 
    


    
    




$mysql->close();

?>