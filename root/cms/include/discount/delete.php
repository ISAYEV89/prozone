<?PHP
	$id=$_POST['delid'];
	
	$sql='delete from mehsul_discount where id=:id limit 1';
	$data=ARRAY('id'=>$id);
	
	try
	{
		$db->prepare($sql)->execute($data);
	}
	catch(PDOException $e)

	{

		echo $e->getMessage();
		header('Location:'.$site_url.'discount/list/456456/');

	}
	header('Location:'.$site_url.'discount/list/456852/');
?>
