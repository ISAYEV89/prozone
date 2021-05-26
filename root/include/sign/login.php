<?php
$data=[];
session_start();

if(isset($_POST['laid_login']) && isset($_POST['_originalToken']) && $_POST['_originalToken']==$_SESSION['_originalToken'])

{
$data['ok']=$_SESSION['_originalToken'];
echo json_encode($data);

}
