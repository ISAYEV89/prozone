<?PHP
	if($_POST['send'])
	{
				
		$name		= $_POST['name'];
		$say		= $_POST['count'];
		
		
		$sql=$db->prepare('INSERT INTO stock_rp set `date`=now(), `name`=:name , `say`=:say');

		$sql->execute(array('name'=>"$name" , 'say'=>"$say" ));
		
		$id = $db->lastInsertId(); 
		echo "<br><br><center><b><font size='4' color='red'>Ready Product added to Database</font></b></center></br><br>
		<script>
		function redi(){
		document.location='$site_url/stock/addrp2/$id/'
		}
		setTimeout(\"redi()\", 3000);
		</script>";
	}
	else {
		?>
		 
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add ready product <!--small>different form elements</small --></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form  name="form1" method="post" action="" class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="barcode" name="name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Count</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="count">
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