<?php
if ($_POST['delid']) 
{
	$array=array();
	$controller=1;
	echo $_POST['delid'];
	$blogquera=$db->prepare('SELECT * FROM blog_content where u_id=:uid and l_id="1" ');
	$blogquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$blogquera->rowCount();
	if ($count!=1) 
	{
	  header('Location:'.$site_url.'/blog_content/list/');
	  exit;
	}
	$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	$blogquerd=$db->prepare('DELETE FROM blog_content where u_id=:uid ');
	$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
	if ($controller==1) 
	{
		if($delcont)
		{
			if (is_file('images/'.$blogquerasor['picture']) and is_file('images/'.$blogquerasor['photo1']) and is_file('images/'.$blogquerasor['photo2'])) 
			{
		      	if (unlink('images/'.$blogquerasor['picture']) and unlink('images/'.$blogquerasor['photo1']) and unlink('images/'.$blogquerasor['photo2'])) 
		      	{
		      		$db->commit();
		  		  	header('Location:'.$site_url.'blog_content/list/456852/');
		      	}
		      	else
		  		{
		  			$db->rollback();
				  	header('Location:'.$site_url.'blog_content/list/456456/');
		  		}
			}
			else
			{				
	      		$db->commit();
	  		  	header('Location:'.$site_url.'blog_content/list/456852/');
			}
		}
	  	else
		{
			$db->rollback();
			header('Location:'.$site_url.'blog_content/list/456456/');
		}
	}
}
else
{
  	header('Location:'.$site_url.'blog_content/list/');
}
?>