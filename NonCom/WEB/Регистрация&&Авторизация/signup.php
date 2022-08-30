<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$host = 'localhost'; // адрес сервера 
$database = 'dsgn'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

  $mysql=new mysqli($host, $user, $password, $database) or die("Ошибка подключения".$mysql->connect_error);  

$errors=array();

$sname=trim($_POST['sname']);
$name=trim($_POST['name']);
$mname=trim($_POST['mname']);
$mail=trim($_POST['email']);
$login=trim($_POST['login']);
$pass=$_POST['password'];
if(empty($_FILES['image']['tmp_name']))
    $errors[]='Ошибка!';
else
$image=addslashes(file_get_contents($_FILES['image']['tmp_name']));

   //Проверка ввода
    

if($sname=='')
    {
        $errors[]='Введите фамилию!';
    }
if(mb_strlen($_POST['sname'])>30)
    {
        $errors[]='Недопустимая длина фамилии!';
    }


if($name=='')
    {
        $errors[]='Введите имя!';
    }
if(mb_strlen($_POST['name'])>30)
    {
        $errors[]='Недопустимая длина имени!';
    }


if(mb_strlen($_POST['mname'])>30)
    {
        $errors[]='Недопустимая длина отчества!';
    }


if($mail=='')
    {
        $errors[]='Введите email!';
    }
if(mb_strlen($_POST['email'])>50)
    {
        $errors[]='Недопустимая длина email!';
    }


if($login=='')
    {
        $errors[]='Введите логин!';
    }
if(mb_strlen($_POST['login'])>32)
    {
        $errors[]='Недопустимая длина логина!';
    }


if($pass=='')
    {
        $errors[]='Введите пароль!';
    }
if(mb_strlen($_POST['password'])>32)
    {
        $errors[]='Недопустимая длина пароля!';
    }

    
if($pass!=$_POST['password2'])
    {
        $errors[]='Повторный пароль введен не верно!';
    }

//проверка существующих значений
$res =$mysql->query("SELECT count(*) FROM `users` WHERE `Email`='$mail'");
$row = $res->fetch_row();
$total = $row[0];
$res->close();

if($total>0)
    {
        $errors[]='Данный email уже используется!';
    } 


$res =$mysql->query("SELECT count(*) FROM `users` WHERE `Login`='$login'");
$row = $res->fetch_row();
$total = $row[0];
$res->close();

if($total>0)
    {
        $errors[]='Данный логин уже используется!';
    } 



    if(empty($errors))
    {
        
        $hash=password_hash($pass,PASSWORD_DEFAULT);
        $mysql->query("INSERT INTO `users`(`Email`,`Login`,`PassHash`,`Sname`,`Name`,`Mname`,`Avatar`) VALUES('$mail','$login','$hash','$sname','$name','$mname','$image')");
        
        
        echo "OK";
        
    }
    else
    {
        echo array_shift($errors);
 
    } 

    


    
    




$mysql->close();

?>