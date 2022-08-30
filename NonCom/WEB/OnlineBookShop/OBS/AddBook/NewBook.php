<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/AddBook/NewBook.css">
    
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
        <div class="New">
            <div class="about">
                   <div class="about_text">
                       Новый товар
                   </div>
                </div>
          
                <div class="forma">
                    <form name="addForm">
                        <table class="table NewBook">
                             <tr>
                                   <td><label>Артикул</label></td>
                                   <td><input type = "text"  name = "Article" ></td>
                              </tr>

                              <tr>
                               <td><label>Название</label></td>
			                    <td><input type = "text" name = "Name"></td>
                               </tr>

                               <tr>
			                    <td><label>Жанр</label>
			                    <td><select id="Genre" name="Genre">
                                   <option value="fiction">Художественная литература</option>
                                   <option value="non_fiction">Нехудожественная литература</option>
                                   <option value="nerd">Комиксы,манга,артбуки</option>
                                   <option value="education">Учебная лит-ра</option>
                              </select></td>
                               </tr>

                               <tr>
			                    <td><label>Поджанр</label>
			                    <td><select id="Subgenre" name="Subgenre">
                                   <option value="adventure">Приключения</option>
                                   <option value="detective">Детективы</option>
                                   <option value="fantasy">Фантастика</option>
                                   <option value="cook">Кулинария</option>
                                   <option value="psy">Психология</option>
                                   <option value="business">Бизнес.Экономика</option>
                                   <option value="comics">Комиксы</option>
                                   <option value="art">Артбуки</option>
                                   <option value="manga">Манга</option>
                                   <option value="HEI">Подготовка в ВУЗ</option>
                                   <option value="school">Книги для школы</option>
                                   <option value="vocab">Словари и разговорники</option>
                              </select></td>
                               </tr>

                               <tr>
                                <td><label>Цена</label></td>
                                 <td><input type = "number" name = "Price" min="1"></td>
                               </tr>

                                  <tr>
                                <td><label>Обложка</label></td>
                                 <td><select id="Cover" name="Cover">
                                     <option value="soft">Мягкая</option>
                                     <option value="hard">Твёрдая</option>
                                 </select></td>
                               </tr>

                                <tr>
                                <td><label>Бумага</label></td>
                                 <td><select id="Paper" name="Paper">
                                     <option value="of">Офсет</option>
                                     <option value="gz">Газетная</option>
                                     <option value="mel">Мелованная</option>
                                 </select></td>
                               </tr>


                               <tr>
                               <td><label>Автор</label></td>
			                    <td><input type = "text" name = "Author"></td>
                               </tr>

                               <tr>
                               <td><label>Описание</label></td>
			                    <td><input type = "text" name = "Description"></td>
                               </tr>

                               <tr>
                               <td><label>Превью</label></td>
			                    <td><input type="file" name="Image"></td>
                               </tr>
                               
			
                         </table>
                         <div class="form_btn">
                          <input type = "submit" name = "submit" value = "Добавить">
                         </div>



                    </form>
                </div>

        
        </div>
        



    </div>
    <script src="/Extensions/jquery-3.6.0.min.js"> </script>
     <script src="/Extensions/jquery.dataTables.min.js"></script>
       <script src="/AddBook/NewBook.js"> </script>

        
</body>
</html>