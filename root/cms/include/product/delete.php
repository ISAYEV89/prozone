<?php
if ($_POST['delid']) 
{
	$db->begintransaction();
	$array=array();
	$controller=1;
	$blogquera=$db->prepare('SELECT * FROM mehsul where u_id=:uid  and l_id="1"  ');
	$blogquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$blogquera->rowCount();
	
	if ($count!=1) 
	{
	  	header('Location:'.$site_url.'/product/list/');
		exit();
	}
	$blogquerd=$db->prepare('update mehsul set s_id="2" where u_id=:uid ');
	$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
	if ($delcont) 
	{
		$db->commit();
		header('Location:'.$site_url.'product/list/456852/');
		exit();
	}
	else
	{
		$db->rollback();
		header('Location:'.$site_url.'product/list/456456/');
		exit();
	}
	/*
	$blogquerasor=$blogquera->fetch(PDO::FETCH_ASSOC);
	$blogquerd=$db->prepare('DELETE FROM mehsul where u_id=:uid ');
	$delcont=$blogquerd->execute(array('uid'=>s($_POST['delid'])));
	$deletecatcont=$db->prepare('DELETE FROM mehsul_olke where m_u_id=:contid ');
	$delcatcont=$deletecatcont->execute(array('contid'=>s($_POST['delid'])));
	if(!$delcatcont)
	{	
	  $controller=0;
	}
	$deletecatcont2=$db->prepare('DELETE FROM mehsul_kateqoriya where m_u_id=:contid ');
	$delcatcont2=$deletecatcont2->execute(array('contid'=>s($_POST['delid'])));
	if(!$delcatcont2)
	{	
	  $controller=0;
	}
	$deletecatcont2=$db->prepare('DELETE FROM mehsul_olke_price where m_u_id=:contid ');
	$delcatcont2=$deletecatcont2->execute(array('contid'=>s($_POST['delid'])));
	$deletecatcont2=$db->prepare('DELETE FROM product_details where product_id=:contid ');	
	$delcatcont2=$deletecatcont2->execute(array('contid'=>s($_POST['delid'])));
	if(!$delcatcont2)
	{	
	  $controller=0;
	}
	if ($controller==1) 
	{
		$blogiquera=$db->prepare('SELECT * FROM product_gallery where product_id=:bid ');
		$blogiquera->execute(array('bid'=>s($_POST['delid'])));
		$counts=$blogiquera->rowCount();
		if($counts>0)
		{
			while ($blogiquersor=$blogiquera->fetch(PDO::FETCH_ASSOC)) 
			{
				$blogiquerda=$db->prepare('DELETE FROM product_gallery where id=:uid ');
				$delconta=$blogiquerda->execute(array('uid'=>s($blogiquersor['id'])));
				if($delconta)
				{	
					if (!in_array($blogiquersor['image'], $array)) 
					{				
						array_push($array, $blogiquersor['image']);
						if (is_file('images/'.$blogiquersor['image'])) 
						{
					      	if (unlink('images/'.$blogiquersor['image']))
					      	{
					      		echo '<br>multi_pic'.$blogiquersor['image'].'<br>multi_uid'.$blogiquersor['id'];
					      	}
					      	else
					  		{
					  			echo $controller=0;
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
			if (is_file('images/'.$blogquerasor['image_url'])) 
			{
		      	if (unlink('images/'.$blogquerasor['image_url'])) 
		      	{
		      		$db->commit();
		  		  	header('Location:'.$site_url.'product/list/456852/');
		  		  	exit();
		      	}
		      	else
		  		{
		  			$db->rollback();
				  	header('Location:'.$site_url.'product/list/456456/');
				  	exit();
		  		}
		  	}
		  	else
		  	{
	      		$db->commit();
	  		  	header('Location:'.$site_url.'product/list/456852/');
	  		  	exit();
		  	}
		}
	  	else
		{
			$db->rollback();
			header('Location:'.$site_url.'product/list/456456/');
			exit();
		}
	}
	*/
}
else
{
  	header('Location:'.$site_url.'product/list/');
  	exit();
}
?>