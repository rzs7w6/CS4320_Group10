<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 16/4/2
 * Time: 22:30
 */


setcookie('user_name',"",time()-3600);
setcookie('user_id',"",time()-3600);
setcookie('role_type',"",time()-3600);
header("Location:login.html");
exit;

?>