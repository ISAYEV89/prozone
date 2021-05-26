<?php 

$sql='SELECT m.name, m.image_url, m.price_1, m.price_2, m.price_3, md.* FROM mehsul m, mehsul_discount md where md.id=:uid and md.m_u_id=m.u_id and m.l_id=1 limit 1 ';
$data=array('uid'=>s($_GET['val']));


$a=$db->prepare($sql);

$a->execute($data);

$b=$a->fetch(PDO::FETCH_ASSOC);




//timelari duzgun formata saliriq***********************************
$sd=$b['start'];
$ed=$b['end'];


$a=explode(' ',$sd);
$b2=$a[0];
$c=explode('-',$b2);

$sd=$c[0].'/'.$c[1].'/'.$c[2].' '.$a[1];


$a=explode(' ',$ed);
$b2=$a[0];
$c=explode('-',$b2);

$ed=$c[0].'/'.$c[1].'/'.$c[2].' '.$a[1];

//******************************************************************

?>



<div class="row">

  <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">

      <div class="x_title">

        <h2>Edit product discount - <?PHP echo $b['name']; ?></h2>

        <div class="clearfix"></div>

      </div>

      <div class="x_content">   

        <form method="POST" action="<?PHP echo $site_url;?>discount/editsubmit/<?PHP echo $_GET['val'];?>/" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">   

          <div class="w3-container">

           
          </div>   
          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Start time</label>

            <div class="col-md-9 col-sm-9 col-xs-12">

              <input type="text" name="sd" value="<?PHP echo $sd;?>" required id="start_d" style="width: 300px; border-radius:5px; margin:10px 0;">

            </div>

          </div>

          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select End time</label>

            <div class="col-md-9 col-sm-9 col-xs-12">

              <input type="text" name="ed" value="<?PHP echo $ed;?>" required id="end_d" style="width: 300px; border-radius:5px; margin:10px 0;">

            </div>

          </div>
		  <?PHP
			if($b['mop_id']==0) //burda mehsulun standart qiymetleri cixacaq
			{
				switch($b['shop_type'])
				{
					case 1:
						$pr=$b['price_1'];
					break;
					case 2:
						$pr=$b['price_2'];
					break;
					case 3:
						$pr=$b['price_3'];
					break;
				}
				$curr='$USD';
				$olke='All countries';
			}
			else
			{
				
				$oc=$db->prepare('select o.* , mop.price_1 , mop.price_2 , mop.price_3, c.short_name, mop.id mopid from mehsul_olke_price mop, olkeler o, currency c where mop.id=:muid and o.kat_id=mop.o_u_id and o.l_id=1 and o.currency_id=c.u_id and c.l_id=1');
				$oc->execute(array('muid'=>$b['mop_id'] ));

				$b1=$oc->fetch(PDO::FETCH_ASSOC);
				switch($b['shop_type'])
				{
					case 1:
						$pr=$b1['price_1'];
						$shopname='Eshop';
					break;
					case 2:
						$pr=$b1['price_2'];
						$shopname='Registration';
					break;
					case 3:
						$pr=$b1['price_3'];
						$shopname='Commision shop';
					break;
				}
				$curr=$b1['short_name'];
				$olke=$b1['name'];
			}
			switch($b['type'])
			{
				case 1:
					$prn=ceil($pr*(100-$b['value'])/100);
				break;
				case 2:
					$prn=$pr-$b['value'];
				break;
			}
		  ?>
		  <div class="x_title">

				<h2><?PHP echo $b['name'];?> prices for <?PHP echo $olke;?> </h2>

				<div class="clearfix"></div>

			</div>
			<div class="x_content">   
				<div class="form-group" id="allcount"  >
					<label class="control-label col-md-3 col-sm-3 col-xs-12"><?PHP echo $shopname;?> price - <span style="border:1px solid black;display: inline-block;padding: 3px;"><?PHP echo $pr.' '.$curr;?> </span>:</label>
					<div class="col-md-9 col-sm-9 col-xs-12" style="padding-top:8px;">
						<input type="text" name="value" value="<?PHP echo $b['value']; ?>" />
						<select name="type" style="height: 24px;   width: 70px;">
							<option value="1"<?PHP if($b['type']==1){echo 'selected';}?>>%</option>
							<option value="2"<?PHP if($b['type']==2){echo 'selected';}?>>fixed</option>
						</select>
						discounted price - <span style="border:1px solid black;display: inline-block;padding: 3px;"><?PHP echo $prn.' '.$curr;?> </span>
					</div>
				</div> 
			</div>
		  <?PHP
		  ?>

          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12">Display <span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <input checked="" name="sid" class="date-picker form-control col-md-7 col-xs-12 js-switch" type="checkbox">

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


