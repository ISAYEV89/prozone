<?php
if ($_POST['delid']) 
{
	$controller=1;
	echo $_POST['delid'];
	$blogquera=$db->prepare('SELECT * FROM texnika_cat where u_id=:uid and l_id="1" ');
	$blogquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$blogquera->rowCount();
	if ($count!=1) 
	{
	  	header('Location:'.$site_url.'/machine_cat/list/');
	  	exit();
	}
	$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	function alldelete($db,$u_id,&$controller)
	{	echo "<br>yeniye:".$u_id." kecid-<br>";
		$blogquer=$db->prepare('SELECT * FROM texnika_cat where sub_id=:subid ');
		$blogquer->execute(array('subid'=>s($u_id)));
		$counts=$blogquer->rowCount();
		$array=array();
		if ($counts>0) 
		{
			while($blogquersor=$blogquer->fetch(PDO::FETCH_ASSOC))
			{
				$blogquerda=$db->prepare('DELETE FROM texnika_cat where u_id=:uid ');
				$delconta=$blogquerda->execute(array('uid'=>s($blogquersor['u_id'])));
				if($delconta)
				{	
					if (!in_array($blogquersor['picture'], $array)) 
					{				
						array_push($array, $blogquersor['picture']);

						if (is_file('images/'.$blogquersor['picture']) and unlink('images/'.$blogquersor['icon'])) 
					  	{
					      	if (unlink('images/'.$blogquersor['picture']) and unlink('images/'.$blogquersor['icon']))
					      	{
					      		echo '<br>multi_pic'.$blogquersor['picture'].'<br>multi_ico'.$blogquersor['icon'].'<br>multi_uid'.$blogquersor['u_id'];
								alldelete($db,$blogquersor['u_id'],$controller);
					      	}
					      	else
					  		{
					  			echo $controller=0;
					  		}
				  		}
			  			$deletecatcont2=$db->prepare('DELETE FROM texnika_cat_cont where cat_id=:catid ');
						$delcatcont2=$deletecatcont2->execute(array('catid'=>s($blogquersor['u_id'])));
						if(!$delcatcont2)
						{	
						  $controller=0;
						}
			  		}
				}
			  	else
				{
					echo 'a'.$controller=0;
				}
			}
		}
		echo '<br>-yeni:'.$u_id.'-n sonu<br>';
	}	
	alldelete($db,$blogquerasor['u_id'],$controller);
	echo $controller.'-S<br>';
	$deletecatcont=$db->prepare('DELETE FROM texnika_cat_cont where cat_id=:catid ');
	$delcatcont=$deletecatcont->execute(array('catid'=>s($_POST['delid'])));
	if(!$delcatcont)
	{	
	  $controller=0;
	}

	if (is_file('images/'.$blogquerasor['picture']) and is_file('images/'.$blogquerasor['icon'])) 
	{
		if (unlink('images/'.$blogquerasor['picture']) and unlink('images/'.$blogquerasor['icon'])) 
	  	{
			$blogquerd=$db->prepare('DELETE FROM texnika_cat where u_id=:uid ');
			$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
			if($delcont)
			{	echo "<br>string";
		      	if ($controller==1) 
		      	{	
		      	echo	'<br>son-esas_picture'.$blogquerasor['picture'].'<br>icon-'.$blogquerasor['icon'].'<br>uid-'.$$logquerasor['u_id'];
		      	echo "<br>thats okey";	      
			      	$db->commit();
			  		header('Location:'.$site_url.'machine_cat/list/456852/');
			  		exit();
			  	
		      	}
		      	else
		  		{
		  			$db->rollback();
				  	header('Location:'.$site_url.'machine_cat/list/456456/');
				  	exit();
		  		}
			}
		  	else
			{
				$db->rollback();
				header('Location:'.$site_url.'machine_cat/list/456456/');
				exit();
			}
		}
	  	else
		{
			$db->rollback();
	  		header('Location:'.$site_url.'machine_cat/list/456456/');
	  		exit();
		}
	}
	else
	{		
		$blogquerd=$db->prepare('DELETE FROM texnika_cat where u_id=:uid ');
		$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
		if($delcont)
		{	echo "<br>string";
	      	if ($controller==1) 
	      	{	
	      	echo	'<br>son-esas_picture'.$blogquerasor['picture'].'<br>icon-'.$blogquerasor['icon'].'<br>uid-'.$$logquerasor['u_id'];
	      	echo "<br>thats okey";	      
		      	$db->commit();
		  		header('Location:'.$site_url.'machine_cat/list/456852/');
		  		exit();
		  	
	      	}
	      	else
	  		{
	  			$db->rollback();
			  	header('Location:'.$site_url.'machine_cat/list/456456/');
			  	exit();
	  		}
		}
	  	else
		{
			$db->rollback();
			header('Location:'.$site_url.'machine_cat/list/456456/');
			exit();
		}
	}
}
else
{
  	header('Location:'.$site_url.'machine_cat/list/');
  	exit();
}
?>