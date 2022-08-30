<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/BookPage/book.css">
    
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
               
               <?php 
                if(!isset($_COOKIE['user'])):
                ?> 
                
                <button class="btn button_on_main" onclick="return_to_main()">
                   На главную
                </button>
           
                
                <?php else: if(!$_COOKIE['user']!='') ?>
                
                
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
           
              
               <?php endif; ?>
               
            </div>
            
        </div>
        
        <div class="info">
            
           <div class="preview">
               
           </div>  
                  
           <div class="description">
              
               <div class="title">
                   
               </div>
               
                    <div class="author">
                   
                    </div>

               <div class="text">
                   
               </div>
               
               <div class="price">
                   <div class="cost">
                       Цена: 
                   </div>
                   <div class="value">
                       
                   </div>
                   
                   <div class="btn_add">
                       <button class="btn button_add">
                    Добавить в корзину
                </button>
                   </div>
               </div>
           </div>     
            
        
        
        
        </div>
        
        <div class="footer_box">
            
            <div class="payment">
               
                <div class="payment_text">
                    We accept all major Credit Card/Debit Card/Internet Banking
                </div>
                   
                <div class="payment_icon">
                    <img src="/Assets/images/Master-card-blue.png" width="60" height="38" alt="">
                    <img src="/Assets/images/PayPal.png" width="60" height="38" alt="">
                    <img src="/Assets/images/visa_in_box.png" width="60" height="38" alt="">
                </div>     
                
            </div>
            
            <div class="notice">
                Conditions of Use Privacy Notice Interest-Based Ads © 1996-2013, Booksonline, Inc. or its affiliates
            </div>
            
        </div>

    </div>
        
       
   <script src="/Extensions/jquery-3.6.0.min.js"> </script>
    <script src="/BookPage/book.js">  </script>
       <script>
$(document).ready ( function(){
 Find();
});
</script>

</body>
</html>