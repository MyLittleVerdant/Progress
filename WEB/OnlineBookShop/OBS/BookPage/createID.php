<?php

setcookie('book',$_POST['Book'],time()+3600,"/");
echo json_encode($_COOKIE['book']); 

?>