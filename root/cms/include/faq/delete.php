<?php

if ($_POST['delid']) 
{
	$controller=1;
	echo $_POST['delid'];
	$faqquera=$db->prepare('SELECT * FROM faq where u_id=:uid ');
	$faqquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$faqquera->rowCount();
	if ($count!=1) 
	{
	  	header('Location:'.$site_url.'/faq/list/');
	}
	$faqquerasor=$faqquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	echo $controller.'-S<br>';
	$faqquerd=$db->prepare('DELETE FROM faq where u_id=:uid ');
	$delcont=$faqquerd->execute(array('uid'=>s($_POST['delid'])));

	if($delcont)
	{	echo "<br>string";
      	if ($controller==1) 
      	{	
      		echo "<br>thats okey";	      
	      	$db->commit();
		  		header('Location:'.$site_url.'faq/list/456852/');
      	}
      	else
  		{
  			$db->rollback();
		  	header('Location:'.$site_url.'faq/list/456456/');
  		}
	}
  	else
	{
		$db->rollback();
		header('Location:'.$site_url.'faq/list/456456/');
	}
}
else
{
  	header('Location:'.$site_url.'faq/list/');
}
?>