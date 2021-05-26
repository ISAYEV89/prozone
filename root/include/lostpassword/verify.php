
<?PHP
//**************************strong password generator******************************************************
 	function generateStrongPassword($length = 4, $add_dashes = false, $available_sets = 'ud')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';

	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}

	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];

	$password = str_shuffle($password);

	if(!$add_dashes)
		return $password;

	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}
//***********************************************************************************************************
	//if($_SERVER["HTTP_REFERER"]!=$site_url.$lng.'/lostpassword/'){exit;}
	
	if($_POST['la_email'] && $_POST['la_login'])
	{
		$email=$_POST['la_email'];
		$login=$_POST['la_login'];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
		  $emailErrMsg = $lostpassword['emailErrMsg1'][$lng];
		  //burda e-mailin sehf oldugu haqqinda metn cixacaq
		  $emailErr=1;
		}
		elseif($email=='')
		{
			$emailErrMsg = $lostpassword['emailErrMsg1'][$lng];
			$emailErr=1;
		}
		else
		{
			$a=$db->prepare('SELECT * from `user` where  `mail` =:mailx and login= :login limit 1');

			$a->execute(ARRAY('mailx'=>$email, 'login' => $login));

			$ab=$a->fetch(PDO::FETCH_ASSOC);
			
			if(!$ab['id'])
			{
				$emailErrMsg = $lostpassword['emailErrMsg2'][$lng];
				$emailErr=2;
			}
			else
			{
				
				$code=generateStrongPassword();
				$a=$db->prepare('SELECT * from `lostpassword` where  `u_id` =:mailx and s_id in (1,3) limit 1');
				$a->execute(ARRAY('mailx'=>$ab['id']));
				$abc=$a->fetch(PDO::FETCH_ASSOC);
				if($abc['id'])//updating next attempt
				{
					$lpw_id=$abc['id'];
					$aat=$db->prepare('SELECT * from `lostpassword` where  `u_id` =:mailx and s_id=4 limit 1');
					$aat->execute(ARRAY('mailx'=>$abc['u_id']));
					$abd=$aat->fetch(PDO::FETCH_ASSOC);
					//print_r($abd);
					if($abd['attempt'])//if attempt count more than 3, dont update and dont show any form just show the counter. 3 hours block time
					{
						$attempterror=1;
					}
					elseif($abc['attempt']>=2) //else if attempt limit reached just now, update the row and throw the error
					{
						$aat=$db->prepare('update `lostpassword` set `attempt`=`attempt`+1, s_id=4, `time`=now() where  `id` =:mailx limit 1');
						$aat->execute(ARRAY('mailx'=>$lpw_id));						
						$attempterror=1;
					}
					else
					{
						$aat=$db->prepare('update `lostpassword` set `attempt`=`attempt`+1, code="'.$code.'", `time`=now() where  `id` =:mailx limit 1');
						$aat->execute(ARRAY('mailx'=>$lpw_id));
					}
					
				}
				else // new request. insert new line 
				{
					$aat=$db->prepare("INSERT INTO `lostpassword` (`id`, `u_id`, `code`, `time`, `attempt`, `s_id`) VALUES (NULL, '".$ab['id']."', '$code', CURRENT_TIMESTAMP, '0', '1');");
					$aat->execute();
				}
				
				
				//************************Sending SMS message to customer******************************	
				
				$f_name=$ab['ad'];
				$l_name=$ab['soyad'];
				$number=$ab['mobile'];
				$sender='LNSINT';
				$text='code: '.$code.' .  Dear '.$f_name.' '.$l_name.' ('.$ab['login'].'). this is your temporary code for password reset. its active for 30:00.';
				$base_url='https://api-mapper.clicksend.com/http/v2/send.php';
				$ukey='9DEAACFA-1356-86FB-1982-C408EFD103AA';
				$uname='admin@lnsint.net';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$base_url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS," method=https&username=$uname&key=$ukey&senderid=$sender&to=$number&message=$text");
				// In real life you should use something like:		
				// curl_setopt($ch, CURLOPT_POSTFIELDS, 		
				//          http_build_query(array('postvar1' => 'value1')));
				// Receive server response ...		
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec($ch);
				curl_close ($ch);
				
				//#####################################################################################
				
				
			}
			
		}
		
	}
	else
	{
		
		$emailErrMsg = $lostpassword['emailErrMsg1'][$lng];
		$emailErr=1;
	}

?>


<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title"><?PHP echo $lostpassword['title'][$lng]; ?></h1>
			</div>
			<div class="middle_content">
				<?PHP
					if($emailErr>=1)
					{
						?>
						<div class="order_form user_settings">
							<div class="form_item" style="text-align:center;">
								<h3 style="text-align:center;">
								<?PHP echo $emailErrMsg; ?>
								</h3>
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
					elseif($attempterror>=1)
					{
						?>
						<br>
						<div class="order_form user_settings">
							<div class="form_item" style="text-align:center;">
								<h3 style="text-align:center;">
								<?PHP echo $lostpassword['attempterror'][$lng]; ?>
								</h3>
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
					else
					{
						?>
						<br>
						<div class="order_form user_settings" id="td_formdiv">
							<div class="form_item" style="text-align:center;">
								<h3 style="text-align:center;">
									<?PHP echo $lostpassword['3Dsecuretext'][$lng]; ?>
								</h3>
							</div>
							<form action="<?PHP echo $site_url.$lng.'/lostpassword/update/' ?>" method="post">
								<div class="form_item" style="text-align:center;">
									<input type="text" name="td1" id="td1" maxlength="1" class="tdinput">
									<input type="text" name="td2" id="td2" maxlength="1" class="tdinput">
									<input type="text" name="td3" id="td3" maxlength="1" class="tdinput">
									<input type="text" name="td4" id="td4" maxlength="1" class="tdinput">
								</div>
								
								<div class="form_item" style="text-align:center;">
									<div id="counter" style="color:red;"></div>
								</div>
								<br>
								<div style="text-align:center; margin-left:0px !important;"  class="form_actions">
									<input type="submit" name="sbmt" value="<?PHP echo $lostpassword['confirm'][$lng]; ?>" class="form_submit" />
										
								</div>
								<br>
								<div class="form_item" style="text-align:center;">
									<?PHP echo $lostpassword['3Dsecurerefresh'][$lng];?>
								</div>
							</form>
						</div>
						
						<div class="order_form user_settings" id="td_expireddiv" style="display:none;">
							<div class="form_item" style="text-align:center;">
								<h3 style="text-align:center;">
									<?PHP echo $lostpassword['expired'][$lng]; ?>
								</h3>
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
				?>
			
			</div>
		</div>
	</div>
</div>
<style>
	.tdinput
	{
		width: 40px;
		margin: 10px;
		border-style: solid;
		height: 40px;
		text-align: center;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		font-size: 16px;
		border-color: #43b9da;
		color: #43b9da;
	}
</style>

<script src="<?php echo $site_url; ?>js/jquery.js"></script>


<script>
	$( "#td1" ).keyup(function() {
	var xx=$("#td1").val();
	var n = xx.length;
	if(n===0)
	{
		
	}
	else
	{
		var xy=xx.toUpperCase();
		$("#td1").val(xy);
		$("#td2").focus();
	}
});
	$( "#td2" ).keyup(function() {
	var xx=$("#td2").val();
	var n = xx.length;
	if(n===0)
	{
		$("#td1").focus();
	}
	else
	{
		var xy=xx.toUpperCase();
		$("#td2").val(xy);
		$("#td3").focus();
	}
});
	$( "#td3" ).keyup(function() {
	var xx=$("#td3").val();
	
	var n = xx.length;
	if(n===0)
	{
		$("#td2").focus();
	}
	else
	{
		var xy=xx.toUpperCase();
		$("#td3").val(xy);
		$("#td4").focus();
	}
});
	$( "#td4" ).keyup(function() {
	var xx=$("#td4").val();	
	var n = xx.length;
	if(n===0)
	{
		$("#td3").focus();
	}
	else
	{
		var xy=xx.toUpperCase();
		$("#td4").val(xy);
		//$("#td2").focus();
	}
});


	$('#backBtn').click(function()
	{
		location.replace("<?PHP echo $site_url.$lng.'/lostpassword/'; ?>");
	});

	function goback()
	{
		event.preventDefault();
		location.replace("<?PHP echo $site_url.$lng.'/lostpassword/'; ?>");
	};
</script>

<script>
// Set the date we're counting down to
var countDownDate = new Date("Jan 18, 2021 16:55:25").getTime();

var distance = "300000";
// Update the count down every 1 second
var x = setInterval(function() {
	
distance -="1000";
  // Get today's date and time

  // Find the distance between now and the count down date
  //console.log(distance);

  // Time calculations for days, hours, minutes and seconds
  //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  //var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  //document.getElementById("counter").innerHTML = days + "d " + hours + "h "
  //+ minutes + "m " + seconds + "s ";
  if( document.getElementById("counter") !== null) {
    document.getElementById("counter").innerHTML = minutes + "m " + seconds + "s ";
  }


  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
	document.getElementById("td_formdiv").style.display = "none";
	document.getElementById("td_expireddiv").style.display = "block";
    
  }
}, 1000);
</script>