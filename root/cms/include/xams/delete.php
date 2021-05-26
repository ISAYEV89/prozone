<?php
if ($_POST['delid']) 
{
	$controller=1;
	echo $_POST['delid'];
	$blogquera=$db->prepare('SELECT * FROM xams where u_id=:uid and l_id="1" ');
	$blogquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$blogquera->rowCount();
	if ($count!=1) 
	{
	  	header('Location:'.$site_url.'/xams/list/');
	  	exit();
	}
	$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	if (is_file('images/'.$blogquerasor['icon'])) 
	{
		if (unlink('images/'.$blogquerasor['icon'])) 
	  	{
			$blogquerd=$db->prepare('DELETE FROM xams where u_id=:uid ');
			$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
			if($delcont)
			{	echo "<br>string";
		      	if ($controller==1) 
		      	{	
		      	echo	'<br>icon-'.$blogquerasor['icon'].'<br>uid-'.$$logquerasor['u_id'];
		      	echo "<br>thats okey";	      
			      	$db->commit();
			  		header('Location:'.$site_url.'xams/list/456852/');
			  		exit();
			  	
		      	}
		      	else
		  		{
		  			$db->rollback();
				  	header('Location:'.$site_url.'xams/list/456456/');
				  	exit();
		  		}
			}
		  	else
			{
				$db->rollback();
				header('Location:'.$site_url.'xams/list/456456/');
				exit();
			}
		}
	  	else
		{
			$db->rollback();
	  		header('Location:'.$site_url.'xams/list/456456/');
	  		exit();
		}
	}
	else
	{		
		$blogquerd=$db->prepare('DELETE FROM xams where u_id=:uid ');
		$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
		if($delcont)
		{	echo "<br>string";
	      	if ($controller==1) 
	      	{	
	      	echo	'<br>icon-'.$blogquerasor['icon'].'<br>uid-'.$$logquerasor['u_id'];
	      	echo "<br>thats okey";	      
		      	$db->commit();
		  		header('Location:'.$site_url.'xams/list/456852/');
		  		exit();
		  	
	      	}
	      	else
	  		{
	  			$db->rollback();
			  	header('Location:'.$site_url.'xams/list/456456/');
			  	exit();
	  		}
		}
	  	else
		{
			$db->rollback();
			header('Location:'.$site_url.'xams/list/456456/');
			exit();
		}
	}
}
else
{
  	header('Location:'.$site_url.'xams/list/');
  	exit();
}
?>