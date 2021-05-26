<?php

if ($_POST['delid']) 
{
	$controller=1;
	echo $_POST['delid'];
	$menuquera=$db->prepare('SELECT * FROM olkeler where kat_id=:uid ');
	$menuquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$menuquera->rowCount();
	if ($count!=1) 
	{
	  	//header('Location:'.$site_url.'/menu/list/');
	}
	$menuquerasor=$menuquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	function alldelete($db,$u_id,&$controller)
	{	echo "<br>yeniye:".$u_id." kecid-<br>";
		$menuquer=$db->prepare('SELECT * FROM olkeler where sub_id=:subid ');
		$menuquer->execute(array('subid'=>s($u_id)));
		$counts=$menuquer->rowCount();
		if ($counts>0) 
		{
			while($menuquersor=$menuquer->fetch(PDO::FETCH_ASSOC))
			{
				$menuquerda=$db->prepare('DELETE FROM olkeler where kat_id=:uid ');
				$delconta=$menuquerda->execute(array('uid'=>s($menuquersor['kat_id'])));
				if($delconta)
				{	
					alldelete($db,$menuquersor['kat_id'],$controller);			  		
				}
			  	else
				{
					echo 'a'.$controller=0;
				}
			}
		}
		echo '<br>-yeni:'.$u_id.'-n sonu<br>';
	}	
	alldelete($db,$menuquerasor['kat_id'],$controller);
	echo $controller.'-S<br>';
	$menuquerd=$db->prepare('DELETE FROM olkeler where kat_id=:uid ');
	$delcont=$menuquerd->execute(array('uid'=>s($_POST['delid'])));
	if (!is_null($menuquerasor['picture'])) 
	{
		if (!unlink('images/'.$menuquerasor['picture'])) 
		{
			$controller=0;
		}
	} 
	if($delcont)
	{	echo "<br>string";
      	if ($controller==1) 
      	{	
      		echo "<br>thats okey";	      
	      	$db->commit();
	  		header('Location:'.$site_url.'country/list/456852/');		
      	}
      	else
  		{
  			$db->rollback();
		  	header('Location:'.$site_url.'country/list/456456/');
  		}
	}
  	else
	{
		$db->rollback();
		header('Location:'.$site_url.'country/list/456456/');
	}
}
else
{
  	header('Location:'.$site_url.'country/list/');
}
?>