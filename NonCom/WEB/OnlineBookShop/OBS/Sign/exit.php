<?php
if($_POST['our_inp']='GO!')
setcookie('user',$_COOKIE['user'],time()-3600,"/");
echo "OK!";
?>