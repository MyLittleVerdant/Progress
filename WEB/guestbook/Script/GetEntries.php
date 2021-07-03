<?php

    
    $host = 'localhost'; // ����� ������� 
    $database = 'guestbook'; // ��� ���� ������
    $user = 'root'; // ��� ������������
    $password = 'greenhood13'; // ������

    $mysql=new mysqli($host, $user, $password, $database); 
   

    if(isset($_POST['Info']))
    {
        $get_entries =$mysql->query("SELECT `UserName`,`E-mail`,`Homepage`,`DateTime`, `Text`FROM `entry`");
        
        while ($row = $get_entries->fetch_assoc())
        {
             $entry_list[]=$row;   
        }
        
        echo json_encode($entry_list);
    }
    

    $mysql->close();  



?>