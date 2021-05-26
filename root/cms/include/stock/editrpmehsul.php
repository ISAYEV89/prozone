<?PHP

	//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	$id = $_GET['val'];
	if($_POST['send'])
	{
		
		$sql=$db->prepare('delete from stock_rp_mehsul where srp_id=:id');
		$sql->execute(ARRAY('id'=>"$id"));
		
		
		$sql2=$db->prepare('insert into stock_rp_mehsul (id , m_uid, srp_id, unit_count, s_id) values ( NULL , :val , :id , :pc , "1")');
		foreach($_POST['muid'] as $value)
		{
			$pc=$_POST['msay'][$value]; //product count in package
			if($pc<1) $pc=1;
			$sql2->execute(ARRAY('val'=>"$value" , 'id'=>"$id" , 'pc'=>"$pc" ));
			
		}
		
		echo "<br><br><center><b><font size='4' color='red'> Product list Succesfully updated </font></b></center></br><br>
			<script>
			function redi(){
			document.location='$site_url/stock/list/'
			}
			setTimeout(\"redi()\", 3000);
			</script>";
	}
	else {

	$sql=$db->prepare('SELECT spp.* FROM stock_rp spp WHERE spp.id=:id');
	$sql->execute(ARRAY('id'=>"$id"));
		
	$b=$sql->fetch(PDO::FETCH_ASSOC);
	//print_r($b);
	?>

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Edit Product list for Ready Product - <small><?PHP echo $b['name'];?></small></h2>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
		<br />
		<form  name="form1" method="post" action="" class="form-horizontal form-label-left">

		  <table class="table table-hover" id="delivery_list">
				<thead>
					<tr>
						<th><b>Check					</b></th>
						<th><b>Product count in package	</b></th>
						<th><b>ID						</b></th>
						<th><b>Name						</b></th>
					</tr>
				</thead>
				<tbody>
					<?PHP
					$sql2=$db->prepare('select 
							`m`.`name` mname,
							`m`.u_id mid,
							`srpm`.unit_count uc
						from 
							stock_rp_mehsul srpm, 
							mehsul m 
						where 
							m.l_id=1 and
							m.u_id=srpm.m_uid and
							srpm.srp_id="'.$id.'"');
					$sql2->execute();
					$mid=array();
					while($b2=$sql2->fetch(PDO::FETCH_ASSOC))
					{
						$mid[]=$b2['mid'];
						
						echo '
					<tr>
						<td><input type="checkbox" name="muid['.$b2['mid'].']" value="'.$b2['mid'].'" checked /></td>
						<td><input type="number" min="1" name="msay['.$b2['mid'].']" value="'.$b2['uc'].'" /></td>
						<td>'.$b2['mid'].'</td>
						<td>'.$b2['mname'].'</td>						
						<td></td>						
					</tr>';
					}
					echo count($mid);
					if(count($mid)>0)
					{
						$midstr=' and
							m.u_id not in ('.implode(',',$mid).')';
					}
					else
					{
						$midstr='';
					}
					$sql3=$db->prepare('select 
							`m`.`name` mname,
							`m`.u_id mid
						from  
							mehsul m 
						where 
							m.l_id=1 '.$midstr.' order by u_id asc');
					$sql3->execute();
					$mid=array();
					while($b3=$sql3->fetch(PDO::FETCH_ASSOC))
					{						
						echo '
					<tr>
						<td><input type="checkbox" name="muid[]" value="'.$b3['mid'].'"/></td>
						<td><input type="number" min="1" name="msay['.$b3['mid'].']" value="1" /></td>
						<td>'.$b3['mid'].'</td>
						<td>'.$b3['mname'].'</td>						
						<td></td>						
					</tr>';
					}
					?>
				</tbody>
			</table>
		  <div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
			  <button type="submit" class="btn btn-success" name="send" value="1">Submit</button>
			</div>
		  </div>

		</form>
	  </div>
	</div>
  </div>
</div>
<?PHP
	}
?>
<style>
input[type='number']::-webkit-inner-spin-button, 
input[type='number']::-webkit-outer-spin-button { 
    opacity: 1;
}
input[type='number']
{
	width: 60px;
    text-align: center;
}
</style>