<?php
$host = 'localhost'; // адрес сервера 
$database = 'dsgn'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'greenhood13'; // пароль

$mysql=new mysqli($host, $user, $password, $database); 

$login=$_COOKIE['user'];
$res =$mysql->query("SELECT * FROM `users` WHERE `Login`='$login' ");
$userArr=$res->fetch_assoc();
$img=base64_encode($userArr['Avatar']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DSGN</title>
    <link rel="stylesheet" href="/profile/profile.css">

</head>
<body>
    <div class="profile_block">
        
    
    <form name="profile_form" onsubmit="change_profiledata();">
    <div class="profile">

        <div class="block">
            <p >Фамилия</p>
            <p><input type="text"  name="sname" value="<?php echo $userArr['Sname']; ?>"></p>
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
            <p >email</p>
            <p><input type="text"  name="email" value="<?php echo $userArr['Email']; ?>"></p>
        </div>
                 
        <div class="block">
          <p >Логин</p>
          <p><input type="text"  name="login" value="<?php echo $userArr['Login']; ?>" readonly></p>
        </div>
                 
        <div class="block">
           <p >Аватар</p>
            <p><input type="file" name="avatar"></p>
                <p class="img"><img src="data:image/jpeg;base64,<?php echo $img ?>" alt=""></p> 
       </div>
    </div>
    <p><input type="submit" name="button_change" value="Сохранить"></p>
    </form>
    </div>
    
    <button onclick="return_to_main()">На главную</button>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="/profile/sub.js"></script>
</body>
</html>





<?php
    


$mysql->close();

?>


