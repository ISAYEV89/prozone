
<?PHP
		//echo'<pre>';
		//print_r($_SESSION);
		//echo'</pre>';
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	$id=$_GET['val'];
	if(@$_POST['pradd'])
	{
		
		$prid=$_POST['prid'];
		$td=explode('|',$prid);
		
		$sppid=$td[1];
		$spid=$td[0];
		
		$prsay=$_POST['prsay'];
		
		$sql=$db->prepare('select * from stock_par_prod where id=:id limit 1');
		$sql->execute(ARRAY('id'=>"$sppid"));
		$b=$sql->fetch(PDO::FETCH_ASSOC);
		$prid=$b['pr_id'];
		$pid=$b['p_id'];
		$pnu=$b['price_net_unit'];
		$psu=$b['price_sale_unit'];
		
		$sql=$db->prepare('INSERT INTO `stock_rp_prod` 
		(`id`, `rp_id`, `spp_id`, `pr_id`, `p_id`, `pnu`, `psu`, `say`, `s_id`) VALUES 
		(NULL, :id, :sppid, :prid, :pid, :pnu, :psu, :prsay, "1")');
		$sql->execute(ARRAY('id'=>"$id",'prid'=>"$prid",'sppid'=>"$sppid",'pid'=>"$pid",'pnu'=>"$pnu",'psu'=>"$psu",'prsay'=>"$prsay"));
		
		$srp_id= $db->lastInsertId();
		
		//*******Updating count in stock table***********************************
		$sql=$db->prepare('update stock set say = say - :say where id= :id');
		$sql->execute(ARRAY('id'=>"$prid",'say'=>"$prsay"));
		//***********************************************************************		
		
		//*******Updating stock_rp prices update ***********************************
		$pn=$pnu*$prsay;
		$ps=$psu*$prsay;
		$sql=$db->prepare('update stock_rp set price =price+ :pn , price_sale_stock= price_sale_stock + :ps where id= :id');
		$sql->execute(ARRAY('id'=>"$id",'pn'=>"$pn", 'ps'=>"$ps"));
		//***********************************************************************
		
		//*******Updating stock_par_prod for say ***********************************
		$pn=$pnu*$prsay;
		$ps=$psu*$prsay;
		$sql=$db->prepare('update stock_par_prod set say =say - :say where id= :id');
		$sql->execute(ARRAY('id'=>"$sppid",'say'=>"$prsay"));
		//***********************************************************************	
		
		//*******inserting to stock_log ***********************************
		$fl=$_SESSION['flogin_id'];
		$sql=$db->prepare('insert into stock_log (p_id, say, type, src, price_buy, src_id, s_id, a_id) values (:prid, :prsay, 4, 2, :prvalue, :spp_id, 1, :a_id)');
		$sql->execute(ARRAY('spp_id'=>"$srp_id",'prid'=>"$prid",'prsay'=>"$prsay",'prvalue'=>"$ps" , 'a_id'=>"$fl"));
		//***********************************************************************	
		
		
		echo "<br><br><center><b><font size='4' color='red'>Ready product updated</font></b></center></br><br>
		<script>
		function redi(){
		document.location='$site_url/stock/addrp2/$id/'
		}
		setTimeout(\"redi()\", 3000);
		</script>";
	}
	if(@$_POST['final'])
	{
		$sql=$db->prepare('update stock_rp set s_id =10 where id= :id');
		$sql->execute(ARRAY('id'=>"$id"));
		
		$sql=$db->prepare('update stock_rp_prod set s_id = 10 where rp_id= :id');
		$sql->execute(ARRAY('id'=>"$id"));
		echo "<br><br><center><b><font size='4' color='red'>Ready product Finalized</font></b></center></br><br>
		<script>
		function redi(){
		document.location='$site_url/stock/addrp2/$id/'
		}
		setTimeout(\"redi()\", 3000);
		</script>";
	}
	
	
	$sql=$db->prepare('select * from stock_rp where id=:id limit 1');
	$sql->execute(ARRAY('id'=>"$id"));
	$b=$sql->fetch(PDO::FETCH_ASSOC);
	$s_id=$b['s_id'];
?>

<link rel="stylesheet" href="<?PHP echo $site_url;?>css/select2.min.css" />



<form name="form1" method="post" action="">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Item list of ready Product  - <?PHP echo $b['name'];?></h2>
		
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">

		<table class="table table-bordered">
		  <thead>
			<tr>
				<th><b>id</b></th>
				<th><b>name and product code</th>
				<th><b>delivery code</th>
				<th><b>count</th>
				<th><b>net price per unit</th>
				<th><b>sale price per unit</th>
				<th><b>status</th>
				<th><b>action</th>
			</tr>
		  </thead>
		  <tbody>
			<?PHP
					$sql=$db->prepare('select srpp.* , s.ad prad, s.code prcode, sp.barcode spcode from  stock s, stock_rp_prod srpp, stock_partiya sp where 
					srpp.pr_id=s.id and srpp.p_id = sp.id and srpp.rp_id=:id and (srpp.s_id=1 or srpp.s_id=10) order by srpp.id asc');
					$sql->execute(ARRAY('id'=>"$id"));
					
					$pnu=0;
					$psu=0;
					while($b=$sql->fetch(PDO::FETCH_ASSOC))
					{
						echo '
							<tr>
								<th><b>'.$b['id'].'</b></th>
								<td>'.$b['prad'].' - '.$b['prcode'].'</td>
								<td>'.$b['spcode'].'</td>
								<td>'.$b['say'].' pieces</td>
								<td>'.$b['pnu'].' $USD</td>
								<td>'.$b['psu'].' $USD</td>
								<td>'.$b['s_id'].'</td>
								<td>'.(($b['s_id']==1)?'<a href="'.$site_url.'stock/deleterpprod/'.$b['id'].'/" onclick="return setconfirm()"><i class="fa fa-close"></i></a>':"").'</td>
							</tr>
						';
						$pnu+=$b['pnu'];
						$psu+=$b['psu'];
					}
					$profit=$psu-$pnu;
					echo '
							<tr>
								<th colspan="4"><b>Total:</b></th>
								
								<td><b>'.$pnu.' $USD</b></td>
								<td><b>'.$psu.' $USD</b></td>
								<td colspan="2"><b> Profit: '.$profit.' $USD</b></td>
							</tr>
						';
					
				?>
		  </tbody>
		</table>		
		
	  </div>
	</div>
  </div>
</form>
<?PHP if($s_id==0)
{?>
<form  name="form3" method="post" action="">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Add item to ready product </h2>
		
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">

		<table class="table table-bordered">
		  <thead>
			<tr>
				<th><b>Product name and code</th>
				<th><b>Count</th>
				<th><b>action</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
				<td>
					<select name="prid" id="prid">
						<?PHP
							//$sql=MYSQLI_QUERY($connection,' select * from stock where s_id=0 order by id asc');
							$sql=$db->prepare('select * from stock_partiya where s_id=10 order by id DESC');
							$sql->execute();
							
							while($b=$sql->fetch(PDO::FETCH_ASSOC))
							{
								echo $pid=$b['id'];
								echo'<optgroup label="'.$b['barcode'].'">';
								
								$sql2=$db->prepare('select spp.*, s.ad, s.code from stock_par_prod spp, stock s where spp.s_id=10 and spp.p_id= :pid and spp.pr_id=s.id order by spp.id DESC');
								$sql2->execute(array('pid'=>"$pid"));
								
								while($b2=$sql2->fetch(PDO::FETCH_ASSOC))
								{
									echo'<option value="'.$pid.'|'.$b2['id'].'">'.$b2['ad'].' - '.$b2['code'].'('.$b2['say'].' pieces)</option>';
								}
								
								echo'</optgroup>';
							}
						?>
					</select>
				</td>
				<td>
					<input type="text" name="prsay" placeholder="0">
				</td>
				<td>
					<input type="submit" value="add product" name="pradd">
				</td>
			</tr>
		  </tbody>
		</table>		
		
	  </div>
	</div>
  </div>
</form>
<form name="form4" action="" method="post">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Finalize the Ready Product </h2>
		
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">

		<table class="table table-bordered">
		  
		  <tbody>
			<tr>
				<td style="text-align: center;">					
					<input type="submit" value="Finalize" name="final">
				</td>
			</tr>
		  </tbody>
		</table>		
		
	  </div>
	</div>
  </div>
</form>
<?PHP 
}?>
<script>
function setconfirm()
{
	return confirm('are you sure to delete this product from list?');
}
</script>
		
