<div class="middle">
	<div class="container">
		<div class="page_title_wrapper">
			<h1 class="page_title"><?PHP echo $yearpay['title'][$lng]; ?></h1>
		</div>		<div class="middle_content">
			<br />
			<div style="text-align: center;width: 50%;margin: 0px auto;">
				<?PHP echo $yearpay['topnote'][$lng]; ?> 
			</div>
			<?PHP
			if(empty($_SESSION['lock_id']))
			{
				//error line will go here
			}
			else
			{
				$sas=$db->prepare('SELECT 
				`u`.*
				
				FROM 
				
				`user` u 
				
				WHERE 
				
				`u`.`id`="'.$_SESSION['lock_id'].'" 
				
				LIMIT 1');
				
				$sas->execute();
				$b = $sas->fetch(PDO::FETCH_ASSOC);
				
			//finding payment values for convert, first couple vaucher and etc and converting it to their currencies********************************
			$limits=$db->prepare("Select * from `salary`");
			$limits->execute();
			$pay_val=ARRAY(); // payment values for countries
			while($limit=$limits->fetch(PDO::FETCH_ASSOC))
			{
				$cid=$limit['c_id'];
				$pay_val[$cid]=$limit;
			}
			//print_r($pay_val);
			
			$ucon=$b['country'];
			if(!empty($pay_val[$ucon]))	{	$pymnt=$pay_val[$ucon];	}
			else						{	$pymnt=$pay_val[0];		}	
			$l_arr=explode('@',$pymnt['yearpay']);
			$l_arr2=ARRAY();
			foreach($l_arr as $value)
			{
				$g=explode('-',$value);
				$l_arr2[]=$g;
			}
			foreach($l_arr2 as $vl)
			{
				if(($_SESSION['lock_rt']>=$vl[0] and $_SESSION['lock_rt']<$vl[1]))
				{
					$uid=$user['id'];
					$mblg=$vl[2];
					break 1; // it will stop foreach iteraton and go for next id
				}
			}
			$mblg=currconverter($db,$mblg,1,$_SESSION['u_curr2'],2);
			
			//**************************************************************************************************************************************
			?>
			<br />
			<br />
			<div class="order_form user_settings">
				<form action=""  method="POST"  onsubmit="return validateme()" id="registr_form">
					<div class="form_item">
						<label for=""><?PHP echo $menu['login_place'][$lng]; ?> :</label>
						<input type="text" class="form_text" name="curr_login" value="<?PHP echo $b['login'];?>" id="flafield" readonly>
					</div>
					<div class="form_item">
						<label for=""><?PHP echo $yearpay['laid'][$lng]; ?> :</label>
						<input type="text" class="form_text" name="laid" value="<?PHP echo $b['serial'];?>" id="flaidfield" readonly>
					</div>
					<div class="form_item">
						<label for=""><?PHP echo $yearpay['regtype'][$lng]; ?> :</label>
						<input type="text" class="form_text" name="reg_type" value="<?PHP echo $_SESSION['lock_rt'];?>" id="frtfield" readonly>
					</div>
					<div class="form_item">
						<label for=""><?PHP echo $yearpay['lad'][$lng]; ?> :</label>
						<input type="text" class="form_text" name="last_a" value="<?PHP echo $_SESSION['lock_lad'];?>" id="fladfield" readonly>
					</div>
					<div class="form_item">
						<label for=""><?PHP echo $yearpay['prolong'][$lng]; ?> :</label>
						<input type="text" class="form_text" name="value" value="<?PHP echo $mblg.' '.$_SESSION['u_currname'];?>" id="fprlngfield" readonly>
					</div>
					<div class="form_item" style="line-height: 30px;">

                        <div>
						    <input type="hidden" id="cmbankvalue" name="cmbankvalue" value="<?PHP echo $b['balans_2'];?>">
                        </div>


                        <label for=""><?php echo $review['choosepayment'][$lng] ?> :</label>


                        <input type="radio" <?php echo ($b['balans_2'] < $mblg) ? 'disabled' : ''; ?> id="lbradio"  name="payoption" value="5"> Commission bank: <?PHP echo $b['balans_2'].' '.$_SESSION['u_currname'];?>
                        <br>

<!--						<input type="radio" id="lbradio" name="payoption" value="5"> Commission bank: --><?PHP //echo $b['balans_2'].' '.$_SESSION['u_currname'];?>
<!--						<br>-->
						<input type="radio" id="ppradio" name="payoption" value="6"> Pay pal 						
					</div>
					<br>
					<div class="form_actions">
						<input type="submit" class="form_submit" id="sbmtbtn" value="<?PHP echo $lostpassword['confirm'][$lng]; ?>" name="sbmtbtn">
					</div>
				</form>
			</div>
			<br /><br />
			<br />
			<br />
		<?PHP
			}
		?>
		</div>
	</div>
</div>

<style>
.form_item {
   /* margin-bottom: 30px;*/
     width: 100%; 
}
.form_item label {
    margin: 0px 0px 5px 0px;
    text-align: left; 
}
.order_form .form_item:not(.form_textarea):not(.form_checkbox) label {
    float: left;
    width: 38%;
    text-align: right;
    line-height: 32px;
    padding-right: 0.5%;
}
.block_title
{
	padding:0px !important;
}
.rederror
{
	color: gray;
	padding: 3px;
	float: right;
	width: 34%;
	visibility: hidden;
	border-radius: 7px;
	-moz-border-radius: 7px;
	-webkit-border-radius: 7px;
	font-size: 11px;
	text-align: center;
	box-shadow: 2px 2px 3px #f5f5f5;
	-moz-box-shadow: 2px 2px 3px #f5f5f5;
	-webkit-box-shadow: 2px 2px 3px #f5f5f5;
}
.margin_right
{
	margin-right:20px;
}
.phoneholder
{
	width: 221px;
	height: 32px;
	float: left;
	border: 1px solid #bbd2d7;
	padding-left: 10px;
}
.phoneprefix
{
	width: 45px;
	height: 32px;
	float: left;
	border: 1px solid #bbd2d7;
	text-align: center;
	margin-right: 4px;
}
.hint
{
	padding: 1px 6px;
	display: inline-block;
	text-decoration: none;
	border: 1px solid #bbd2d7;
	border-radius: 32px;
	color: #bbd2d7;
	margin-top: 5px;
	float: left;
	font-size: 12px;
}
.hint:hover + .rederror
{
	visibility:visible;
} 
.hinterror
{
	border: 1px solid red !important;
	padding: 1px 7px !important;
	color:red !important;
}
@media (max-width: 767px)
{
	.order_form .form_item:not(.form_textarea):not(.form_checkbox) .form_text, .order_form .form_item:not(.form_textarea):not(.form_checkbox) select
	{
    width: 83%;
    margin-right: 10px;
	}
	.order_form .form_item:not(.form_textarea):not(.form_checkbox) label 
	{
    width: 100%;
    text-align: left;
    line-height: 32px;
    padding-right: 0.5%;
    margin: 0px auto;
	}
	.rederror {
    color: gray;
    padding: 3px;
    float: right;
	width:100%;
    visibility: hidden;
    border-radius: 7px;
    -moz-border-radius: 7px;
    -webkit-border-radius: 7px;
    font-size: 11px;
    text-align: center;
    box-shadow: 2px 2px 3px #f5f5f5;
    -moz-box-shadow: 2px 2px 3px #f5f5f5;
    -webkit-box-shadow: 2px 2px 3px #f5f5f5;
	}
}
</style>

<script src="<?php echo $site_url; ?>js/jquery.js"></script>


<script>

$(document).ready(function () {
    $('input[type=radio][name=payoption]').change(function() {
    if (this.value == '5' || this.value == '6') {
        $('#registr_form').attr('action', '<?PHP echo $site_url.$lng."/yearpay/pay_by_system/"?>');
    }
    else {
        $('#registr_form').attr('action', '<?PHP echo $site_url.$lng."/yearpay/pay_by_pp/"?>');
    }
	});
});
	
	$('#registr_form').submit(function() {
    if ($('input:radio', this).is(':checked')) {
        // everything's fine...
		$('#sbmtbtn').attr("disabled", true);
		$('#sbmtbtn').attr("value", "Submitting...");
    } else {
        alert('Please select payment method');
        return false;
    }
});
</script>