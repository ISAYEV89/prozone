<?PHP

	//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	$id = $_GET['val'];
	if($_POST['send'])
	{
		
		$prcode=$_POST['barcode'];
		$prsay=$_POST['count'];
		$prvalue=$_POST['price'];
					
		$itemvalue=round($prvalue/$prsay , 2); 	//1 ededin qiymeti tapilir
		
		$sql=$db->prepare('SELECT spp.*, s.ad FROM stock_par_prod spp, stock s WHERE spp.id=:id and spp.pr_id=s.id');
		$sql->execute(ARRAY('id'=>"$id"));
			
		$b=$sql->fetch(PDO::FETCH_ASSOC);


		
		$sql=$db->prepare('update stock_par_prod set barcode=:prcode, say=:prsay, price_alis=:prvalue, price_alis_unit=:itemvalue where id=:id');
		$sql->execute(ARRAY('id'=>"$id", 'prcode'=>"$prcode",'prsay'=>"$prsay",'prvalue'=>"$prvalue",'itemvalue'=>"$itemvalue"));
		
		
		
		$fl=$_SESSION['flogin_id'];
		$prid=$b['pr_id'];
		$spp_id=$b['id'];
		$sql=$db->prepare('insert into stock_log (p_id, say, type, src, price_buy, src_id, s_id, a_id) values (:prid, :prsay, 3, 1, :prvalue, :spp_id, 1, :a_id)');
		$sql->execute(ARRAY('spp_id'=>"$spp_id",'prid'=>"$prid",'prsay'=>"$prsay",'prvalue'=>"$prvalue" , 'a_id'=>"$fl"));
		
		//*******Updating count in stock table***********************************
		$diff=($prsay-$b['say']);
		$sql=$db->prepare('update stock set say = say + :say where id= :id');
		$sql->execute(ARRAY('id'=>"$prid",'say'=>"$diff"));
		//***********************************************************************
		//qiymetler cemlenib stock_partiyaya update edilir
		//$sql=MYSQLI_FETCH_ASSOC(MYSQLI_QUERY($connection, 'select sum(price_alis) as cem from stock_par_prod where p_id="'.$id.'"' ));
		
		$pid=$b['p_id'];
		$sql=$db->prepare('select sum(price_alis) as cem from stock_par_prod where p_id=:id');
		$sql->execute(ARRAY('id'=>"$pid"));
		$b=$sql->fetch(PDO::FETCH_ASSOC);
		$cem=$b['cem'];
		'<br>';
		$sql=$db->prepare('update stock_partiya set price_alis= :cem , price=expence+ :cem2 where id= :id limit 1 ');
		$sql->execute(ARRAY('id'=>"$id",'cem'=>"$cem", 'cem2'=>"$cem"));
		
		//****************************************************
		
		//price net hesablanir
		//$sql=MYSQLI_FETCH_ASSOC(MYSQLI_QUERY($connection, 'select expence  from stock_partiya where id="'.$id.'" limit 1' ));
		$sql=$db->prepare('select `expence`  from stock_partiya where id=:id limit 1');
		$sql->execute(ARRAY('id'=>"$pid"));
		$b=$sql->fetch(PDO::FETCH_ASSOC);
		
		$exp=$b['expence'];
		
		//$sql=MYSQLI_QUERY($connection,'select * from stock_par_prod where p_id="'.$id.'"');
		$sql=$db->prepare('select * from stock_par_prod where p_id= :id');
		$sql->execute(ARRAY('id'=>"$pid"));
		while($b=$sql->fetch(PDO::FETCH_ASSOC))
		{
			$bid=$b['id'];
			$price_net=$b['price_alis']+ round($b['price_alis']/$cem*$exp , 2);
			$pnu=round($price_net/$b['say'],2);
			//MYSQLI_QUERY($connection,' update stock_par_prod set price_net="'.$price_net.'" , price_net_unit="'.$pnu.'" where id="'.$b['id'].'" limit 1');
			$sql2=$db->prepare('update stock_par_prod set price_net= :price_net , price_net_unit= :pnu where id= :id limit 1');
			$sql2->execute(ARRAY('id'=>"$bid",'price_net'=>"$price_net",'pnu'=>"$pnu"));
		}

		if($sql){
			echo "<br><br><center><b><font size='4' color='red'> Product Succesfully updated </font></b></center></br><br>
			<script>
			function redi(){
			document.location='$site_url/stock/adddelivery2/$pid/'
			}
			setTimeout(\"redi()\", 3000);
			</script>"; 
		}
		
	}
	else {

	$sql=$db->prepare('SELECT spp.*, s.ad FROM stock_par_prod spp, stock s WHERE spp.id=:id and spp.pr_id=s.id');
	$sql->execute(ARRAY('id'=>"$id"));
		
	$b=$sql->fetch(PDO::FETCH_ASSOC);
	//print_r($b);
	?>

<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Edit Delivery Product <small><?PHP echo $b['ad'];?></small></h2>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
		<br />
		<form  name="form1" method="post" action="" class="form-horizontal form-label-left">

		  <div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Delivery code <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" id="barcode" name="barcode" value="<?PHP echo $b['barcode'];?>" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		  </div>
		  <div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Count <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" name="count" required="required" value="<?PHP echo $b['say'];?>" class="form-control col-md-7 col-xs-12">
			</div>
		  </div>
		  <div class="form-group">
			<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Import Price</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="price" value="<?PHP echo $b['price_alis'];?>">
			</div>
		  </div>
		  
		  <div class="ln_solid"></div>
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