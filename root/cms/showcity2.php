<?PHP
	include('../inc/config.php');
	$c_id=$_GET['country_id'];
	$sql='SELECT * FROM `city` where `olk_id`="'.$c_id.'" order by id asc';
	$n=mysqli_query($connection,$sql);
	echo '<select name="selCity" id="selCity" style="width: 216px !important;margin: 6px;padding-left: 6px;">';
	while($b=mysqli_fetch_array($n))
	{
		echo '<option value="'.$b['id'].'">'.$b['sheher'].'</option>';
	}
	echo '</select>';
?>