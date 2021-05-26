<?PHP
	include('../inc/confing.php');
	$id=$_POST['id'];
	$ds_id=$_POST['ds_id'];
	
	$olkesql=$db->prepare('update  orders set ds_id="'.$ds_id.'" where id="'.$id.'"');
	$olkesql->execute();
	echo 'done';
		
?>