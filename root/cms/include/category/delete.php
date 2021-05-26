<?php
if ($_POST['delid']) 
{
	$controller=1;
	echo $_POST['delid'];
	$blogquera=$db->prepare('SELECT * FROM kateqoriyalar where kat_id=:uid and l_id="1" ');
	$blogquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$blogquera->rowCount();
	if ($count!=1) 
	{
	  	header('Location:'.$site_url.'/category/list/');
	  	exit();
	}
	$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	if (is_file('images/'.$blogquerasor['picture'])) 
	{
		if (unlink('images/'.$blogquerasor['picture'])) 
	  	{
			$blogquerd=$db->prepare('DELETE FROM kateqoriyalar where kat_id=:uid ');
			$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
			if($delcont)
			{	echo "<br>string";
		      	if ($controller==1) 
		      	{	
		      	echo	'<br>picture-'.$blogquerasor['picture'].'<br>uid-'.$$logquerasor['kat_id'];
		      	echo "<br>thats okey";	      
			      	$db->commit();
			  		header('Location:'.$site_url.'category/list/456852/');
			  		exit();
			  	
		      	}
		      	else
		  		{
		  			$db->rollback();
				  	header('Location:'.$site_url.'category/list/456456/');
				  	exit();
		  		}
			}
		  	else
			{
				$db->rollback();
				header('Location:'.$site_url.'category/list/456456/');
				exit();
			}
		}
	  	else
		{
			$db->rollback();
	  		header('Location:'.$site_url.'category/list/456456/');
	  		exit();
		}
	}
	else
	{		
		$blogquerd=$db->prepare('DELETE FROM kateqoriyalar where kat_id=:uid ');
		$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
		if($delcont)
		{	echo "<br>string";
	      	if ($controller==1) 
	      	{	
	      	echo	'<br>picture-'.$blogquerasor['picture'].'<br>uid-'.$$logquerasor['kat_id'];
	      	echo "<br>thats okey";	      
		      	$db->commit();
		  		header('Location:'.$site_url.'category/list/456852/');
		  		exit();
		  	
	      	}
	      	else
	  		{
	  			$db->rollback();
			  	header('Location:'.$site_url.'category/list/456456/');
			  	exit();
	  		}
		}
	  	else
		{
			$db->rollback();
			header('Location:'.$site_url.'category/list/456456/');
			exit();
		}
	}
}
else
{
  	header('Location:'.$site_url.'category/list/');
  	exit();
}
?>