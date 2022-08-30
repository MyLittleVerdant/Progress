<?php
if(isset($_COOKIE['user']))
{
    
    $host = 'localhost'; // адрес сервера 
    $database = 'books_shop'; // имя базы данных
    $user = 'root'; // имя пользователя
    $password = 'greenhood13'; // пароль

    $mysql=new mysqli($host, $user, $password, $database); 
    $email=$_COOKIE['user'];
    
    $get_user =$mysql->query("SELECT `UserID` FROM `books_users` WHERE `Email`='$email'");
    $User=$get_user->fetch_assoc();

    $UserID=$User['UserID'];
   

    if(isset($_POST['Add']))
    {
           $Book=$_POST['Add'];
           if($UserID)
               $mysql->query("INSERT INTO `cart`(`User`,`Book`) VALUES('$UserID','$Book')");

             echo json_encode("OK!"); 
    }
    elseif(isset($_POST['Book']))
    {
        $get_books =$mysql->query("SELECT `Book` FROM `cart` WHERE `User`='$UserID'");
        

        while ($row = $get_books->fetch_assoc())
        {
             $book_list[]=$row['Book'];
             
        }
        
        $Products=array();
        
        foreach ($book_list as &$book) 
        {
            
           $res =$mysql->query("SELECT `Article`,`Name`,`Price`,`Image` FROM `products` WHERE `Article`='$book'");

           $row=$res->fetch_assoc();
           $img=base64_encode($row['Image']);
            $row['Image']=$img;
           $Products[]=$row;

        }
        
         echo json_encode($Products);         
    }
    if(isset($_POST['Del']))
    {
        $usless_book=$_POST['Del'];

        $del_res =$mysql->query("DELETE  FROM `cart`  WHERE `Book`='$usless_book' AND `User`='$UserID' ");

        echo json_encode("OK!"); 
    }
    

    $mysql->close();  
}


?>