<?PHP

//http://lnsint/ru/signup_shop/pd/23-AZ-724983/1/2/ - link template for return
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

	//print_r($_GET);
	$code=$_GET['cname'];
	$sid=$_GET['child'];
	$ptype=$_GET['child2'];//payment type
	
	switch($ptype) //here we'll insert all possible finance src like paypal,scrill and etc and we'll bind their ids to payment type values;
	{
		case 3: $finsrc=0; break;		//no payment made. will be made in USERPANEL afterwards
		case 6: $finsrc=10; break;	 
	}
	
	$err=0;
	if(!$code or !$sid){$err++;}
	
	$code=explode('-',$code);
	if(count($code)!=3){$err++;}
	
	
	if($err==0)
	{
		$id=$code[0];
		$serial=$code[1].'-'.$code[2];
		
		$sql='select o.* , u.login as ulog from onlinestore o, `user` u where o.id= :id and o.serial=:serial and o.spon_id=u.id limit 1';
		$a=$db->prepare($sql);
		$a->execute(ARRAY('id'=>$id, 'serial' => $serial));
		$ab=$a->fetch(PDO::FETCH_ASSOC);
		$custdata=$ab;
		
		if($ab['id'])
		{
			
			$osid=$ab['id'];
			$custdata=$ab; //customer data for using in e-mail
			
			if($sid==1)
			{
				//getting payment data
				$sql='select * from orders where bask_user_id= :id and ord_src=2 limit 1';
				$a=$db->prepare($sql);
				$a->execute(ARRAY('id'=>$id));
				$ab=$a->fetch(PDO::FETCH_ASSOC);
				
				$total=$ab['basket_total'];
				$curr=$ab['bask_currency'];
				//converting it to real currency(USD)******************************************
				$sql='select * from currency_rates where id in (1,2, :curr)';
				$a=$db->prepare($sql);
				$a->execute(ARRAY('curr'=>$curr));
				$curra=ARRAY();
				while($ab=$a->fetch(PDO::FETCH_ASSOC))
				{
					$cid=$ab['id'];
					$curra[$cid]=$ab;
				}
				if($curr==1)
				{
					$ttlusd=$total;
				}
				else
				{
					$ttlusd=round($total*($curra[$curr]['value']*$curra[$curr]['Nominal'])/($curra[1]['value']*$curra[1]['Nominal']), 2);
				}
				//********************************************************************************
				if($ptype!=3)
				{
					//payment successfull
					
					//update online store status
					$sql='update onlinestore set s_id=2 where id= :id limit 1';
					$a=$db->prepare($sql);
					$a->execute(ARRAY('id'=>$id));
					
					//update orders status
					$sql='update orders set bask_s_id=2 where bask_user_id= :id and ord_src=2 limit 1';
					$a=$db->prepare($sql);
					$a->execute(ARRAY('id'=>$id));
					
					
					
					//finding last row in finance table **********************************************
					$sql='select * from finance order by id desc limit 1';
					$a=$db->prepare($sql);
					$a->execute();
					$ab=$a->fetch(PDO::FETCH_ASSOC);
					//print_r($ab);
					
					//inserting to finance table******************************************************
					
					$balans=round($ab['balans']+$ttlusd,2);
					$sql='insert into finance (`amount`, `balans`, `type`) values (:am , :bl , "1")';
					$a=$db->prepare($sql);
					$a->execute(ARRAY('am'=>$ttlusd , 'bl'=> $balans));
					$fid = $db->lastInsertId();
					//inserting into fin_src table****************************************************
					$sql='INSERT INTO `fin_type` (
					`f_id`, 
					`type`, 
					`real_amount`, 
					`real_currency`, 
					`amount`, 
					`from_id`, 
					`to_id`) VALUES ( 
					:fid, :finsrc, :total, :curr, :ttlusd, :osid, "1")';
					$a=$db->prepare($sql);
					$a->execute(ARRAY('fid'=>$fid , 'finsrc'=> $finsrc , 'total'=> $total , 'curr'=> $curr , 'ttlusd'=> $ttlusd , 'osid'=> $osid  ));
				}
					
				//Getting product names for e-mail************************************************
				
				$sql='select m.name as mad , op.say from orders o, order_prod op, mehsul m where o.bask_user_id= :id and o.ord_src=2 and o.id=op.o_id and op.p_id=m.u_id and m.l_id=:lng ';
				$a=$db->prepare($sql);
				$a->execute(ARRAY('id'=>$id,'lng'=>$lng1 ));
				$prodtxt='';
				while($ab=$a->fetch(PDO::FETCH_ASSOC))
				{
					$prodtxt.=$ab['mad']. ' ( '.$ab['say'].' piece(s) )<br />';
				}
				
				//********************************************************************************
				//creating mail text *************************************************************
				$ftd=$pd['mailtext'][$lng];
				$mailtext="<body><style>.menulink{text-decoration: none;text-transform: uppercase;color: #43b9da;font-size: 16px;font-weight: 700;display: block;line-height: 53px;float:left;margin-right:15px;font-family: museosanscyr, Arial, sans-serif;}.leftplaceholder{display: inline-block;width: 100px;float: left;}.headercontainer{-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);}</style><div class='headercontainer'><table border=0 width='900'><tr><td style='text-align:center'><img src='http://lnsinvest.net/img/logo_email.png' align='center' width='170' style='float:left;margin-right:55px;'><a href='".$site_url.$lng."/menu/about_company/about_lns/' class='menulink'>About Company</a><a href='".$site_url.$lng."/menu/how_it_works/sign_in_procedures/' class='menulink'>How it works</a><a href='".$site_url.$lng."/menu/opportunity/' class='menulink'>Opportunity</a><a href='".$site_url.$lng."/news/' class='menulink'>News</a><a href='".$site_url.$lng."/menu/support/email_support/' class='menulink'>Support</a></td></tr></table></div><br/><div class='headercontainer'><table border=0 width='900'><tr><td width='220' style='border-right: 1px solid rgba(0, 0, 0, 0.08);' valign='top'><img src='http://lnsinvest.net/img/luciana2.jpg' align='center' width='170' style='margin-left:50px;'><br /><br /><div style='margin-left:63px;font-size: 12px;font-family: sans-serif;'>".$pd['amessagefrom'][$lng]."</div></td><td style='color: #363636;font-size: 12px;font-family: sans-serif;padding-left:10px;'>".sprintf($ftd, $custdata['ad'], $custdata['soyad'], $custdata['login'], $custdata['serial'], strtoupper($custdata['ulog']), $total.' '.$curra[$curr]['NAME'], $custdata['mail'], $custdata['phone'], $custdata['mobile'], $custdata['adress_line1'], $prodtxt )."</td></tr></table></div></body>";
					
					//sending mail to customer************************************************************************************************
					
					$xmailx=$custdata['mail'];
					$xnamex=$custdata['ad'].' '.$custdata['soyad'];

					$curl = curl_init();

					curl_setopt_array($curl, [
					  CURLOPT_URL => "https://api.sendinblue.com/v3/smtp/email",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => "{\"sender\":{\"name\":\"LNS INTERNATIONAL\",\"email\":\"no-reply@lnsint.net\"},\"to\":[{\"email\":\"$xmailx\",\"name\":\"$xnamex\"}],\"replyTo\":{\"email\":\"no-reply@lnsint.net\"},\"htmlContent\":\"$mailtext\",\"subject\":\"LNS new registration\"}",
					  CURLOPT_HTTPHEADER => [
						"accept: application/json",
						"api-key: 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",
						"content-type: application/json"
					  ],
					]);

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
					  //echo "cURL Error #:" . $err;
					} else {
					  //echo $response;
}

					
					
					
					//****************************************************************************************************************************	
					//************************Sending SMS message to customer******************************
						// not sending bacause there is no pin yet. must be activated from userpanel
						/*
						$f_name=$custdata['ad'];
						$l_name=$custdata['soyad'];
						$number=$custdata['phone'];
						$sender='LNSINT';
						$text='Dear '.$f_name.' '.$l_name.' ('.custdata['login'].'). Welcome to LNS family. Your registration is successfull. Your Life Account Pin code: '.$pin.' . You can login to your new account from: https://lnsinvest.net 
						Together for better life! ';
						
						$base_url='https://api-mapper.clicksend.com/http/v2/send.php';
						$ukey='D0EF7354-8A58-B2C6-7054-798784137D1B';
						$uname='admin@lnsinvest.net';
						
						
						$ch = curl_init();

						curl_setopt($ch, CURLOPT_URL,$base_url);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS,
									" method=https&username=$uname&key=$ukey&senderid=$sender&to=$number&message=$text");

						// In real life you should use something like:
						// curl_setopt($ch, CURLOPT_POSTFIELDS, 
						//          http_build_query(array('postvar1' => 'value1')));

						// Receive server response ...
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						$server_output = curl_exec($ch);

						curl_close ($ch);
						//echo'<pre>';
						//echo $server_output;
						//echo'</pre>';
						//#####################################################################################
						*/
						
						echo'<script> 
							location.replace("'.$site_url.$lng.'/signup_shop/thankyou/23-AZ-724983/");
						</script>';
				
			}
			elseif($sid==2)
			{
				//payment failed
				?>
				<br>
				<?PHP echo $pd['pymntfail'][$lng] ?>
				<br>
				<br>
				<?PHP
			}
		}
		else
		{
			//error, given data is not correct
			?>
			<br>
			<?PHP echo $pd['dataincorrect'][$lng] ?>
			<br>
			<br>
			<?PHP
		}
	}
	else
	{
		//error, given data is not correct		
		?>
		<br>
		<?PHP echo $pd['dataincorrect'][$lng] ?>
		<br>
		<br>
		<?PHP
	}

?>