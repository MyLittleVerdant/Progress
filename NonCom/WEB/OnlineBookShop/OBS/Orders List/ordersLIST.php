<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/Orders List/ordersLIST.css">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Redressed&display=swap" rel="stylesheet">
  
   <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

   <link rel="stylesheet" href=https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
   <link href="/Extensions/jquery.dataTables.min.css" rel="stylesheet">

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


                        <div class="drop_menu">
                            <a href="/Profile/account.php">Профиль</a>
                            <a href="/Cart/basket.php">Корзина</a>
                            <a href="/Orders/order.php">Покупки</a>
                           <a href="/Orders List/ordersLIST.php">Заказы</a>
                           <a href="/AddBook/NewBook.php">Новый товар</a>
                        </div>
                
                    </button>
                
            
                <button class="btn button_on_main" onclick="return_to_main()">
                   На главную
                </button>
            </div>
            
        </div>
        <div class="Cart">
            <div class="about">
                   <div class="about_text">
                       Все заказы
                   </div>
                </div>
                
        <div class="AllOrdersTable">
             <table class="table table-hover cell-border  table-bordered " id="AllOrdersTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">UserID</th>
                            <th scope="col">Email</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Артикль</th>
                            <th scope="col">Название</th>
                            <th scope="col">Цена</th>
                        </tr>
                    </thead>
                    <tbody id="AllOrdersTable-body">
                       
                    </tbody>
                </table>
        </div>
        </div>
        



    </div>
    <script src="/Extensions/jquery-3.6.0.min.js"> </script>
     <script src="/Extensions/jquery.dataTables.min.js"></script>
       <script src="/Orders List/ordersLIST.js"> </script>

        <script>
            $(document).ready ( function(){
             GetAllOrders();
            });
        </script>
</body>
</html>