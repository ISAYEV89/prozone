<?PHP
$shop_type=2; //burda hansi ehsopla ishlediyimizi qeyd edirik (1 e-shop, 2 registration, 3 commission shop)
if($_SERVER["HTTP_REFERER"]!=$site_url.$lng.'/signup_shop/shippay/' or @!$_SESSION['signup_referer_id'])// check refering page
{
	?>
	<div class="order_form user_settings">
		<div class="form_item" style="text-align:center;">
			<h3 style="text-align:center;">
			<?PHP echo $shippay['referererror'][$lng]; ?>
			</h3>
		</div>
		<br>
		<div style="text-align:center;">
			<Div style="min-height: 48px;    -webkit-box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    background: #43b9da;
text-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);  cursor:pointer;  font-size: 24px;    font-weight: 300;    border: none;    width: 270px;    color: #fff; padding:7px;  line-height: 30px; margin:0px auto;" id="backBtn" onclick="location.replace('<?PHP echo $site_url.$lng.'/sign-up/'; ?>');">
				<?PHP echo $lostpassword['backbtn2'][$lng]; ?>
			</div>
		</div>
	</div>
	<?PHP
}
else
{

	$_SESSION['post_reg_data']=$_POST;
	$a=$db->prepare('SELECT * from `olkeler` where  `l_id` =:lid and kat_id=:olke limit 1');

			$a->execute(ARRAY('lid'=>$lng1, 'olke' => $_SESSION['signup_country_id']));
			$ab=$a->fetch(PDO::FETCH_ASSOC);
			
			$citysql=$db->prepare('SELECT * from `olkeler` where  `l_id` =:lid and kat_id=:olke order by ordering asc');

			$citysql->execute(ARRAY('lid'=>$lng1, 'olke' => $_POST['city']));
			$ac=$citysql->fetch(PDO::FETCH_ASSOC);
			
			
	//echo'</pre>';

	?>
	<div class="middle">
			<div class="container">
				<div class="page_title_wrapper">
					<h1 class="page_title"><?php echo $review['review'][$lng] ?></h1>
				</div>

	<div class="middle_content">
		
		<div class="basket_my_orders_callback user_orders">
			<table class="lk_table_user_orders">
				<tbody>
					<tr class="line_info_bot line_info_bot_302 even active_row active_row_b">
						<td colspan="3" class="order_data">
							<table class="table_goods">
								<thead>
								<tr>
									<th><?php echo $review['product'][$lng] ?></th>
									<th><?php echo $review['price'][$lng] ?></th>
									<th><?php echo $review['ship'][$lng] ?></th>
									<th><?php echo $review['count'][$lng] ?></th>
									<th><?php echo $review['total'][$lng] ?></th> 
								</tr>
								</thead>
								<tbody id="adsa">
									
								</tbody>
								<tfoot>
								<tr><td colspan="6"><hr /></td></tr>
								<tr>
									<td colspan="4"><?php echo $review['total'][$lng] ?></td>
									<td id="total"></td>
								</tr>
								</tfoot>
							</table>
							
							<form action="<?PHP echo $site_url.$lng.'/signup_shop/confirm/'?>" id="registr_form" method="post" onsubmit="return validateme()">
							<table>
								<thead>
								<tr>
									<th colspan="2" style="padding-bottom:50px;"><?php echo $review['choosepayment'][$lng] ?></th>
								</tr>
								</thead>
								<tbody >
									<tr>
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="3"></td>
										<td>Pay by cash</td>
									</tr>
									<tr class="odd">
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="4"></td>
										<td><img src="<?php echo $site_url.'images/Visa-01.png'; ?>" style="width:100px;"/></td>
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="5"></td>
										<td><img src="<?php echo $site_url.'images/mc_symbol_opt_73_1x.png'; ?>" style="width:100px;"/></td>
									</tr>
									<tr>
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="6"></td>
										<td><!-- PayPal Logo --><img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" border="0" alt="PayPal Logo"><!-- PayPal Logo --></td>
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="7"></td>
										<td><img src="<?php echo $site_url.'images/google-pay-logo-5.png'; ?>" style="width:100px;"/></td>
									</tr>
									 
								</tbody>
								
							</table>
								<input type="hidden" name="pordinfo" id="prodinfo" value="">
								<input class="review-order" type="submit" name="sbmt" value="order">
							</form>
						</td>
						<td colspan="3" class="order_info">
							<table border="1" cellspacing="0" width="100%">
								<tbody>
									 <tr class="odd"><td><?php echo $review['fname'][$lng] ?>:</td><td><?php echo $_POST['fname'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $review['lname'][$lng] ?>:</td><td><?php echo $_POST['lname'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['dob'][$lng] ?>:</td><td><?php echo $_POST['dob'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['gender'][$lng] ?>:</td><td><?php echo (($_POST['gender']==1)? $shippay['male'][$lng] : $shippay['female'][$lng]) ?></td> </tr>
									 <tr class="even"><td><?php echo $review['email'][$lng] ?>:</td><td><?php echo $_POST['mail'] ?></td> </tr>
									 <tr class="even"><td><?php echo $shippay['phone'][$lng] ?></td><td><?php echo $_POST['pref1'].' '.$_POST['phone'] ?></td> </tr>
									 <tr class="even"><td><?php echo $shippay['mobile'][$lng] ?></td><td><?php echo $_POST['pref2'].' '.$_POST['mobile'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['country'][$lng] ?></td><td><?php echo $ab['name'] ?></td> </tr>
									 <tr class="even"><td><?php echo $shippay['city'][$lng] ?></td><td><?php echo $ac['name'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['adr1'][$lng] ?></td><td><?php echo $_POST['adr1'] ?></td> </tr>
									 <?PHP if ($_POST['adr2']){?><tr class="odd"><td><?php echo $shippay['adr2'][$lng] ?></td><td><?php echo $_POST['adr2'] ?></td> </tr><?PHP }?>
									 <tr class="odd"><td><?php echo $shippay['state'][$lng] ?></td><td><?php echo $_POST['state'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['zip'][$lng] ?></td><td><?php echo $_POST['zip'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['national'][$lng] ?></td><td><?php echo $_POST['national'] ?></td> </tr>
									 <tr class="odd"><td colspan="2"><hr></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['lifeaccount'][$lng] ?></td><td><?php echo $_POST['login'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['secquest'][$lng] ?></td><td><?php echo $_POST['question'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['secansw'][$lng] ?></td><td><?php echo $_POST['answer'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['mother'][$lng] ?></td><td><?php echo $_POST['mname'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['successor'][$lng] ?></td><td><?php echo $_POST['sucsessor'] ?></td> </tr>
								</tbody>
							</table>
						</td> 
					</tr>
				</tbody>
			</table>
			<table class="lk_table_user_orders mob">
				<tbody>
					<tr class="line_info_bot line_info_bot_302 even active_row active_row_b">
						<td colspan="3" class="order_data">
							<table class="table_goods">
								<tbody id="adsa2">
									
								</tbody>
								<tfoot>
								<tr><td colspan="6"><hr /></td></tr>
								<tr>
									<td colspan="4"><?php echo $review['total'][$lng] ?></td>
									<td id="total2"></td>
								</tr>
								</tfoot>
							</table>
							
						</td>
						<td colspan="3" class="order_info">
							<table border="1" cellspacing="0" width="100%">
								<tbody>
									 <tr class="odd"><td><?php echo $review['fname'][$lng] ?>:</td><td><?php echo $_POST['fname'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $review['lname'][$lng] ?>:</td><td><?php echo $_POST['lname'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['dob'][$lng] ?>:</td><td><?php echo $_POST['dob'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['gender'][$lng] ?>:</td><td><?php echo (($_POST['gender']==1)? $shippay['male'][$lng] : $shippay['female'][$lng]) ?></td> </tr>
									 <tr class="even"><td><?php echo $review['email'][$lng] ?>:</td><td><?php echo $_POST['mail'] ?></td> </tr>
									 <tr class="even"><td><?php echo $shippay['phone'][$lng] ?></td><td><?php echo $_POST['pref1'].' '.$_POST['phone'] ?></td> </tr>
									 <tr class="even"><td><?php echo $shippay['mobile'][$lng] ?></td><td><?php echo $_POST['pref2'].' '.$_POST['mobile'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['country'][$lng] ?></td><td><?php echo $ab['name'] ?></td> </tr>
									 <tr class="even"><td><?php echo $shippay['city'][$lng] ?></td><td><?php echo $ac['name'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['adr1'][$lng] ?></td><td><?php echo $_POST['adr1'] ?></td> </tr>
									 <?PHP if ($_POST['adr2']){?><tr class="odd"><td><?php echo $shippay['adr2'][$lng] ?></td><td><?php echo $_POST['adr2'] ?></td> </tr><?PHP }?>
									 <tr class="odd"><td><?php echo $shippay['state'][$lng] ?></td><td><?php echo $_POST['state'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['zip'][$lng] ?></td><td><?php echo $_POST['zip'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['national'][$lng] ?></td><td><?php echo $_POST['national'] ?></td> </tr>
									 <tr class="odd"><td colspan="2"><hr></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['lifeaccount'][$lng] ?></td><td><?php echo $_POST['login'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['secquest'][$lng] ?></td><td><?php echo $_POST['question'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['secansw'][$lng] ?></td><td><?php echo $_POST['answer'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['mother'][$lng] ?></td><td><?php echo $_POST['mname'] ?></td> </tr>
									 <tr class="odd"><td><?php echo $shippay['successor'][$lng] ?></td><td><?php echo $_POST['sucsessor'] ?></td> </tr>
								</tbody>
							</table>
							<form action="<?PHP echo $site_url.$lng.'/signup_shop/confirm/'?>" id="registr_form2" method="post" onsubmit="return validateme2()">
							<table>
								<thead>
								<tr>
									<th colspan="2" style="padding-bottom:50px;"><?php echo $review['choosepayment'][$lng] ?></th>
								</tr>
								</thead>
								<tbody >
									<tr>
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="3"></td>
										<td>Pay by cash</td>
									</tr>
									<tr class="odd">
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="4"></td>
										<td><img src="<?php echo $site_url.'images/Visa-01.png'; ?>" style="width:100px;"/></td>
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="5"></td>
										<td><img src="<?php echo $site_url.'images/mc_symbol_opt_73_1x.png'; ?>" style="width:100px;"/></td>
									</tr>
									<tr>
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="6"></td>
										<td><!-- PayPal Logo --><img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" border="0" alt="PayPal Logo"><!-- PayPal Logo --></td>
										<td  style="text-align:right; padding-right:15px;"><input type="radio" name="payoption" value="7"></td>
										<td><img src="<?php echo $site_url.'images/google-pay-logo-5.png'; ?>" style="width:100px;"/></td>
									</tr>
									 
								</tbody>
								
							</table>
								<input type="hidden" name="pordinfo" id="prodinfo2" value="">
								<input class="review-order" type="submit" name="sbmt" value="order">
							</form>
						</td> 
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	</div>
	</div>






<?PHP
}
?>