<?php

	$basket_array = explode("~*~", $_POST['mustang']); 

	$mehsulsay=count($basket_array);

	$proid=array();

	$prosay=array();

	for ($i=0; $i <$mehsulsay ; $i++) 

	{ 

		$producs = explode("#~#", $basket_array[$i]);

		array_push($prosay, $producs[0]);

		array_push($proid, $producs[1]);

		if ($i==0) 

		{

			$proidstr='"'.$producs[1].'"';	

		}

		else

		{

			$proidstr=$proidstr.',"'.$producs[1].'"';	

		}		

	}

	$mehsulsor=$db->prepare('SELECT * from mehsul where l_id="'.$lng1.'" and s_id="1" and u_id IN ('.$proidstr.') ');

	//echo 'SELECT * from mehsul where l_id="'.$lng.'" and s_id="1" and u_id IN ('.$proidstr.') ';

	$mehsulsor->execute();

	$pro_id=array();

	$pro_ship=array();

	$pro_price=array();

	$pro_int=array();

	$tot_price=0;

	$tot_shipp=0;

	while ($mehsulcek=$mehsulsor->fetch(PDO::FETCH_ASSOC))

	{

		$key = array_search($mehsulcek['u_id'], $proid); 

		$int=$prosay[$key];

		array_push($pro_id, $mehsulcek['u_id']);

		array_push($pro_ship, $mehsulcek['shipping_1']);

		array_push($pro_price, $mehsulcek['price_1']);

		array_push($pro_int, $int);

		$tot_price=$tot_price+($mehsulcek['price_1']*$int);

		$tot_shipp=$tot_shipp+($mehsulcek['shipping_1']*$int);

	}

	if (($tot_shipp+$tot_price)==$_POST['mustang2']) 

	{	//echo '<pre>'; print_r($_POST); echo '</pre>';

		if(isset($_POST['lns_org']) and $_POST['lns_org']=='Continue')

		{ 

			$controller=1;

			$db->beginTransaction();

			$bas_ins=$db->prepare('INSERT INTO basket set `bask_user_id`=:id , 

														`bask_orddate`=:te , 

														`bask_type`=:pe , 

														`bask_s_id`=:sid , 

														`bask_price`=:ce , 

														`bask_ship`=:ip , 

														`bask_adress`=:ss , 

														`bask_tel`=:el , 

														`bask_mob`=:ob , 

														`bask_fname`=:me ,

														`bask_lname`=:lme , 

														`bask_zip`=:zip , 

														`bask_state`=:ste , 

														`bask_mail`=:il , 

														`bask_city`=:ty , 

														`bask_country`=:ry , 

														`bask_pi`=:pi ');

			$bas_ins_cnt=$bas_ins->execute(array( 	'id'=> '0' , 

													'te'=> date('Y-m-d') , 

													'pe'=> '9'  , 

													'sid'=> '1' , 

													'ce'=> $tot_price ,

												 	'ip'=> $tot_shipp ,

												 	'ss'=> s($_POST['txtAdress1']) ,

											 	 	'el'=> s($_POST['txtPH']) , 

											 	 	'ob'=> s($_POST['txtPH2']) , 

											 	 	'me'=> s($_POST['txtFName']) , 

											 	 	'lme'=> s($_POST['txtLName']) , 

											 	 	'zip'=> s($_POST['txtzip1']) , 

											 	 	'ste'=> s($_POST['txtprovince']) , 

											 	 	'il'=> s($_POST['txtEmail']) , 

											 	 	'ty'=> s($_POST['selCity']) , 

											 	 	'ry'=> s($_POST['selCountry']) , 

											 	 	'pi'=> s($_POST['payment_type'])   

										 	 	));

			if($bas_ins_cnt)

			{

				$lastinsertb = $db->lastInsertId(); 

			} 

			else 

			{

				$controller=0;

				// echo "<pre>"; print_r($bas_ins->errorInfo()); echo "</pre>";

			} 



			for ($t=0; $t < count($pro_id) ; $t++) 

			{

				$pro_bas_ins=$db->prepare('INSERT INTO  proinbas set `proinbas_m_id`=:id , 

																`proinbas_bask_id`=:b_id , 	

																`proinbas_price`=:p_p , 

																`proinbas_ship`=:p_s ,	

																`proinbas_int`=:p_i 

																 ');

				$pro_bas_ins_cnt=$pro_bas_ins->execute(array( 	

											 	 	'id'=> s($pro_id[$t]) , 

											 	 	'b_id'=> s($lastinsertb) , 

											 	 	'p_p'=> s($pro_price[$t]) , 

											 	 	'p_s'=> s($pro_ship[$t]) ,  

											 	 	'p_i'=> s($pro_int[$t])   

										 	 	));

				if(!$pro_bas_ins_cnt)

				{

					$controller=0;

					//echo "<pre>"; print_r($pro_bas_ins->errorInfo()); echo "</pre>";

				} 

			}

			$stat_bas_ins=$db->prepare('INSERT INTO statbas set  `statbas_s_id`=:id , 

															`statbas_bask_id`=:b_id , 	

															`statbas_date`=:p_p 

															 ');

			$stat_bas_ins_cnt=$stat_bas_ins->execute(array( 	

										 	 	'id'=> '9' , 

										 	 	'b_id'=> s($lastinsertb) , 

										 	 	'p_p'=> date('Y-m-d')   

									 	 	));

			if(!$stat_bas_ins_cnt)

			{

				$controller=0;

				//echo "<pre>"; print_r($stat_bas_ins->errorInfo()); echo "</pre>";

			} 

			if ($controller==1) 

			{

				$db->commit();



				echo "<script>localStorage.removeItem('data1'); localStorage.removeItem('basketCount1');</script>";

				header( "refresh:0; url=".$site_url.$lng."/thank/" );

			}

			else

			{

				$db->rollBack();

				echo 'zibile dusduk';

				echo "<script>localStorage.removeItem('data1'); localStorage.removeItem('basketCount1');</script>";

				header( "refresh:2; url=".$site_url.$lng."/shop/" );	

			}

		}	

	}

	else

	{

		echo "<script>localStorage.removeItem('data1'); localStorage.removeItem('basketCount1');</script>";

		header( "refresh:2; url=".$site_url.$lng."/shop/" );	

	}





?>

<style type="text/css">

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) .form_text, 

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) select 

{    

	width: 250px;

    height: 32px;

    float: left;

    border: 1px solid #bbd2d7;

}

.order_form .form_item:not(.form_textarea):not(.form_checkbox) label 

{

    width: 24%;

    text-align: right;

    line-height: 32px;

    padding-right: 0.5%;

}

@media (max-width: 1057px)

{

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) label 

	{

	    width: 20%;

	}

}

@media (max-width: 923px)

{

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) label 

	{

	    width: 17%;

	}

}

@media (max-width: 843px)

{

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) label 

	{

	    width: 17%;

	}

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) .form_text, 

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) select 

	{    

		width: 230px;

	    height: 32px;

	    float: left;

	    border: 1px solid #bbd2d7;

	}

}

@media (max-width: 783px)

{

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) label 

	{

	    width: 17%;

	}

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) .form_text, 

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) select 

	{    

		width: 220px;

	    height: 32px;

	    float: left;

	    border: 1px solid #bbd2d7;

	}

}

@media (max-width: 767px)

{

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) .form_text, 

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) select 

	{

	    width: 100%;

	}

	.order_form .form_item:not(.form_textarea):not(.form_checkbox) label 

	{

    text-align: left;

    width: 100%;

    margin-bottom: 5px;

	}

}

.basket_check_list_title:first-child {

    padding: 2px 575px 4px 0;

}





</style>

<style>

.basket_check_list_title:first-child 

{

    padding-right: calc(105% - 645px);

}

@media (max-width: 922px)

{

	.basket_check_list_title:first-child 

	{

	    padding-right: calc(106% - 645px);

	}

}

@media (max-width: 890px)

{

	.basket_check_list_title:first-child 

	{

	    padding-right: calc(109% - 650px);

	}

}

@media (max-width: 835px)

{

	.basket_check_list_title:first-child 

	{

	    padding-right: calc(114% - 650px);

	}

	.basket_check_list_title:nth-child(3) 

	{

    	padding-right: 77px;

	}

	.basket_check_list_title:nth-child(2) 

	{

    	padding-right: 87px;

	}

}

@media (max-width: 800px)

{

	.basket_check_list_title:first-child 

	{

	    padding-right: calc(120% - 655px);

	}

	.basket_check_list_title:nth-child(2) 

	{

    	padding-right: 59px;

	}

	.basket_check_list_title:nth-child(3) 

	{

    	padding-right: 66px;

	}

}

@media (max-width: 786px)

{

	.basket_check_list_title:first-child 

	{

	    padding-right: calc(122% - 655px);

	}

	.basket_check_list_title:nth-child(2) 

	{

    	padding-right: 43px;

	}

	.basket_check_list_title:nth-child(3) 

	{

    	padding-right: 54px;

	}

}

</style>

<div class="middle">

	<div class="container">

		<div class="page_title_wrapper">

			<h1 class="page_title">Order Review</h1>

		</div>

		<div class="middle_content">

			<div class="order_form user_settings" style="margin-bottom: 35px;">

				<form action="" method="POST" name="reg_form" id="registr_form">

					<div id="basket_area">							

						<!-- <b>Personal Info</b> -->

						<div class="form_item">

							<label  for="txtFName">First Name:</label>

							<input readonly="" maxlength="40" required="" value="<?php echo s($_POST['txtFName']); ?>"  maxlength="40" name="txtFName" id="txtFName" size="15" value="" class="checkout_inp  form_text">

							<label  for="txtLName">Last Name:</label>

							<input readonly="" required="" value="<?php echo s($_POST['txtLName']); ?>" maxlength="40" name="txtLName" id="txtLName" size="15"  value="" class="checkout_inp form_text">

						

						</div>

						<div class="form_item" id="CityPan">

							<label for="txtAdress1">Country:</label>

							<input readonly="" required="" value="<?php 

							$olkesor=$db->prepare('SELECT * from olkeler where kat_id="'.s($_POST["wcon"]).'" ');

							$olkesor->execute();

							$olkecek=$olkesor->fetch(PDO::FETCH_ASSOC);  echo s($olkecek['name']); ?>" maxlength="380" name="selCountry1" id="txtAdress3"  class="checkout_inp form_text" size="50" value="" >

							<input type="hidden" name="selCountry"  value="<?php echo ($_POST['wcon']); ?>" >

							<label for="txtAdress1">City:</label>

							<input readonly="" required="" value="<?php 

							$olkesor1=$db->prepare('SELECT * from olkeler where kat_id="'.s($_POST["selCity"]).'" ');

							$olkesor1->execute();

							$olkecek1=$olkesor1->fetch(PDO::FETCH_ASSOC);  echo s($olkecek1['name']); ?>" maxlength="380" name="selCity1" id="txtAdress4"  class="checkout_inp form_text" size="50" value="" >							

							<input type="hidden" name="selCity"  value="<?php echo s($_POST['selCity']); ?>" >

						</div>

						<div class="form_item">

							<label for="txtAdress1">Address:</label>

							<input readonly="" required="" value="<?php echo s($_POST['txtAdress1']); ?>" maxlength="380" name="txtAdress1" id="txtAdress1"  class="checkout_inp form_text" size="50" value="" >

							<label for="txtprovince">State/Province:</label>

							<input readonly="" required="" value="<?php echo s($_POST['txtprovince']); ?>"  maxlength="380" name="txtprovince" id="txtprovince"  class="checkout_inp form_text"size="50" value="">

						</div>

						<div class="form_item">

							<label for="txtPH">Telephone (Only digits):</label>

							<input readonly="" required="" value="<?php echo s($_POST['txtPH']); ?>" type="number"  name="txtPH" id="txtPH" size="20" maxlength="18" value="" class="checkout_inp form_text">

							<label for="txtPH2">Mobile (Only digits):</label>

							<input readonly="" required=""  value="<?php echo s($_POST['txtPH2']); ?>" type="number" name="txtPH2" id="txtPH2" size="20" maxlength="18" value="" class="checkout_inp form_text">

						</div>

	<!-- 					<b>Contact Info</b> -->

						<div class="form_item">

							<label for="txtzip1">ZIP / Postal code:</label>

							<input readonly="" required="" value="<?php echo s($_POST['txtzip1']); ?>" maxlength="380" name="txtzip1" id="txtzip1"  class="checkout_inp form_text"size="50" value="">

							<label for="txtEmail">Email:</label>

							<input readonly="" required="" value="<?php echo s($_POST['txtEmail']); ?>" type="email"  maxlength="50" name="txtEmail" id="txtEmail" size="40" value="" class="checkout_inp form_text">

						</div>

						<div class="form_item">

							<label for="txtPH2">Payment method:</label>

							<div>

								<?php  

								if($_POST['payment_type']=='1')

								{

								?>

								<input required="" checked="" value="<?php echo s($_POST['payment_type']); ?>" type="radio" name="payment_type" value="1" id="ip1">

								<label for="ip1"  style="width: auto; float: none;">

									<img src="http://localhost/lns/user//images/visa.jpg" border="0" style="height:50px !important;">

								</label>

								<?php 

								}

								elseif($_POST['payment_type']=='2')

								{

								?>

								<input required="" checked="" value="<?php echo s($_POST['payment_type']); ?>" type="radio" name="payment_type" value="2" id="ip2">

								<label for="ip2"  style="width: auto; float: none;">

									<img src="<?php echo $site_url ?>user/images/paypal.jpg" style="height:51px !important;" border="0" alt="PayPal Logo">

								</label>

								<?php 

								}

								?>

							</div>

						</div>



<!-- 						<div class="form_item">

							<label for="txtPH2">Mobile (Only digits):</label>

						</div> -->

						<input type="hidden" name="mustang" id="mustanga" value="<?php echo ($_POST['mustang']); ?>" >

						<input type="hidden" name="mustang2" id="mustanga2" value="<?php echo s($_POST['mustang2']); ?>" >

					</div>

					<section class="basket_check">

					    <div class="basket_check_list">

					        <div class="basket_check_list_title">Product</div>

					        <div class="basket_check_list_title">Price</div>

					        <div class="basket_check_list_title">Shipping</div>

					        <div class="basket_check_list_title">Quantity</div>

					        <div class="basket_check_list_title">Total</div>

					    </div>

					    <div id="adsa" class="basket_check_items">

					    </div>			    

						<br clear="both">

						<div class="basket_controls">

							<div class="basket_sum">

					           	<div class="total_price_wrap">							

			   			            <div class="basket_sum_total"><span>Price:</span>

			   		               		<div class="total_price" style="font-size: 20px;" id="price">4 561 <span>USD</span></div>

					           		</div> 

					           		<div class="basket_sum_total"><span>Shipping:</span>

			       		                <div class="total_price" style="font-size: 20px;" id="shipping" >4 561 <span>USD</span></div>

						           	</div> 

						           	<div class="basket_sum_total"><span>Total:</span>

			       		                <div class="total_price" id="total">4 561 <span>USD</span></div>

						           	</div>

									<div class="basket_sum_submit">

										<input  name="lns_org" value="Continue" class="btn"   type="submit">

									</div>

								</div>

							</div>

						</div>

					</section>

				</form>

			</div>

		</div>

	</div>

</div>

<style type="text/css">
    .page_title{
        text-align: left;
        font-size:30px;
        margin-bottom: 20px;
    }
    .left_sidebar{
        float: left;
        width: 25%;
    }
    .page_content{
        float: left;
        width: 75%;
    }
    .add_to_basket {
        color:#57cae9;
        border-color:#57cae9;
    }
    .colb{
        font-size:15px;
        height: 320px;
        padding: 10px;
        margin-bottom: 15px;
        width: 30.3333%;
        background: white;
        box-sizing: border-box;
        /* padding: 33px; */
        margin: 9px;
        float: left;
        color:#3b4047;
        font-weight: 600;
    }
    .colb a{ color:#3b4047 ; }
    .colb_child{
        padding: 15px;
    }
    .colb:hover {
        box-shadow: 10px 10px 5px #888888;
        padding-bottom: 12px;
        border-top: 2px solid #43b9da;
    }
    .colb:hover .add_to_basket {
        color: white;
        background-color: #57cae9;
    }
    .add_to_basket {
        background-color: white;
    }
    .col{
        font-size: 15px;
        background: white;
        margin-bottom: 10px;
        border: 1px solid #259dab;
        padding: 5px;
    }
    .col_child{
        border:1px solid #259dab;
        padding: 3px;
    }
    .col:hover{
        box-shadow: 10px 10px 5px #888888;
        border-right: 5px solid #259dab;
    }
    .field_content img{
    }
</style>

<style>
    #freezone {
        display: inline-block;
        width: 24px;
    }
    .cart_view {
        position: absolute;
        left: 280px;
        top: 2px;
        min-width: 386px;
        background: white;
        min-height: 90px;
        text-align: left;
        color: black;
        font-size: 14px;
        z-index: 500;
        font-family: Arial;
    }
    @media (max-width: 380px) {
        .cart_view {
            left: 60px;
        }
    }
    @media (min-width: 380px) and ( max-width: 520px) {
        .cart_view {
            left: 85px;
        }
    }
    @media (min-width: 520px) and ( max-width: 660px) {
        .cart_view {
            left: 105px;
        }
    }
    @media (min-width: 660px) and ( max-width: 740px) {
        .cart_view {
            left: 125px;
        }
    }
    @media (min-width: 740px) and ( max-width: 890px) {
        .cart_view {
            left: 145px;
        }
    }
    @media (min-width: 890px) and ( max-width: 1100px) {
        .cart_view {
            left: 185px;
        }
    }
    @media (min-width: 1100px) and ( max-width: 1300px) {
        .cart_view {
            left: 220px;
        }
    }
    @media (min-width: 1300px) and ( max-width: 1500px) {
        .cart_view {
            left: 255px;
        }
    }
    @media (min-width: 1900px) {
        .cart_view {
            left: 400px;
        }
    }
    .cart_view h4 {
        text-align: center;
        border-bottom: 1px solid rgb(179, 179, 179);
        background: rgb(245, 245, 245);
        margin: 0px !important;
        -webkit-border-top-left-radius: 10px;
        -webkit-border-top-right-radius: 10px;
        -moz-border-radius-topleft: 10px;
        -moz-border-radius-topright: 10px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 5px 0px 5px 0px;
    }
    #basket_area {
        padding: 10px;
    }
    .buy_row {
        display: table-row;
        width: 365px;
        min-height: 20px;
        font-size: 11px;
    }
    .buy_row > span {
        display: table-cell;
        float: left;
        margin-right: 10px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    #numb {
        font-weight: bold;
        width: 20px;
    }
    #pr_name {
        font-weight: bold;
        width: 180px;
        display: inline-block;
        word-wrap: break-word;
    }
    .prqty {
        display: inline-block;
        height: 20px;
        width: 30px;
        text-align: center;
        background: rgb(245, 245, 245);
        border-top: 1px solid rgb(179, 179, 179);
        border-bottom: 1px solid rgb(179, 179, 179);
    }
    #pr_qty a {
        display: inline-block;
        position: relative;
        border-top: 1px solid rgb(179, 179, 179);
        border-bottom: 1px solid rgb(179, 179, 179);
        height: 20px;
        width: 20px;
        background: rgb(230, 230, 230);
        text-decoration: none;
        text-align: center;
        color: black;
    }
    .btn_minus {
        border-left: 1px solid rgb(179, 179, 179);
    }
    .btn_plus {
        border-right: 1px solid rgb(179, 179, 179);
    }
    .colored {
        color: red;
    }
    .bskt_total {
        display: inline-block;
        font-weight: bold;
        font-size: 13px;
        margin-top: 7px;
        margin-left: 8px;
    }
    .newinput {
        margin: 5px;
        background: white !important;
        border: 1px solid #9e9e9e !important;
        height: 17px !important;
        width: 200px;
        padding: 5px;
    }
    .form_text {
        border: 1px solid #ccc;
        margin-right: 5px;
        margin-left: 7px;
        padding-left: 5px;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        background-color: #eee;
    }
</style>

<script src="<?=$site_url?>user/js/jquery.js" ></script>

<script type="text/javascript">

function update()

{



	var teras = localStorage.getItem("data1");

	var terasp = JSON.parse(teras);

	var proship =0;

	var proprice =0;

	var total = 0 ;

	var lstophp = "";

	var tat = "";



	for (var i =0; i < terasp.length; i++) 

	{

		var minitotal;

		proship = proship + (parseInt(terasp[i].ship)*terasp[i].dataCount);

		proprice = proprice + (parseInt(terasp[i].price)*terasp[i].dataCount);

		minitotal = (parseInt(terasp[i].price)*terasp[i].dataCount) + (parseInt(terasp[i].ship)*terasp[i].dataCount);

	tat = tat + "<div class='basket_check_items_item'><div class='basket_check_items_item_photo'><img style='max-width:100px;' src='<?=$site_url?>cms/images/"+terasp[i].image+"' alt=''></div><div class='basket_check_items_item_title'><div class='item_name'>"+terasp[i].name+"</div><div class='item_article'>Артикул: <span>45971644</span></div></div><div class='basket_check_items_item_price'>"+terasp[i].price+"</div><div class='basket_check_items_item_price'>"+terasp[i].ship+"</div><div class='basket_check_items_item_counter'><div class='good_basket clearfix'><div class='good_basket_btns clearfix'><input readonly='' style='width: 81px; padding:0; margin:0;' type='text' class='good_basket_input form_text' value='"+terasp[i].dataCount+"'></div></div></div><div class='basket_check_items_item_total'>"+minitotal+"</div></div>";

		lstophp = lstophp + terasp[i].dataCount + "#~#" + terasp[i].id + "~*~" ;



	}



	var ttt = lstophp.substring(0, (lstophp.length-3) );

	total = (proship + proprice) ; 

	$('#adsa').html(tat);

	$('#price').html(proprice+" <?php echo $_SESSION['valuvalyut']; ?>");

	$('#shipping').html(proship+" <?php echo $_SESSION['valuvalyut']; ?>");

	$('#total').html(total+" <?php echo $_SESSION['valuvalyut']; ?>");

	$('#mustanga').val(ttt);

	$('#mustanga2').val(total);

}

update();

</script>