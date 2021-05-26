<?php
if ($_POST['delid']) 
{
	$array=array();
	$controller=1;
	echo $_POST['delid'];
	$blogquera=$db->prepare('SELECT * FROM customer where id=:uid ');
	$blogquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$blogquera->rowCount();
	if ($count!=1) 
	{
	  header('Location:'.$site_url.'/customer/list/');
	  exit();
	}
	$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	$blogquerd=$db->prepare('DELETE FROM customer where id=:uid ');
	$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));

	if($delcont)
	{
  		$db->commit();
		  	header('Location:'.$site_url.'customer/list/456852/');
		  	exit();
	}
  	else
	{
		$db->rollback();
		header('Location:'.$site_url.'customer/list/456456/');
		exit();
	}
}
else
{
  	header('Location:'.$site_url.'customer/list/');
  	exit();
}
?>