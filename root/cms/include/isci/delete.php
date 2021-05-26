<?php

if ($_POST['delid']) 
{
	$controller=1;
	echo $_POST['delid'];
	$workerquera=$db->prepare('SELECT * FROM worker where u_id=:uid ');
	$workerquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$workerquera->rowCount();
	if ($count!=1) 
	{
	  	header('Location:'.$site_url.'/isci/list/');
	}
	$workerquerasor=$workerquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	echo $controller.'-S<br>';
	$workerquerd=$db->prepare('DELETE FROM worker where u_id=:uid ');
	$delcont=$workerquerd->execute(array('uid'=>s($_POST['delid'])));
	if (!is_null($workerquerasor['picture'])) 
	{		
		if (is_file('images/'.$workerquerasor['picture'])) 
		{
			if (!unlink('images/'.$workerquerasor['picture'])) 
			{
				$controller=0;
			}
		}
	}
	if($delcont)
	{	echo "<br>string";
      	if ($controller==1) 
      	{	
      		echo "<br>thats okey";	      
	      	$db->commit();
		  		header('Location:'.$site_url.'isci/list/456852/');
      	}
      	else
  		{
  			$db->rollback();
		  	header('Location:'.$site_url.'isci/list/456456/');
  		}
	}
  	else
	{
		$db->rollback();
		header('Location:'.$site_url.'isci/list/456456/');
	}
}
else
{
  	header('Location:'.$site_url.'isci/list/');
}
?>