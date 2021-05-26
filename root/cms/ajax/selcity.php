<?PHP
	include('../inc/confing.php');
	$c_id=$_GET['country_id'];
	
	echo '<option value="">All cities</option>';
	if($c_id!=0)
	{
		$olkesql=$db->prepare('select kat_id, name from olkeler where l_id=1 and sub_id="'.$c_id.'"');
		$olkesql->execute();
		while ($olke=$olkesql->fetch(PDO::FETCH_ASSOC)) 
		{
			echo'<option value="'.$olke['kat_id'].'">'.$olke['name'].'</option>';
		}
	}
?>