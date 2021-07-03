<?php

    
    $host = 'localhost'; // адрес сервера 
    $database = 'guestbook'; // имя базы данных
    $user = 'root'; // имя пользователя
    $password = 'greenhood13'; // пароль

    $mysql=new mysqli($host, $user, $password, $database); 

    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];

    //$Browser=strval($_SERVER["HTTP_USER_AGENT"]);
    $Browser=$_SERVER["HTTP_USER_AGENT"];
    
    $datetime = getdate();
    $datetime=$datetime['mday']."/".$datetime['mon']."/".$datetime['year']."  ".$datetime['hours'].":".$datetime['minutes'].":".$datetime['seconds'];
     
    if(filter_var($client, FILTER_VALIDATE_IP)) $IP = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) $IP = $forward;
            else $IP = $remote;
    //$IP=strval($IP);

            $UsrName=$_POST['UsrNm'];
            $Email=$_POST['Email'];
            $Page=htmlspecialchars($_POST['HP']);
            $Msg=htmlspecialchars($_POST['MSG']);

            $Page=$mysql->real_escape_string($Page);
            $Msg=$mysql->real_escape_string($Msg);
           
            $mysql->query("INSERT INTO `entry`(`UserName`,`E-mail`,`Homepage`,`Text`,`IP`,`BrowInfo`,`DateTime`) 
                          VALUES('$UsrName','$Email','$Page','$Msg','$IP','$Browser','$datetime' )");

    echo json_encode($mysql->error);    

    $mysql->close();  



?>