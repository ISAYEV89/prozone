<?php 

$catquer=$db->prepare('SELECT name, u_id FROM mehsul where l_id="1" and s_id="1" ');

$catquer->execute();


?>



<div class="row">

  <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">

      <div class="x_title">

        <h2>Add product discount </h2>

        <div class="clearfix"></div>

      </div>

      <div class="x_content">   

        <form method="POST" action="<?PHP echo $site_url.'discount/addpreview/'?>" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">   

          <div class="w3-container">

           
          </div>       

      



          <div class="form-group" id="allcount"  >

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Product</label>

            <div class="col-md-9 col-sm-9 col-xs-12">

              <select id="allcounts" onchange="getproductPrice(this)" name="product" required style="width: 600px; border-radius:5px; margin:10px 0;" data-plugin-selectTwo class="form-control populate">
				<option>---</option>
                <?php

                while($catquerft=$catquer->fetch(PDO::FETCH_ASSOC))

                {
                   
                ?>

                  <option value="<?php echo $catquerft['u_id'] ?>" ><?php echo $catquerft['name'] ?></option>

                <?php

                }

                ?>

              </select>

            </div>

          </div>



          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Start time</label>

            <div class="col-md-9 col-sm-9 col-xs-12">

              <input type="text" name="sd" required id="start_d" style="width: 300px; border-radius:5px; margin:10px 0;">

            </div>

          </div>

          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select End time</label>

            <div class="col-md-9 col-sm-9 col-xs-12">

              <input type="text" name="ed" required id="end_d" style="width: 300px; border-radius:5px; margin:10px 0;">

            </div>

          </div>
		  
		  <div id="productpriceholder"  class="form-group">
		  </div>

          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <input checked="" name="sids" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">

            </div>

          </div>



          <div class="form-group">

            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">

              <input id="btnid" type="submit" name="btn" value="submit" class="btn btn-success"/>

            </div>

          </div>



        </form>

      </div>

    </div>

  </div>

</div>




<script>
function getproductPrice(a)
{
	var value = a.value;
	//alert(value);
	var url= '<?PHP echo $site_url;?>'+'include/discount/loadproductprice.php?puid='+value;
	//alert(url);
	$("#productpriceholder").load(url);
}

</script>

<link rel="stylesheet" type="text/css" href="<?PHP echo $site_url?>css/jquery.datetimepicker.css"/ >
<!--script src="<?PHP echo $site_url?>css/jquery.js"></script !-->
<script src="<?PHP echo $site_url?>js/jquery.datetimepicker.full.min.js"></script>
<script>
jQuery('#start_d').datetimepicker();
jQuery('#end_d').datetimepicker();
</script>


