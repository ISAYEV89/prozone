<?php 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include 'inc/confing.php';
include 'language.php';
$site_url="http://".$_SERVER['HTTP_HOST']."/cms/";
if (isset($_SESSION['flogin']) and isset($_SESSION['password'])) 
{
	$_SESSION['flogin'].$_SESSION['password'];
	$pasc=crypt( $_SESSION['password'] , "y6t5r4e3w2q1q!" ); 
	$pasc;
	$sseecs=$db->prepare('SELECT * from meneger u where `u`.`username`="'.s($_SESSION['flogin']).'" and `u`.`key`="'.$pasc.'" ');
	$sseecs->execute();
	$sseecn=$sseecs->rowCount();
	$sseess=$sseecs->fetch(PDO::FETCH_ASSOC);
	if ($sseecn) 
	{
		if (isset($_SESSION['aci']) && (time()-$_SESSION['aci']<1020)) 
		{
			$_SESSION['aci']=time();
		}
		else
		{
			session_destroy();
			header("Location:$site_url"."login.php"); 
			exit();
		}
	}
	else
	{
		header("Location:$site_url"."login.php"); 
		exit();
	}
} 
elseif (isset($_POST['flogin']) and isset($_POST['password'])) 
{
	$_POST['flogin'].$_POST['password'];
 	$pasc=crypt( s($_POST['password']) , "y6t5r4e3w2q1q" ); 
	$sseecs=$db->prepare('SELECT * from meneger u where `u`.`username`="'.s($_POST['flogin']).'" and `u`.`key`="'.$pasc.'" ');
	$sseecs->execute();
	$sseecn=$sseecs->rowCount();
	$sseess=$sseecs->fetch(PDO::FETCH_ASSOC);
	if ($sseecn)
	{
		$_SESSION['aci']=time();
		$_SESSION['flogin']=s($_POST['flogin']);
		$_SESSION['flogin_id']=$sseess['id'];
		$_SESSION['password']=s($_POST['password']);
	}
 	else
	{    
 		header("Location:$site_url"."login.php"); 
 		exit();
  	}
}
else 
{
	header("Location:$site_url"."login.php"); 
	exit();
}

date_default_timezone_set('Europe/Istanbul');
if (@$_GET['state'])
{
  	$state=@s($_GET['state']).'/';
  	if (s($_GET['state'])=='logout') 
  	{
  		$state='logout';
  	}
} 
else 
{ 
	$state='page';
}
if (@$_GET['page'])
{
	@$page=@s($_GET['page']);
} 
else 
{ 
	@$page='';
}

if ($page=='add' || $page=='edit' || $page=='add_photo' || $page=='edit_photo' ) 
{
	$staticquer=$db->prepare('SELECT * from static_info');
	$staticquer->execute();
	$staticft=$staticquer->fetch(PDO::FETCH_ASSOC);
}

function pxtostr($values)
{
	$onetwo=explode('-', $values);
	return 'width: '.$onetwo[0].'px ,'.' height: '.$onetwo[1].'px';
	print_r($onetwo);
}

include 'include/header.php';
include 'include/sidebar.php';
?>

<!-- page content -->
<div class="right_col" role="main">
<?php
include 'include/'.$state.$page.'.php';
?>
</div>
<!-- /page content/ -->
<?php
include 'include/footer.php';
?>