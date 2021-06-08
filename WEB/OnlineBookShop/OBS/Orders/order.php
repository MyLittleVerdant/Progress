<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/Orders/order.css">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Redressed&display=swap" rel="stylesheet">
  
   <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
   
   <link rel="stylesheet" href=https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
    <!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="../Assets/images/favicon.ico">
   
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
        <div class="Cart">
            <div class="about">
                   <div class="about_text">
                       История покупок
                   </div>
                </div>
                
        <div class="CartProducts">
            
        </div>
        </div>
        



    </div>
        <script src="/Extensions/jquery-3.6.0.min.js"> </script>
       <script src="/Orders/order.js"> </script>
       
        <script>
            $(document).ready ( function(){
             GetShop();
            });
        </script>
</body>
</html>