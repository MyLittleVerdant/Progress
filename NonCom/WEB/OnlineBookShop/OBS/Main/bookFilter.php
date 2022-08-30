<?php

$host = 'localhost'; // адрес сервера 
$database = 'books_shop'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

$mysql=new mysqli($host, $user, $password, $database); 

$errors=array();
$userArr=array();

if(isset($_POST['price']))
    $condition1=$mysql->real_escape_string($_POST['price']);
else
    $condition1="";

if(isset($_POST['cover']))
    $condition2=$mysql->real_escape_string($_POST['cover']);
else
    $condition2="";

if(isset($_POST['paper']))
    $condition3=$mysql->real_escape_string($_POST['paper']);
else
    $condition3="";


if($_POST['Radio'])
{
     
    if($_POST['Radio']=='recommendations')
    {
            $search = "SELECT * FROM `products` WHERE `Article`%4=0 " .
        (empty($condition2) ? "" : "AND `Cover`='{$_POST['cover']}' ") .
        (empty($condition3) ? "" : "AND `Paper`='{$_POST['paper']}' ").
        (empty($condition1) ? "" :(($condition1=="up") ? "ORDER BY `Price`":"ORDER BY `Price` DESC")); 
        
         
    }
     
    else
    {
          $search = "SELECT * FROM `products` WHERE `Genre`='{$_POST['Radio']}' " .
        (empty($condition2) ? "" : "AND `Cover`='{$_POST['cover']}' ") .
        (empty($condition3) ? "" : "AND `Paper`='{$_POST['paper']}' ").
        (empty($condition1) ? "" :(($condition1=="up") ? "ORDER BY `Price`":"ORDER BY `Price` DESC"));   
    }
    
    $res =$mysql->query($search);

}
else
    $errors[]='Не выбрана категория!';

    if(empty($errors))
    {
       if(empty($res->error))
    {
        
        while($row=$res->fetch_assoc())
        {
           $img=base64_encode($row['Image']);
            $row['Image']=$img;
           $userArr[]= $row; 
            
        }
         echo json_encode($userArr);      
    }
    else
        echo json_encode($res->error); 
    }
    

      
       
   




$mysql->close();

?>