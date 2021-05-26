<?php
if ($_POST['delid']) 
{
	echo $_POST['delid'];
	$lngquera=$db->prepare('SELECT * FROM lng where u_id=:uid ');
	$lngquera->execute(array('uid'=>s($_POST['delid'])));
	$count=$lngquera->rowCount();
	if ($count!=1) 
	{
	  header('Location:'.$site_url.'/lng/list/');
	  exit();
	}

	$lngquer=$db->prepare('SELECT def , MAX(`t`.`u_id`) as max FROM (SELECT u_id as def from lng where `default` is not null ) g , (SELECT * from lng where u_id!=:uid ) t ');
	$lngquer->execute(array('uid'=>s($_POST['delid']))); 
	$lngquersor=$lngquer->fetch(PDO::FETCH_ASSOC);
	$default=$lngquersor['def'];

	$lngquerasor=$lngquera->fetch(PDO::FETCH_ASSOC);
	$db->begintransaction();
	$lngquerd=$db->prepare('DELETE FROM lng where u_id=:uid ');
	$delcont=$lngquerd->execute(array('uid'=>s($_POST['delid'])));
	$lngquerx=$db->prepare('SELECT * FROM lng where u_id!=:udi');
	$lngquerx->execute(array('udi'=>s($_POST['delid']))); 
	$lngstring='';
	$wnum=0;
	while($lngquerxcek=$lngquerx->fetch(PDO::FETCH_ASSOC))
	{
	if ($wnum==0) 
	{
	  $lngstring=$lngquerxcek['short_name'];
	}
	else
	{
	  $lngstring.='|'.$lngquerxcek['short_name'];
	}
	$wnum++;
	}
	if ($default==s($_POST['delid'])) 
	{
      $lngup=$db->prepare('UPDATE lng set `default`=:df where u_id=:udi ');
      $lngupcon=$lngup->execute(array('df'=>1 , 'udi'=>s($lngquersor['max']) ));
      if (!$lngupcon) 
      {
       echo $delcont=0;
      }
	}
	echo $lngquersor['max'].'-&-'.$lngquersor['def'];
	if($delcont)
	{	
		if (is_file('images/'.$lngquerasor['icon'])) 
		{		
	      	if (unlink('images/'.$lngquerasor['icon'])) 
	      	{
	      		$db->commit(); 
				$txt='RewriteEngine On
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/([A-z0-9\-\_]+)/(page)/([0-9]+)/ index.php?lng=$1&state=$2&cat=$3&static=$4&page=$5 [NC,L]
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/([A-z0-9\-\_]+)/([A-z0-9\-\_]+)/ index.php?lng=$1&state=$2&cat=$3&cname=$4 [NC,L]
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/([A-z0-9\-\_]+)/ index.php?lng=$1&state=$2&cat=$3 [NC,L]
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/ index.php?lng=$1&state=$2 [NC,L]
RewriteRule ^('.$lngstring.')/ index.php?lng=$1 [NC,L]'; 
				$f = fopen('../.htaccess', 'w+');
				fwrite($f, $txt);
				fclose($f);
	  		  	header('Location:'.$site_url.'lng/list/456852/');
	  		  	exit();
	      	}
	      	else
	  		{
	  			$db->rollback();
			  	header('Location:'.$site_url.'lng/list/456456/');
			  	exit();
	  		}
  		}
  		else
  		{  			
      		$db->commit(); 
			$txt='RewriteEngine On
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/([A-z0-9\-\_]+)/(page)/([0-9]+)/ index.php?lng=$1&state=$2&cat=$3&static=$4&page=$5 [NC,L]
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/([A-z0-9\-\_]+)/([A-z0-9\-\_]+)/ index.php?lng=$1&state=$2&cat=$3&cname=$4 [NC,L]
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/([A-z0-9\-\_]+)/ index.php?lng=$1&state=$2&cat=$3 [NC,L]
RewriteRule ^('.$lngstring.')/(shop|blog|menu|machine)/ index.php?lng=$1&state=$2 [NC,L]
RewriteRule ^('.$lngstring.')/ index.php?lng=$1 [NC,L]'; 
			$f = fopen('../.htaccess', 'w+');
			fwrite($f, $txt);
			fclose($f);
  		  	header('Location:'.$site_url.'lng/list/456852/');
  		  	exit();
  		}
	}
  	else
	{ echo 'dasad';
		$db->rollback();
		header('Location:'.$site_url.'lng/list/456456/');
		exit();
	}

}
else
{
  	header('Location:'.$site_url.'lng/list/');
  	exit();
}
?>