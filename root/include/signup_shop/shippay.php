<?PHP
$shop_type=2; //burda hansi ehsopla ishlediyimizi qeyd edirik (1 e-shop, 2 registration, 3 commission shop)

if($_SERVER["HTTP_REFERER"]!=$site_url.$lng.'/signup_shop/basket/'  or @!$_SESSION['signup_referer_id'])// check refering page
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
	echo'<pre>';
	//print_r($_SESSION);

	$a=$db->prepare('SELECT * from `olkeler` where  `l_id` =:lid and kat_id=:olke limit 1');

			$a->execute(ARRAY('lid'=>$lng1, 'olke' => $_SESSION['signup_country_id']));
			$ab=$a->fetch(PDO::FETCH_ASSOC);
			
			$citysql=$db->prepare('SELECT * from `olkeler` where  `l_id` =:lid and sub_id=:olke order by ordering asc');

			$citysql->execute(ARRAY('lid'=>$lng1, 'olke' => $_SESSION['signup_country_id']));
			
			
	echo'</pre>';

	?>
	<div class="middle">
			<div class="container">
				<div class="page_title_wrapper">
					<h1 class="page_title"><?php echo $shippay['checkout'][$lng] ?></h1>
				</div>
				<div class="middle_content">
					<div class="order_form">
						<div class="block_title"><?php echo $shippay['fillout'][$lng] ?></div>
						<div class="block_title"style="font-size:14px;"><?php echo $shippay['personal'][$lng] ?></div>
						<form action="<?PHP echo $site_url.$lng.'/signup_shop/review/'?>" id="registr_form" method="post" onsubmit="return validateme()">
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['fname'][$lng] ?></label>
								<input type="text" id="fname" name="fname" class="form_text margin_right" onkeyup="fnamefilter(20)" required="required">
								<a href="" onclick="event.preventDefault()" id="fnhint" class="hint">?</a>
								<div id="fnameerr" class="rederror"><?php echo $shippay['fnametext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['lname'][$lng] ?></label>
								<input type="text" id="lname" name="lname" class="form_text margin_right" onkeyup="lnamefilter(30)" required="required">
								<a href="" onclick="event.preventDefault()" id="lnhint" class="hint">?</a>
								<div id="lnameerr" class="rederror"><?php echo $shippay['lnametext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['dob'][$lng] ?></label>
								<input type="text" name="dob" id="datepicker" onchange="isValidDate()" class="form_text margin_right" required="required">
								<a href="" onclick="event.preventDefault()" id="datehint" class="hint">?</a>
								<div id="lnameerr" class="rederror"><?php echo $shippay['dobtext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['gender'][$lng] ?></label>
								<select name="gender"  required="required">
									<option value="1"><?php echo $shippay['male'][$lng] ?></option>
									<option value="2"><?php echo $shippay['female'][$lng] ?></option>
								</select>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['national'][$lng] ?></label>
								<input type="text" name="national" id="national" onkeyup="nifilter()" required="required" class="form_text margin_right">
								<a href="" onclick="event.preventDefault()" id="nihint" class="hint">?</a>
								<div id="nierr" class="rederror"><?php echo $shippay['nationaltext'][$lng] ?></div>
							</div>
							<div class="block_title"style="font-size:14px;"><?php echo $shippay['shipping'][$lng] ?></div>
							<div class="form_item">
								<label for=""><?php echo $shippay['country'][$lng] ?></label>
								<input type="text" class="form_text" value="<?PHP echo $ab['name']; ?>" disabled="disabled">
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['city'][$lng] ?></label>
								<select name="city"  required="required">
									<?PHP
										while($city=$citysql->fetch(PDO::FETCH_ASSOC))
										{
											echo'<option value="'.$city['kat_id'].'">'.$city['name'].'</option>';
										}
									?>
								</select>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['zip'][$lng] ?></label>
								<input type="text" name="zip" id="zip" required="required" class="form_text margin_right" onkeyup="zipfilter()">
								<a href="" onclick="event.preventDefault()" id="ziphint" class="hint">?</a>
								<div id="ziperr" class="rederror"><?php echo $shippay['ziptext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['state'][$lng] ?></label>
								<input type="text" name="state" id="state" required="required" class="form_text margin_right" onkeyup="statefilter()">
								<a href="" onclick="event.preventDefault()" id="sthint" class="hint">?</a>
								<div id="sterr" class="rederror"><?php echo $shippay['statetext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['adr1'][$lng] ?></label>
								<input type="text" name="adr1" id="adr1" required="required" class="form_text margin_right" onkeyup="adrfilter()">
								<a href="" onclick="event.preventDefault()" id="adr1hint" class="hint">?</a>
								<div id="adr1err" class="rederror"><?php echo $shippay['adr1text'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><?php echo $shippay['adr2'][$lng] ?></label>
								<input type="text" name="adr2" class="form_text">
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['phone'][$lng] ?></label>
								<input type="text" name="pref1" class="phoneprefix" readonly value="<?PHP echo $ab['prefix'];?>">
								<input type="tel" name="phone" id="phone" required="required" class="phoneholder margin_right" onkeyup="phonefilter()">
								<a href="" onclick="event.preventDefault()" id="phhint" class="hint">?</a>
								<div id="pherr" class="rederror"><?php echo $shippay['phonetext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['mobile'][$lng] ?></label>
								<input type="text" name="pref2" class="phoneprefix" readonly value="<?PHP echo $ab['prefix'];?>">
								<input type="tel" name="mobile" id="mobile" required="required" class="phoneholder margin_right" onkeyup="mobilefilter()">
								<a href="" onclick="event.preventDefault()" id="mobhint" class="hint">?</a>
								<div id="moberr" class="rederror"><?php echo $shippay['mobiletext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['email'][$lng] ?></label>
								<input type="email" name="mail" id="mail" class="form_text margin_right" required="required" onkeyup="mailfilter()">
								<a href="" onclick="event.preventDefault()" id="mlhint" class="hint">?</a>
								<div id="mlerr" class="rederror"><?php echo $shippay['emailtext'][$lng] ?></div>
							</div>
							
							<div class="block_title" style="font-size:14px;"><?php echo $shippay['systeminfo'][$lng] ?></div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['lifeaccount'][$lng] ?></label>
								<input type="text" id="login" name="login" class="form_text margin_right" onkeyup="loginfilter()" onchange="checklogin()">
								<a href="" onclick="event.preventDefault()" id="loginhint" class="hint">?</a>
								<div id="loginerr" class="rederror"><?php echo $shippay['lifeaccounttext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['password'][$lng] ?></label>
								<input type="password" id="pass" name="pass" class="form_text margin_right"onkeyup="passfilter()">
								<a href="" onclick="event.preventDefault()" id="passhint" class="hint">?</a>
								<div id="passerr" class="rederror"><?php echo $shippay['passwordtext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['password2'][$lng] ?></label>
								
								<input type="password" id="pass2" name="pass2" class="form_text margin_right"onkeyup="passequal()">
								<a href="" onclick="event.preventDefault()" id="pass2hint" class="hint">?</a>
								<div id="pass2err" class="rederror"><?php echo $shippay['password2text'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['secquest'][$lng] ?></label>
								
								<input type="text" id="question" name="question" class="form_text margin_right" onkeyup="questionfilter()">
								<a href="" onclick="event.preventDefault()" id="questionhint" class="hint">?</a>
								<div id="questionerr" class="rederror"><?php echo $shippay['secquesttext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['secansw'][$lng] ?></label>
								<input type="text" id="answer" name="answer" class="form_text margin_right" onkeyup="answerfilter()">
								<a href="" onclick="event.preventDefault()" id="answerhint" class="hint">?</a>
								<div id="answererr" class="rederror"><?php echo $shippay['secanswtext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['mother'][$lng] ?></label>
								<input type="text" id="mname" name="mname" class="form_text margin_right" onkeyup="motherfilter(20)" required="required">
								<a href="" onclick="event.preventDefault()" id="mnhint" class="hint">?</a>
								<div id="mnameerr" class="rederror"><?php echo $shippay['mothertext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['mother2'][$lng] ?></label>
								
								<input type="text" id="mname2" name="mname2" class="form_text margin_right"onkeyup="motherequal()">
								<a href="" onclick="event.preventDefault()" id="mname2hint" class="hint">?</a>
								<div id="mname2err" class="rederror"><?php echo $shippay['mother2text'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['successor'][$lng] ?></label>
								<input type="text" id="sucsessor" name="sucsessor" class="form_text margin_right" onkeyup="sucsessorfilter(50)" required="required">
								<a href="" onclick="event.preventDefault()" id="sucsessorhint" class="hint">?</a>
								<div id="sucsessorerr" class="rederror"><?php echo $shippay['successortext'][$lng] ?></div>
							</div>
							<div class="form_item">
								<label for=""><span >*</span> <?php echo $shippay['successor2'][$lng] ?></label>
								
								<input type="text" id="sucsessor2" name="sucsessor2" class="form_text margin_right"onkeyup="sucsessorequal()">
								<a href="" onclick="event.preventDefault()" id="sucsessor2hint" class="hint">?</a>
								<div id="sucsessor2err" class="rederror"><?php echo $shippay['successor2text'][$lng] ?></div>
							</div>
							<div class="block_title" style="font-size:14px; margin-bottom:0px !important;"><?php echo $shippay['promo'][$lng] ?></div>
													
							<div class="form_item form_checkbox">
								<input type="checkbox" class="form_text" name="promomail" id="promomail" checked>
								<label for="promomail"><?php echo $shippay['promo1'][$lng] ?></label>
							
								<input type="checkbox" class="form_text" name="promosms" id="promosms" checked>
								<label for="promosms"><?php echo $shippay['promo2'][$lng] ?></label>
							</div>
							<div class="block_title" style="font-size:14px; margin-bottom:0px !important;"><?php echo $shippay['privacy'][$lng] ?></div>
							<div class="form_item form_checkbox">
								<input type="checkbox" class="form_text" name="termsc" id="termsc" checked>
								<label for="termsc"><?php echo $shippay['accept'][$lng] ?></label>
							</div>
							<div class="form_actions">
								<input type="submit" class="form_submit" value="<?php echo $shippay['placeorder'][$lng] ?>">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?PHP
}
?>
<style>
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
</style>

	
	
