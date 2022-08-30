<?php
if(isset($_COOKIE['user']))
{
    
    $host = 'localhost'; // адрес сервера 
    $database = 'books_shop'; // имя базы данных
    $user = 'root'; // имя пользователя
    $password = 'greenhood13'; // пароль

    $mysql=new mysqli($host, $user, $password, $database); 
   

    if(isset($_POST['Info']))
    {
        $get_books =$mysql->query("SELECT `UserID`,`Email`,`Address`, `Article`,products.Name,`Price` 
        FROM `books_users` 
        INNER JOIN `orders` ON books_users.UserID= orders.User 
        INNER JOIN `products` ON products.Article=orders.Book ");
        
        while ($row = $get_books->fetch_assoc())
        {
             $book_list[]=$row;   
        }
        
        echo json_encode($book_list);
    }
    
    
 

    $mysql->close();  
}


?>