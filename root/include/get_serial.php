<?php
require_once "../inc/confing.php";
$user = $db->prepare("SELECT us.serial FROM user as us WHERE us.login=:login");
$user->execute(['login'=>$_REQUEST['serial']]);
$get = $user->fetch(PDO::FETCH_ASSOC);
echo $get['serial'];
?>