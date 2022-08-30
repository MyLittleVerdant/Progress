<?php
$host = 'localhost'; // адрес сервера 
$database = 'books_shop'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

$mysql=new mysqli($host, $user, $password, $database); 

$mail=$_COOKIE['user'];
$res =$mysql->query("SELECT * FROM `books_users` WHERE `Email`='$mail' ");
$userArr=$res->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="profile.css">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Redressed&display=swap" rel="stylesheet">
  
   <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  
   <link rel="stylesheet" href=https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
   
    <title>Books</title>
</head>
<body>
    <div class="main_box">
      
       <div class="header">
           
            <div class="icon_box">
                <img src="/Assets/images/Logo.jpg" alt="">
            </div>
            
            <div class="autograph">
              <div class="autograph_text">
                Made by Verdant
              </div>
               
                
            </div>
            
            <div class="btn_box">
                 <button class="btn button_profile" onclick="profile_click()">
                        <i class="fa fa-user"></i>
                        
                         <?php if($_COOKIE['status']=='0'): ?>
                        <div class="drop_menu">
                            <a href="/Profile/account.php">Профиль</a>
                            <a href="/Cart/basket.php">Корзина</a>
                            <a href="/Orders/order.php">Покупки</a>
                        </div>
                        <?php else: ?>
                         <div class="drop_menu">
                            <a href="/Profile/account.php">Профиль</a>
                            <a href="/Cart/basket.php">Корзина</a>
                            <a href="/Orders/order.php">Покупки</a>
                            <a href="/Orders List/ordersLIST.php">Заказы</a>
                            <a href="/AddBook/NewBook.php">Новый товар</a>
                        </div>
                        <?php endif ?>
                
                    </button>
            
                <button class="btn button_on_main" onclick="return_to_main()">
                   На главную
                </button>
            </div>
            
        </div>
        
        <div class="profile_info">
              
         <form name="profile_form">
            <div class="profile">

                <div class="block">
                   <label for="sname">Фамилия</label>
                    <p><input type="text" class="sname" name="sname" value="<?php echo $userArr['Sname']; ?>"></p>
                </div>

                 
                       
                <div class="block">
                    <p >Имя</p>
                        <p><input type="text"  name="name" value="<?php echo $userArr['Name']; ?>"></p>
                </div>
                 
                <div class="block">
                    <p >Отчество</p>
                    <p><input type="text"  name="mname" value="<?php echo $userArr['Mname']; ?>"></p>
                </div>
                 
        

                <div class="block">
                  <p >Электронная почта</p>
                  <p><input type="text"  name="email" value="<?php echo $userArr['Email']; ?>" readonly></p>
                </div>
                
                <div class="block">
                  <p >Адрес</p>
                  <p><input type="text"  name="address" value="<?php echo $userArr['Address']; ?>" ></p>
                </div>
                 
  
    </div>
    <p><input type="submit" name="button_change" value="Сохранить"></p>
    </form>
            
        </div>
        


    </div>
    <script src="/Extensions/jquery-3.6.0.min.js"> </script>
    <script src="./sub.js"></script>
    
</body>
</html>

<?php
    


$mysql->close();

?>
