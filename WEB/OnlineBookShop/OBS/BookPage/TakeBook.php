<?php

    
    $host = 'localhost'; // адрес сервера 
    $database = 'books_shop'; // имя базы данных
    $user = 'root'; // имя пользователя
    $password = 'greenhood13'; // пароль

    $mysql=new mysqli($host, $user, $password, $database); 
    //$email=$_COOKIE['user'];

    
    if(isset($_POST['Take']))
    {
        $temp = $_POST['Take'];
        $res =$mysql->query("SELECT `Article`,`Name`,`Price`,`Description`,`Image`,`Author` FROM `products` WHERE `Article`='$temp'");
        $row=$res->fetch_assoc();
        $img=base64_encode($row['Image']);
        $row['Image']=$img;
       
        echo json_encode($row); 
    }

    
    


    $mysql->close();  


?>