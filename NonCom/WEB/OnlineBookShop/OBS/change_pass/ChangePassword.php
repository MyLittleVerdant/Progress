<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DSGN</title>
</head>
<body>
 <?php
 $string=str_shuffle("lmnopz");
?>
  <div class="showrnd"><?php 
echo $string
?></div>
  
   <form name="change_pass">
   <p>Код</p>
   <p><input type="text" name="UserCode" id="UserCode"></p>
   <input type="hidden" name="code" value="<?php echo $string ?>"  id="code">
   <p>Введите логин</p>
   <p><input type="text" name="login"></p>
   <p>Введите новый пароль</p>
   <p><input type="text" name="pass"></p>
   <p><input type="submit" name="do_signup" value="Подтвердить"></p>
     </form>
     
     <div id="success"display="none"></div>
     <button onclick="window.location.href = '../..'">На главную</button>
     <script src="/Extensions/jquery-3.6.0.min.js"> </script>
      <script src="/change_pass/changepass.js"></script>
    


</body>
</html>


