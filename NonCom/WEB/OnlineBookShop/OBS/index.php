<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/Main/main.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Redressed&display=swap" rel="stylesheet">
     <link rel="stylesheet" href=https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
   
   <!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="Assets/images/favicon.ico">
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
                
                
                <button class="btn button_sign_in" onclick="signin_click()">
                    Войти
                </button>
            
                <button class="btn button_sign_up" onclick="signup_click()">
                   Регистрация
                </button>
                
                <?php else: if(!$_COOKIE['user']!='') ?>
                
                
                    <button class="btn button_profile" onclick="profile_click()">
                        <i class="fa fa-user"></i>

                         <?php if($_COOKIE['status']=='0'): ?>
                        <div class="drop_menu">
                            <a href="Profile/account.php">Профиль</a>
                            <a href="Cart/basket.php">Корзина</a>
                            <a href="Orders/order.php">Покупки</a>
                        </div>
                        <?php else: ?>
                         <div class="drop_menu">
                            <a href="Profile/account.php">Профиль</a>
                            <a href="Cart/basket.php">Корзина</a>
                            <a href="Orders/order.php">Покупки</a>
                            <a href="Orders List/ordersLIST.php">Заказы</a>
                            <a href="/AddBook/NewBook.php">Новый товар</a>
                        </div>
                        <?php endif ?>
                
                    </button>
                
        
                <button class="btn button_exit" onclick="exit_click()" >
                   Выйти
                </button>
           
              
               <?php endif; ?>
               
            </div>
            
            
             <div id="sign_up" class="modal">
         <div class="errors Uperrors"></div>
         <div class="modal_sign_up">
            
             <span class="close">&times;</span>
             <form name="signup_form" >
        
                <p>Фамилия</p>
                 <p><input type="text"  name="sname"></p>
                 <p>Имя</p>
                 <p><input type="text"  name="name"></p>
                 <p>Отчество</p>
                 <p><input type="text" name="mname"></p>
                 <p>Адрес</p>
                 <p><input type="text"  name="address"></p>
                 <p>Email</p>
                 <p><input type="email"  name="email"></p>
                 <p>Пароль</p>
                 <p><input type="password"  name="password"></p>
                 <p>Введите пароль еще раз</p>
                 <p><input type="password"  name="password2"></p>
                 <p><input type="submit" name="do_signup" value="Регистрация"></p>
                 
             </form>
             
             
         </div>
         </div>
         
              <div id="sign_in" class="modal">
              <div class="errors Inerrors"></div>
         <div class="modal_sign_in">
            
             <span class="close">&times;</span>
             <form name="signin_form">
                
                 <p>Email</p>
                 <p><input type="email"  name="email"></p>
                 <p>Пароль</p>
                 <p><input type="password" name="password"></p>
                 <p><input type="submit" value="Вход"></p>
                 <button class="recover" onclick="window.location.href = 'change_pass/ChangePassword.php'">Забыли пароль?</button>
             </form>
                
         </div>
         </div>
            
            
            
            
        </div>
        
        <div class="working_space">
            
             <div class="category_box">
              
                  <form action="" name="subfilter">
                  
                   <p class="recommendations"><input name="Radio" type="radio" value="recommendations" checked="checked" >Рекомендации</p>
                  <div class="block recommendations" style="display:none">
                  </div>
                  
                  
                   <p class="education"><input name="Radio" type="radio" value="education">Учебная лит-ра</p>
                   
                   <div class="block education" style="display:none">
                    <label><input type="checkbox"  name="education" value="HEI" onclick="check()"> Подготовка в ВУЗ</label><br>
                    <label><input type="checkbox" name="education" value="school" onclick="check()"> Книги для школы</label><br>
                    <label><input type="checkbox" name="education" value="vocab" onclick="check()"> Словари и разговорники</label><br> 
                  </div>
                   
                
                   
                    <p class="nerd"><input name="Radio" type="radio" value="nerd">Комиксы,манга,артбуки</p>
                    
                    <div class="block nerd" style="display:none">
                    <label><input type="checkbox"  name="nerd" value="comics" onclick="check()">Комиксы </label><br>
                    <label><input type="checkbox" name="nerd" value="manga"onclick="check()">Манга </label><br>
                    <label><input type="checkbox" name="nerd" value="art" onclick="check()">Артбуки</label><br> 
                  </div>
                  
                
                   
                    <p class="non_fiction"><input name="Radio" type="radio" value="non_fiction">Нехудожественная литература</p>
                    
                    <div class="block non_fiction" style="display:none">
                    <label><input type="checkbox"  name="non_fiction" value="cook" onclick="check()"> Кулинария</label><br>
                    <label><input type="checkbox" name="non_fiction" value="psy" onclick="check()"> Психология</label><br>
                    <label><input type="checkbox" name="non_fiction" value="business" onclick="check()"> Бизнес. Экономика</label><br> 
                  </div>
                  
                
                  
                   <p class="fiction"><input name="Radio" type="radio" value="fiction">Художественная литература</p> 
                   
                   <div class="block fiction" style="display:none">
                    <label><input type="checkbox"  name="fiction" value="detective" onclick="check()"> Детективы</label><br>
                    <label><input type="checkbox" name="fiction" value="fantasy" onclick="check()"> Фантастика</label><br>
                    <label><input type="checkbox" name="fiction" value="adventure" onclick="check()"> Приключения</label><br> 
                  </div>
                  
                  
                  <div class="subfilter">
                      
                      <p>Сортировать цену в порядке</p>
                    <select id="price" name="price">
                      <option value="up">Возрастания</option>
                      <option value="down">Убывания</option>
                      <option value="" selected>Не сортировать</option>
                    </select>
                    
      
                     
                      <p>Обложка:</p>
                    <select id="cover" name="cover">
                      <option value="hard">Твердая</option>
                      <option value="soft">Мягкая</option>
                      <option value="" selected >Любая</option>
                    </select>
                    
                  
                     
                      <p>Бумага:</p>
                    <select id="paper" name="paper">
                      
                      <option value="mel">Мелованная</option>
                      <option value="of">Офсет</option>
                      <option value="gz">Газетная</option>
                      <option value="" selected >Любая</option>
                    </select>
                    
                  
                  <p><input type="submit" value="Применить"></p>
                  
                  
                  <br>
                  </div>
                  </form>
                  
            </div>
        
           
           
           
            <div class="products_box">
               
                <div class="about">
                   <div class="about_text">
                       Рекомендации
                   </div>
                </div>
                
                <div class="sorted">
                    
                    
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
    <script src="/Main/main.js"> </script>
   
    
   
    
    <script>
$(document).ready ( function(){
 Filter('Radio=','recommendations');
});
</script>

</body>
</html>