<?PHP
	$id = $_GET['val'];
	if($_POST['send'])
	{
			
		$name= $_POST['name'];
		$barcode= $_POST['barcode'];
					
		$sql=$db->prepare('update `stock` set `ad`=:ad, `code`=:code where id=:id');

		$sql->execute(array('ad'=>"$name" , 'code'=>"$barcode", 'id'=>"$id" ));


		if($sql){
			echo "<br><br><center><b><font size='4' color='red'> Product Succesfully updated </font></b></center></br><br>
			<script>
			function redi(){
			document.location='$site_url/stock/list/'
			}
			setTimeout(\"redi()\", 3000);
			</script>"; 
		}
		
	}
	else {

	$sql=$db->prepare('SELECT * FROM stock WHERE id=:id');
	$sql->execute(ARRAY('id'=>"$id"));
		
	$b=$sql->fetch(PDO::FETCH_ASSOC);
	?>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h2>Edit Stock Item <!--small>different form elements</small --></h2>
		<div class="clearfix"></div>
	  </div>
	  <div class="x_content">
		<br />
		<form  name="form1" method="post" action="" class="form-horizontal form-label-left">

		  <div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Name <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" id="barcode" name="name" required="required" class="form-control col-md-7 col-xs-12"  value="<?PHP echo $b['ad']; ?>">
			</div>
		  </div>
		  <div class="form-group">
			<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Product Code</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="barcode"  value="<?PHP echo $b['code']; ?>">
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