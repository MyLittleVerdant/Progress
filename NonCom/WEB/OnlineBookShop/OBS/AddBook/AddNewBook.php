<?php
if(isset($_COOKIE['user']))
{
    
    $host = 'localhost'; // адрес сервера 
    $database = 'books_shop'; // имя базы данных
    $user = 'root'; // имя пользователя
    $password = 'greenhood13'; // пароль

    $mysql=new mysqli($host, $user, $password, $database); 
   $errors=array();

    if(isset($_POST['Article'])&&isset($_POST['Name'])&&isset($_POST['Genre'])&&isset($_POST['Subgenre'])&&isset($_POST['Price'])&&isset($_POST['Cover'])&&isset($_POST['Paper'])&&isset($_POST['Author'])&&isset($_POST['Description']))
    {
        
        if(empty($_FILES['Image']['tmp_name']))
            $errors[]='Ошибка!';
        else
        {
            $image=addslashes(file_get_contents($_FILES['Image']['tmp_name']));
            $Article=$_POST['Article'];
            $Name=$_POST['Name'];
            $Genre=$_POST['Genre'];
            $Subgenre=$_POST['Subgenre'];
            $Price=$_POST['Price'];
            $Cover=$_POST['Cover'];
            $Paper=$_POST['Paper'];
            $Author=$_POST['Author'];
            $Description=$_POST['Description'];
            

            $mysql->query("INSERT INTO `products`(`Article`,`Name`,`Genre`,`Subgenre`,`Price`,`Cover`,`Paper`,`Author`,`Description`,`Image`) 
                          VALUES('$Article','$Name','$Genre', '$Subgenre','$Price','$Cover','$Paper','$Author','$Description','$image' )");
             
        }
            
    }
    else {
	    $errors[]='Введенные данные некорректны ';
    }


    if(empty($errors))
    {
      
        echo json_encode("OK!");
        
    }
    else
    {
        echo json_encode(array_shift($errors));
 
    } 


    $mysql->close();  
}


?>