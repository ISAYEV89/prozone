<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title"><?PHP echo $lostpassword['title'][$lng]; ?></h1>
			</div>
			<div class="middle_content">
				<?PHP
				
				$ref=$site_url.$lng.'/lostpassword/verify/';
				//check referer page and post data
				if($_SERVER['HTTP_REFERER']==$ref and $_POST['sbmt'])
				{
					//check code from database
					$code=$_POST['td1'].$_POST['td2'].$_POST['td3'].$_POST['td4'];
					$a=$db->prepare('SELECT * from `lostpassword` where  `code` =:mailx and s_id=1 and timestampdiff(MINUTE, `time`, now())<5 limit 1');
					$a->execute(ARRAY('mailx'=>$code));
					$abc=$a->fetch(PDO::FETCH_ASSOC);
					if($abc['id'])
					{
						$a=$db->prepare('update `lostpassword` set s_id=2 where  `id` =:mailx and s_id=1 limit 1');//updating line to used
						$a->execute(ARRAY('mailx'=>$abc['id']));
						$uid=$abc['u_id'];
						
						$a=$db->prepare('SELECT `id`, `login`, `serial`, `ad`, `soyad`, `mail` from `user` where  `id` =:mailx limit 1'); // selecting user information
						$a->execute(ARRAY('mailx'=>$uid));
						$user=$a->fetch(PDO::FETCH_ASSOC);
						//print_r($user);
						//show form
				?>
				<div class="order_form user_settings" id="td_formdiv">
					<div class="form_item" style="text-align:center;">
						<h3 style="text-align:center;">
							<?PHP echo $lostpassword['enterpassword'][$lng]; ?>
						</h3>
					</div>
					<form action="" method="post"  onsubmit="return validateme()">
						<div class="form_item" style="text-align:center;">
							<input type="hidden" name="uid" id="uid" value="<?PHP echo $user['id']; ?>">
						</div>
						
						<div class="form_item" style="    line-height: 32px;">
							<label for=""><?PHP echo $lostpassword['userinfo'][$lng]; ?></label>
							<?PHP echo $user['ad'].' '.$user['soyad'].' - '.$user['login'].' ['.$user['serial'].']'; ?>
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
						<br>
						<div style="text-align:center;">
							<input type="submit" name="sbmtupd" value="<?PHP echo $lostpassword['confirm'][$lng]; ?>" style="min-height: 48px;    -webkit-box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    background: #43b9da;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);  cursor:pointer;  font-size: 24px;    font-weight: 300;    border: none;    width: 270px;    color: #fff; padding:7px;  line-height: 30px; margin:0px auto;" />
								
						</div>
					</form>
				</div>			
				<?PHP
					}
					else
					{
						//code expired or no code
						?>
						<div class="order_form user_settings" id="td_formdiv">
							<div class="form_item" style="text-align:center;">
								<h3 style="text-align:center;">
									<?PHP echo $lostpassword['codeerrorhead'][$lng]; ?>
								</h3>
							</div>
							<br>
							<div class="form_item" style="text-align:center;">							
								<?PHP echo $lostpassword['codeerror'][$lng]; ?>
							</div>
							<br>
							<div style="text-align:center;">
								<Div style="min-height: 48px;    -webkit-box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    background: #43b9da;
			text-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);  cursor:pointer;  font-size: 24px;    font-weight: 300;    border: none;    width: 270px;    color: #fff; padding:7px;  line-height: 30px; margin:0px auto;" id="backBtn">
									<?PHP echo $lostpassword['backbtn2'][$lng]; ?>
								</div>
							</div>
						</div>			
						<?PHP
					}
				}
				elseif($_POST['sbmtupd'])
				{
					$a=$db->prepare('SELECT `id`, `login`, `serial`, `ad`, `soyad`, `mail` from `user` where  `id` =:mailx limit 1'); // selecting user information
					$a->execute(ARRAY('mailx'=>$_POST['uid']));
					$user=$a->fetch(PDO::FETCH_ASSOC);
					//print_r($_POST);
					$_POST['pass']=passme($_POST['pass']);
					
					//update the fuckin password
					$a=$db->prepare('update `user` set pass=:ps, pass_real= :psr where  `id` = :uid limit 1');

					$a->execute(ARRAY('ps'=>$_POST['pass'],'psr'=>$_POST['pass2'],'uid'=>$_POST['uid']));
					$a=$db->prepare('update `lostpassword` set s_id=5 where  `u_id` =:mailx and s_id=2 limit 1');//updating line to used
					$a->execute(ARRAY('mailx'=>$_POST['uid']));
					//prepare the fuckin e-mail
					
					$emailtext='
					<table style="border:1px solid gray; min-width:600px;max-width:600px;">
						<tr>
							<td style="padding:10px;">
								<img src="'.$site_url.'images/logo_email.png" alt="LNS | Together for better life" title="LNS | Together for better life" style="float:left; width:160px;">
							</td>
						</tr>
						<tr>
							<td style="padding:10px;text-align:center;padding-top:30px;" >
								<img src="'.$site_url.'images/mail.png" alt="LNS | Together for better life" title="LNS | Together for better life" style="margin:0px auto; width:50px;">
							</td>
						</tr>
						<tr>
							<td style="padding:10px;text-align:center;" >
								<H2>'.$lostpassword['forgotyp'][$lng].'</H2>
							</td>
						</tr>
						<tr>
							<td style="padding:40px;text-align:center;" >
								'.$lostpassword['emailtext'][$lng].'
							</td>
						</tr>
						<tr>
							<td style="padding:10px;text-align:center;" >
								<span style="text-align:center; margin:0px auto; padding:15px; 
								background:#43b9da; color:white; width:200px; height:30px;
								font-size:20px; font-weight:bold;">'.$_POST['pass2'].'</span>
								<br />
								<br />
								<br />
								<hr>
								
								<small>'.$lostpassword['donotreply'][$lng].'</small>
							</td>
						</tr>
					</table>';
					//echo $emailtext;
					//send the fuckin e-mail
					//Email gonderilir#####################################################################
					
					$to      =	$user['mail'];//maile  mektubun gonderilmesi
					$subject = $ab['login'].': Your new LNS password';
					$headers = 'From: support@lnsint.net' . "\r\n" .
					'Reply-To: support@lnsint.net' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
					$headers .= 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					mail($to, $subject, $emailtext, $headers);
					//#####################################################################################
					//send the fuckin user to thank you page
					
					echo '
					<script> 
						location.replace("'.$site_url.$lng.'/lostpassword/thankyou/");
					</script>';
					
					
				}
				?>
				
			</div>
		</div>
	</div>
</div>


<style>
.form_item {
    /*margin-bottom: 30px;*/
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
	margin-right:12px;
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
function passfilter()
	{
		var lg=document.getElementById("pass").value;
		var spn = document.getElementById("passhint");
		var element = document.getElementById("pass");
		var reg= /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
		
		if (lg.match(reg))
		{
			element.classList.remove("error");
			spn.classList.remove("hinterror");
			spn.innerHTML = '?' ; 
			window.value411=0;
		}
		else
		{
			spn.innerHTML = '!' ;
			element.classList.add("error");
			spn.classList.add("hinterror"); 
			window.value411=1;
			
		}
	}
	
	function passequal()
	{
		var lg=document.getElementById("pass").value;
		var lg2=document.getElementById("pass2").value;
		var spn = document.getElementById("pass2hint");
		var element = document.getElementById("pass2");
		
		if (lg==lg2)
		{
			element.classList.remove("error");
			spn.classList.remove("hinterror");
			spn.innerHTML = '?' ; 
			window.value412=0;
		}
		else
		{
			spn.innerHTML = '!' ;
			element.classList.add("error");
			spn.classList.add("hinterror"); 
			window.value412=1;
			
		}
	}
	function validateme()
	{
		if(window.value411==0 && window.value412==0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	$('#backBtn').click(function()
	{
		location.replace("<?PHP echo $site_url.$lng.'/lostpassword/'; ?>");
	});
</script>


