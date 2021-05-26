<?php

if ($_POST['delid']) 
{
	$controller=1;
	echo $_POST['delid'];
	$menuquera=$db->prepare('SELECT * FROM menu where u_id=:uid and l_id="1"  ');
	$menuquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$menuquera->rowCount();
	if ($count!=1) 
	{
	  	header('Location:'.$site_url.'/menu/list/');
	  	exit();
	}
	$menuquerasor=$menuquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	function alldelete($db,$u_id,&$controller)
	{	echo "<br>yeniye:".$u_id." kecid-<br>";
		$menuquer=$db->prepare('SELECT * FROM menu where sub_id=:subid ');
		$menuquer->execute(array('subid'=>s($u_id)));
		$counts=$menuquer->rowCount();
		if ($counts>0) 
		{
			while($menuquersor=$menuquer->fetch(PDO::FETCH_ASSOC))
			{
				$menuquerda=$db->prepare('DELETE FROM menu where u_id=:uid ');
				$delconta=$menuquerda->execute(array('uid'=>s($menuquersor['u_id'])));
				if($delconta)
				{	
					alldelete($db,$menuquersor['u_id'],$controller);			  		
				}
			  	else
				{
					echo 'a'.$controller=0;
				}
			}
		}
		echo '<br>-yeni:'.$u_id.'-n sonu<br>';
	}	
	alldelete($db,$menuquerasor['u_id'],$controller);
	echo $controller.'-S<br>';
	$menuquerd=$db->prepare('DELETE FROM menu where u_id=:uid ');
	$delcont=$menuquerd->execute(array('uid'=>s($_POST['delid'])));
	if($delcont)
	{	echo "<br>string";
      	if ($controller==1) 
      	{	
      		echo "<br>thats okey";	      
	      	$db->commit();
	      	if (strpos($_SERVER['HTTP_REFERER'], 'list_top')) 
	      	{
		  		header('Location:'.$site_url.'menu/list_top/456852/');
		  		exit();
	      	}
	      	elseif(strpos($_SERVER['HTTP_REFERER'], 'list_bottom'))
	      	{
		  		header('Location:'.$site_url.'menu/list_bottom/456852/');
		  		exit();
	      	}
	      	elseif(strpos($_SERVER['HTTP_REFERER'], 'list_left'))
	      	{
		  		header('Location:'.$site_url.'menu/list_left/456852/');
		  		exit();	      		
	      	}
	      	else
	      	{
		  		header('Location:'.$site_url.'menu/list_secret/456852/');
		  		exit();	
	      	}  	
      	}
      	else
  		{
  			$db->rollback();
		  	header('Location:'.$site_url.'menu/list/456456/');
		  	exit();
  		}
	}
  	else
	{
		$db->rollback();
		header('Location:'.$site_url.'menu/list/456456/');
		exit();
	}
}
else
{
  	header('Location:'.$site_url.'menu/list/');
  	exit();
}
?>