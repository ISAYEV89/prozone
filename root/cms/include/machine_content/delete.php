<?php
if ($_POST['delid']) 
{
	$array=array();
	$controller=1;
	echo $_POST['delid'];
	$blogquera=$db->prepare('SELECT * FROM texnika_content where u_id=:uid ');
	$blogquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$blogquera->rowCount();
	if ($count!=1) 
	{
	  header('Location:'.$site_url.'/machine_content/list/');
	  exit();
	}
	$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	$blogquerd=$db->prepare('DELETE FROM texnika_content where u_id=:uid ');
	$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
	$deletecatcont=$db->prepare('DELETE FROM texnika_cat_cont where cont_id=:contid ');
	$delcatcont=$deletecatcont->execute(array('contid'=>s($_POST['delid'])));
	if(!$delcatcont)
	{	
	  $controller=0;
	}
	if ($controller==1) 
	{
		$blogiquera=$db->prepare('SELECT * FROM texnika_img where t_id=:bid ');
		$blogiquera->execute(array('bid'=>s($_POST['delid'])));
		$counts=$blogiquera->rowCount();
		if($counts>0)
		{
			while ($blogiquersor=$blogiquera->fetch(PDO::FETCH_ASSOC)) 
			{
				$blogiquerda=$db->prepare('DELETE FROM texnika_img where u_id=:uid ');
				$delconta=$blogiquerda->execute(array('uid'=>s($blogiquersor['u_id'])));
				if($delconta)
				{	
					if (!in_array($blogiquersor['dir'], $array)) 
					{				
						array_push($array, $blogiquersor['dir']);
						if(is_file('images/'.$blogiquersor['dir']))
						{
					      	if (!unlink('images/'.$blogiquersor['dir']))
					      	{
					      		echo '<br>multi_pic'.$blogiquersor['dir'].'<br>multi_uid'.$blogiquersor['u_id'];
					      		$controller=0;
					      	}
				      	}
			  		}
				}
			  	else
				{
					echo 'a'.$controller=0;
				}
			}
		}
		if($delcont)
		{
			if (is_file('images/'.$blogquerasor['picture'])) 
			{
		      	if (unlink('images/'.$blogquerasor['picture'])) 
		      	{
		      		$db->commit();
		  		  	header('Location:'.$site_url.'machine_content/list/456852/');
		  		  	exit();
		      	}
		      	else
		  		{
		  			$db->rollback();
				  	header('Location:'.$site_url.'machine_content/list/456456/');
				  	exit();
		  		}
			}
			else
			{				
	      		$db->commit();
	  		  	header('Location:'.$site_url.'machine_content/list/456852/');
	  		  	exit();
			}
		}
	  	else
		{
			$db->rollback();
			header('Location:'.$site_url.'machine_content/list/456456/');
			exit();
		}
	}
}
else
{
  	header('Location:'.$site_url.'machine_content/list/');
  	exit();
}
?>