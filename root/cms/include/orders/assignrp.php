<?PHP

	//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	$id = $_GET['val'];
	if($_POST['send'])
	{
		
		echo '<pre>';
		print_r($_POST); 
		echo'</pre>';
		
		$sql=$db->prepare('SELECT op.* , m.name FROM order_prod op, mehsul m WHERE op.o_id=:id and op.p_id=m.u_id and m.l_id=1');
		$sql->execute(ARRAY('id'=>"$id"));
		
		$succ=0;
		$err=0;
		while($b=$sql->fetch(PDO::FETCH_ASSOC))// getting products info 
		{
			$d=0;
			while($d<$b['say'])//generating tables with the amount of products in it
			{
				$pid=$b['p_id'];				
				$d++;
				$sql2=$db->prepare('SELECT srpm.*, srp.name, srp.md5 FROM stock_rp_mehsul srpm, stock_rp srp WHERE srpm.m_uid=:id and srpm.srp_id=srp.id');
				$sql2->execute(ARRAY('id'=>"$pid"));
				
				while($b2=$sql2->fetch(PDO::FETCH_ASSOC))
				{
					$d2=0;
					while($d2<$b2['unit_count'])
					{
						$d2++;
						$inpname=$pid.'x'.$d.'x'.$b2['srp_id'].'x'.$d2;
						if(@$_POST[$inpname] and $_POST[$inpname]==$b2['md5'])
						{
							$succ+=1;
						}
						else
						{
							$err+=1;
						}
					}
				}
			} 
		}
		
		if($err>0)
		{
			echo "<br><br><center><b><font size='4' color='red'> Error in Data. one of the products is missing or wrong data </font></b></center></br><br>
			<script>
			function redi(){
			document.location='".$site_url."orders/assignrp/$id/'
			}
			setTimeout(\"redi()\", 3000);
			</script>";
		}
		else
		{
			$sql5=$db->prepare('update orders set ds_id=5 where id=:id');
			$sql5->execute(ARRAY('id'=>"$id"));
			
			$sql6=$db->prepare('update order_stock_rp set s_id=2 , date_update=now() where o_id=:id');
			$sql6->execute(ARRAY('id'=>"$id"));
			
			echo "<br><br><center><b><font size='4' color='red'> Operation successfull </font></b></center></br><br>
			<script>
			function redi(){
			document.location='".$site_url."orders/list/'
			}
			setTimeout(\"redi()\", 3000);
			</script>"; 
		}
		
		
		
	}
	else {

	$sql=$db->prepare('SELECT spp.* FROM orders spp WHERE spp.id=:id');
	$sql->execute(ARRAY('id'=>"$id"));
		
	$b=$sql->fetch(PDO::FETCH_ASSOC);
	//print_r($b);
	
	$blogquer=$db->prepare('
	SELECT 
		o.*, u.login, u.serial ,cc.name as cname, c.name ccity, cr.NAME curn, GROUP_CONCAT(m.name separator "<br>") mehsul, sum(m.point) mpoint 
		
	FROM 
		`orders` o, user u , olkeler c,
		(select kat_id, name from olkeler where l_id=1 and sub_id=0) cc,
		currency_rates cr,
		mehsul m,
		order_prod op

	where 
		o.bask_user_id=u.id  and o.bask_city=c.kat_id and c.l_id=1 and o.bask_country=cc.kat_id and bask_currency=cr.id
		and o.id=op.o_id and op.p_id= m.u_id and o.bask_s_id=2 and m.l_id=1 and o.id="'.$id.'"

	Group by o.id
	limit 1 ');

	$blogquer->execute();
	
	$b2=$blogquer->fetch(PDO::FETCH_ASSOC);
	?>

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Assign products from stock to order NO - <?PHP echo $b['id'];?></h2>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
		<br />
		<form  name="form1" method="post" action="" class="form-horizontal form-label-left">
			<table id="datatable" class="table table-striped table-bordered" style="font-size:11px;">
				<thead>
				  <tr>
					<th>ID</th>
					<th>Date</th>
					<th>Name and Login</th>
					<th>Address</th>
					<th>Contacts</th>
					<th>Price</th>
					<th>Products</th>
					<th>Point</th>
				  </tr> 
				</thead>
				<tbody>
					<tr id="tr<?PHP echo $b2['id'] ?>">
						<td><?php echo $b2['id'] ?></td>
						<td><?php echo $b2['bask_orddate'] ?></td> 
						<td>
							<span class="labelnm">full name:</span><span class="infoholder"><?php echo $b2['bask_fname'].' '.$b2['bask_lname']; ?></span><br>
							<span class="labelnm">Login:</span><span class="infoholder"><?php echo $b2['login']; ?></span><br>
							<span class="labelnm">Serial:</span><span class="infoholder"><?php echo $b2['serial']; ?></span><br>
						</td>
						<td>
							<span class="labeld">Address:</span><span class="infoholder"><?php echo $b2['bask_adress']; ?></span><br>
							<span class="labeld">Zip code:</span><span class="infoholder"><?php echo $b2['bask_zip']; ?></span><br>
							<span class="labeld">Country:</span><span class="infoholder"><?php echo $b2['cname']; ?></span><br>
							<span class="labeld">City:</span><span class="infoholder"><?php echo $b2['ccity']; ?></span><br>
							<span class="labeld">State:</span><span class="infoholder"><?php echo $b2['bask_zip']; ?></span><br>			
						</td>
						<td>
							<span class="labelc">e-Mail:</span><span class="infoholder"><?php echo $b2['bask_mail']; ?></span><br>
							<span class="labelc">Phone:</span><span class="infoholder"><?php echo $b2['bask_tel']; ?></span><br>
							<span class="labelc">Mobile:</span><span class="infoholder"><?php echo $b2['bask_mob']; ?></span><br>
						</td>
						<td>
							<span class="labelx"><?php echo $b2['basket_total']; ?></span><span class="infoholder"><?php echo $b2['curn']; ?></span><br>
						</td>
						<td>              
							<?php echo $b2['mehsul']; ?>
						</td>
						<td>              
							<?php echo $b2['mpoint']; ?>
						</td>
					</tr>
				</tbody>
			</table>
			<?PHP
			$sql=$db->prepare('SELECT op.* , m.name FROM order_prod op, mehsul m WHERE op.o_id=:id and op.p_id=m.u_id and m.l_id=1');
			$sql->execute(ARRAY('id'=>"$id"));
		
			while($b=$sql->fetch(PDO::FETCH_ASSOC))// getting products info 
			{
				$d=0;
				while($d<$b['say'])//generating tables with the amount of products in it
				{
					$pid=$b['p_id'];
					$sql2=$db->prepare('SELECT srpm.*, srp.name, srp.md5 FROM stock_rp_mehsul srpm, stock_rp srp WHERE srpm.m_uid=:id and srpm.srp_id=srp.id');
					$sql2->execute(ARRAY('id'=>"$pid"));
					$d++;
					echo'
					<table  class="table table-striped table-bordered" style="font-size:11px;">
						<tr><td><h5>'.$b['name'].'</h5></td></tr>';
					while($b2=$sql2->fetch(PDO::FETCH_ASSOC))
					{
						echo'
						<tr>
							<td>';
							$d2=0;
							while($d2<$b2['unit_count'])
							{
								$d2++;
								$inpname=$pid.'x'.$d.'x'.$b2['srp_id'].'x'.$d2;
								echo'
								<div class="form-group">
									<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">'.$b2['name'].'</label>
									<div class="col-md-2 col-sm-2 col-xs-2">
										<input id="middle-name" class="form-control col-md-2 col-xs-2 target" type="text" name="'.$inpname.'" data-value="'.$b2['md5'].'">
									</div>
								</div>
								';
							}
								
						echo'
							</td>
						</tr>';
					}
					
					echo'
					</table>';
				} 
			}
			
			?>
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