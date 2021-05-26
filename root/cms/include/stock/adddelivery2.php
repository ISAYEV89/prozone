
<?PHP
		//echo'<pre>';
		//print_r($_SESSION);
		//echo'</pre>';
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	$id=$_GET['val'];
	if(@$_POST['pradd'])
	{
		
		$prid=$_POST['prid'];
		$prcode=$_POST['prcode'];
		$prsay=$_POST['prsay'];
		$prvalue=$_POST['prvalue'];
		
		$sql=$db->prepare('select count(id) say from stock_par_prod where p_id=:id and pr_id=:prid');
		$sql->execute(ARRAY('id'=>"$id",'prid'=>"$prid"));
		$b=$sql->fetch(PDO::FETCH_ASSOC);
		if($b['say']>0)
		{
			echo "<br><br><center><b><font size='4' color='red'> This item is already on the list! </font></b></center></br><br>
				<script>
				function redi(){
				document.location='$site_url/stock/adddelivery2/$id/'
				}
				setTimeout(\"redi()\", 3000);
				</script>";
		}
		else
		{
			$itemvalue=round($prvalue/$prsay , 2); 	//1 ededin qiymeti tapilir
			
			$sql=$db->prepare('insert into stock_par_prod (p_id,pr_id,barcode,say,price_alis, price_alis_unit) values (:id, :prid, :prcode, :prsay, :prvalue, :itemvalue)');
			$sql->execute(ARRAY('id'=>"$id",'prid'=>"$prid",'prcode'=>"$prcode",'prsay'=>"$prsay",'prvalue'=>"$prvalue",'itemvalue'=>"$itemvalue"));
			
			$spp_id= $db->lastInsertId();  //stock partiya produkta insert ID-SI TAPILIR
			
			echo $fl=$_SESSION['flogin_id'];
			$sql=$db->prepare('insert into stock_log (p_id, say, type, src, price_buy, src_id, s_id, a_id) values (:prid, :prsay, 1, 1, :prvalue, :spp_id, 1, :a_id)');
			$sql->execute(ARRAY('spp_id'=>"$spp_id",'prid'=>"$prid",'prsay'=>"$prsay",'prvalue'=>"$prvalue" , 'a_id'=>"$fl"));
			
			//*******Updating count in stock table***********************************
			$sql=$db->prepare('update stock set say = say + :say where id= :id');
			$sql->execute(ARRAY('id'=>"$prid",'say'=>"$prsay"));
			//***********************************************************************
			//qiymetler cemlenib stock_partiyaya update edilir
			//$sql=MYSQLI_FETCH_ASSOC(MYSQLI_QUERY($connection, 'select sum(price_alis) as cem from stock_par_prod where p_id="'.$id.'"' ));
			
			$sql=$db->prepare('select sum(price_alis) as cem from stock_par_prod where p_id=:id');
			$sql->execute(ARRAY('id'=>"$id"));
			$b=$sql->fetch(PDO::FETCH_ASSOC);
			$cem=$b['cem'];
			'<br>';
			$sql=$db->prepare('update stock_partiya set price_alis= :cem , price=expence+ :cem2 where id= :id limit 1 ');
			$sql->execute(ARRAY('id'=>"$id",'cem'=>"$cem", 'cem2'=>"$cem"));
			
			//****************************************************
			
			//price net hesablanir
			//$sql=MYSQLI_FETCH_ASSOC(MYSQLI_QUERY($connection, 'select expence  from stock_partiya where id="'.$id.'" limit 1' ));
			$sql=$db->prepare('select `expence`  from stock_partiya where id=:id limit 1');
			$sql->execute(ARRAY('id'=>"$id"));
			$b=$sql->fetch(PDO::FETCH_ASSOC);
			
			$exp=$b['expence'];
			
			//$sql=MYSQLI_QUERY($connection,'select * from stock_par_prod where p_id="'.$id.'"');
			$sql=$db->prepare('select * from stock_par_prod where p_id= :id');
			$sql->execute(ARRAY('id'=>"$id"));
			while($b=$sql->fetch(PDO::FETCH_ASSOC))
			{
				$bid=$b['id'];
				$price_net=$b['price_alis']+ round($b['price_alis']/$cem*$exp , 2);
				$pnu=round($price_net/$b['say'],2);
				//MYSQLI_QUERY($connection,' update stock_par_prod set price_net="'.$price_net.'" , price_net_unit="'.$pnu.'" where id="'.$b['id'].'" limit 1');
				$sql2=$db->prepare('update stock_par_prod set price_net= :price_net , price_net_unit= :pnu where id= :id limit 1');
				$sql2->execute(ARRAY('id'=>"$bid",'price_net'=>"$price_net",'pnu'=>"$pnu"));
			}
			
		}
	}
	
	if(@$_POST['exp_upd'])
	{
		$exp=$_POST['expence'];
		$sql=$db->prepare('update stock_partiya set expence=:exp , price=price_alis+:exp where id=:id limit 1');
		$sql->execute(ARRAY('id'=>"$id",'exp'=>"$exp"));
		//price net hesablanir
		
		$sql=$db->prepare('select expence, price_alis from stock_partiya where id=:id limit 1');
		$sql->execute(ARRAY('id'=>"$id"));
		$a=$sql->fetch(PDO::FETCH_ASSOC);
		
		$exp=$a['expence'];
		$cem=$a['price_alis'];
		
		$sql=$db->prepare('select * from stock_par_prod where p_id=:id');
		$sql->execute(ARRAY('id'=>"$id"));
		while($b=$sql->fetch(PDO::FETCH_ASSOC))
		{
			$price_net=$b['price_alis']+ round($b['price_alis']/$cem*$exp , 2);
			$pnu=round($price_net/$b['say'],2);
			$xid=$b['id'];
			$sql2=$db->prepare('update stock_par_prod set price_net=:price_net , price_net_unit=:pnu where id=:id limit 1');
			$sql2->execute(ARRAY('id'=>"$xid",'pnu'=>"$pnu",'price_net'=>"$price_net"));
		}
		
	}
	
	if(@$_POST['inc_upd'])
	{
		$exp=$_POST['income'];
		$sql=$db->prepare('update stock_partiya set income=:exp , sale_price=price+price * :exp / 100 where id=:id limit 1');
		$sql->execute(ARRAY('id'=>"$id",'exp'=>"$exp"));
		
		//price sale hesablanir
		
				
		$sql=$db->prepare('select * from stock_par_prod where p_id=:id');
		$sql->execute(ARRAY('id'=>"$id"));
		while($b=$sql->fetch(PDO::FETCH_ASSOC))
		{
			$price_sale=$b['price_net'] + round($b['price_net']*$exp / 100 , 2);
			$psu=round($price_sale/$b['say'],2);
			$xid=$b['id'];
			$sql2=$db->prepare('update stock_par_prod set price_sale=:price_net , price_sale_unit=:pnu where id=:id limit 1');
			$sql2->execute(ARRAY('id'=>"$xid",'pnu'=>"$psu",'price_net'=>"$price_sale"));
		}
		
	}
	
	if(@$_POST['final'])
	{
		$sql=$db->prepare('update stock_partiya set s_id=10 where id=:id limit 1');
		$sql->execute(ARRAY('id'=>"$id"));
		
		//price sale hesablanir
		
		
		$sql2=$db->prepare('update stock_par_prod set s_id=10 where p_id=:id');
		$sql2->execute(ARRAY('id'=>"$id"));
		
	}
	$sql=$db->prepare('select * from stock_partiya where id=:id limit 1');
	$sql->execute(ARRAY('id'=>"$id"));
	$b=$sql->fetch(PDO::FETCH_ASSOC);
	
	
	$parstatus=$b['s_id'];
	if($b['expence']>0)
	{
		$exp=$b['expence'];
	}
	else
	{
		$exp=0;
	}
?>

<link rel="stylesheet" href="<?PHP echo $site_url;?>css/select2.min.css" />

<div class="col-md-10 col-sm-10 col-xs-10">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Delivery details: </h2>
		
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">

		<table class="table table-bordered">
		  <thead>
			<tr>
			  <th>Delivery Name: </th>
			  <td><?PHP echo $b['barcode']; ?></td>
			  <th>Import Price: </th>
			  <td><?PHP echo $b['price_alis']; ?> USD</td>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th scope="row">Delivery Date:</th>
			  <td><?PHP echo $b['date']; ?></td>
			  <th>Total Expences(USD):</th>
			  <td><?PHP echo $exp; ?> USD</td>
			  
			</tr>
			<tr>
			  <th scope="row">Comments: </th>
			  <td><?PHP echo $b['comment']; ?></td><th>Net Price: </th>
			  <td><?PHP echo $b['price']; ?> USD</td>
			</tr>
			<tr>
			  <th scope="row">Income(%): </th>
			  <td><?PHP echo $b['income']; ?> %</td><th>Sale Price: </th>
			  <td><?PHP echo $b['sale_price']; ?> USD</td>
			</tr>
		  </tbody>
		</table>		
		<div class="clearfix"></div>
		<?PHP 
		if($b['s_id']!=10)
		{
		?>
		
		<form name="form2" method="post" action="">
			<div class="form-group" >
				<label for="expence" class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align:right;">Update Expence (USD):</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="expence" style="
		float: left;
		width: 75px;
		margin-right: 10px;
	">
				  <button type="submit" class="btn btn-success" name="exp_upd" value="1">Update</button>
				</div>
			  </div>
		</form>
		<div class="clearfix"></div>
		
		<form name="form2" method="post" action="">
			<div class="form-group" >
				<label for="expence" class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align:right;">Update Income (%):</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="income" style="
		float: left;
		width: 75px;
		margin-right: 10px;
	">
				  <button type="submit" class="btn btn-success" name="inc_upd" value="1">Update</button>
				</div>
			  </div>
		</form>
		
		<form name="form2" method="post" action="">
			<div class="form-group" >
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <button type="submit" class="btn btn-success" name="final" value="1" style="float:right; margin-right: 68px;">Finalize Delivery</button>
				</div>
			  </div>
		</form>
		<?PHP
		}
		?>
	  </div>
	</div>
  </div>

<form name="form1" method="post" action="">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Product list of delivery </h2>
		
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
				<th><b>import price</th>
				<th><b>net price</th>
				<th><b>sale price</th>
				<th><b>import price per unit</th>
				<th><b>net price per unit</th>
				<th><b>sale price per unit</th>
				<th><b>status</th>
				<th><b>action</th>
			</tr>
		  </thead>
		  <tbody>
			<?PHP
					$sql=$db->prepare('select spp.* , s.ad prad, s.code prcode from stock_par_prod spp , stock s where spp.p_id=:id and spp.pr_id = s.id order by spp.id asc');
					$sql->execute(ARRAY('id'=>"$id"));
					
					$imp=0;
					$nep=0;
					$sale=0;
					while($b=$sql->fetch(PDO::FETCH_ASSOC))
					{
						echo '
							<tr>
								<th><b>'.$b['id'].'</b></th>
								<td>'.$b['prad'].' - '.$b['prcode'].'</td>
								<td>'.$b['barcode'].'</td>
								<td>'.$b['say'].' pieces</td>
								<td>'.$b['price_alis'].' $USD</td>
								<td>'.$b['price_net'].' $USD</td>
								<td>'.$b['price_sale'].' $USD</td>
								<td>'.$b['price_alis_unit'].' $USD</td>
								<td>'.$b['price_net_unit'].' $USD</td>
								<td>'.$b['price_sale_unit'].' $USD</td>
								<td>'.$b['s_id'].'</td>
								<td>'.(($parstatus!=10)?'<a href="'.$site_url.'stock/editdeliveryproduct/'.$b['id'].'/"><i class="fa fa-pencil"></i></a>':'').'</td>
							</tr>
						';
						$imp+=$b['price_alis'];
						$nep+=$b['price_net'];
						$sale+=$b['price_sale'];
					}
					
				?>
				<tr>
					<td colspan=4><b>Total:</b></td>
					<td><b><?PHP echo $imp;?> $USD</td>
					<td><b><?PHP echo $nep;?> $USD</td>
					<td><b><?PHP echo $sale;?> $USD</td>
					<td colspan=5></td>
				</tr>
		  </tbody>
		</table>		
		
	  </div>
	</div>
  </div>
</form>
<?PHP
if($parstatus!=10)
{
?>
<form  name="form3" method="post" action="">
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Add product to delivery </h2>
		
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">

		<table class="table table-bordered">
		  <thead>
			<tr>
				<th><b>Product name and code</th>
				<th><b>Delivery code</th>
				<th><b>Count</th>
				<th><b>import price in $USD</th>
				<th><b>action</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
				<td>
					<select name="prid" id="prid">
						<?PHP
							//$sql=MYSQLI_QUERY($connection,' select * from stock where s_id=0 order by id asc');
							$sql=$db->prepare('select * from stock where s_id=0 order by id asc');
							$sql->execute();
							
							while($b=$sql->fetch(PDO::FETCH_ASSOC))
							{
								echo'<option value="'.$b['id'].'">'.$b['ad'].' - '.$b['code'].'</option>';
							}
						?>
					</select>
				</td>
				<td>
					<input type="text" name="prcode" placeholder="0">
				</td>
				<td>
					<input type="text" name="prsay" placeholder="0">
				</td>
				<td>
					<input type="text" name="prvalue" placeholder="add import price"> $USD
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
<?PHP
}
?>
		
