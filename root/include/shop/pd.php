<?PHP	ini_set('display_errors', 1);	ini_set('display_startup_errors', 1);	error_reporting(E_ALL);
$shop_type=1; //burda hansi ehsopla ishlediyimizi qeyd edirik (1 e-shop, 2 registration, 3 commission shop)
$ucurr=$_SESSION['u_curr']; //we'll use it in javascript to calculate the price in different format
$pcurr=$_SESSION['countrycurrency']; //we'll use it in javascript to calculate the price in different format

$uid=$_SESSION['id'];
		 
//defining payment type for orders table**********************************************************************************
switch($_SESSION['post_shop_data']['payoption'])
{
	case 1: $payoption=2; break; //lifebank
	case 2: $payoption=1; break; //commision bank
	//digerleri de bura elave olunmalidir
}
//************************************************************************************************************************
$db->beginTransaction(); 

$reg_id=$_SESSION['reg_id'];

//*****MEhsullarin qiymetlerin hesablayiriq********************************************************************************

$xxs=explode('@',$_SESSION['post_shop_data']['pordinfo']);

array_pop($xxs);
$realprodid=ARRAY();
$realprodsay=ARRAY();
$realprodcurr=ARRAY();
$realprodid2='(0';
foreach($xxs as $value)
{
	$value2=explode('|',$value);
	$hhd=$value2[0];
	$realprodid[$hhd]=$value2[0];
	$realprodsay[$hhd]=$value2[3];
	$realprodcurr[$hhd]=$value2[4];
	$realprodid2.=','.$value2[0];
}
$realprodid2.=')';
//print_r($realprodid);

//All country olan mehsullari secirik******************************************************************************************
	$lng01sor=$db->prepare('SELECT * FROM mehsul m where m.s_id="1" and m.u_id in '.$realprodid2.' and m.l_id=:lid and m.all_country="1"  order by ordering asc  ');

	$lng01sor->execute(array('lid'=>$lng1)); 
	
	$products=ARRAY(); //Butun productlar bu massive yigilacaq
	$prodid_arr=ARRAY(); //produkt idlerini bir massive yigiriq

	while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC)) 
	{
		
		$proid=$b['u_id'];
		$products[$proid]=$b;
		$prodid_arr[]=$proid;
		$products[$proid]['currid']=1;
		
	}
	//*******************************************************************************************************************************
	
	// Secilmish olkeye aid olan mehsullar secilir***********************************************************************************
	$lng01sor=$db->prepare('SELECT m.* FROM mehsul m, mehsul_olke mo where m.s_id="1" and m.u_id in '.$realprodid2.'  and m.l_id=:lid and m.u_id=mo.m_u_id and mo.o_u_id= :olke order by m.ordering asc  ');

	$lng01sor->execute(array('lid'=>$lng1 , 'olke'=>$_SESSION['country'] )); 
	

	while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC)) 
	{
		
		$proid=$b['u_id'];
		$products[$proid]=$b;
		$prodid_arr[]=$proid;
		$products[$proid]['currid']=1;
		
	}
	//*********************************************************************************************************************************
	
	//Secilmish olke ucun olan xususi qiymetleri cixardiriq****************************************************************************
	
	$lng01sor=$db->prepare('SELECT mop.*, c.short_name, c.u_id as currid FROM mehsul_olke_price mop , currency c, olkeler o where  mop.o_u_id= :olke and o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang');

	$lng01sor->execute(array( 'olke'=>$_SESSION['country'], 'lang'=>$lng1 )); 
	

	while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC)) 
	{
		
		$proid=$b['m_u_id'];
		if(@$products[$proid])
		{
			$products[$proid]['price_1']=$b['price_1'];
			$products[$proid]['price_2']=$b['price_2'];
			$products[$proid]['price_3']=$b['price_3'];
			$products[$proid]['shipping_1']=$b['shipping_1'];
			$products[$proid]['shipping_2']=$b['shipping_2'];
			$products[$proid]['shipping_3']=$b['shipping_3'];
			$products[$proid]['countryid']=$_SESSION['country'];
			$products[$proid]['currid']=$b['currid'];
			$products[$proid]['short_name']=$b['short_name'];
		}		
	}
	
	
	//*********************************************************************************************************************************
	
	//EGER discount varsa onu da hesablayib elave edirik*******************************************************************************
	$idss=implode(',',$prodid_arr);
	
	$lng01sor=$db->prepare('SELECT md.* FROM mehsul_discount md where  m_u_id in (:idss) and s_id=1 and shop_type=:shop_type and (mop_id=0 or mop_id=:country)');

	$lng01sor->execute(array( 'country'=>$_SESSION['country'], 'idss'=>$idss, 'shop_type'=>$shop_type )); 
	

	while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC)) 
	{
		$proid=$b['m_u_id'];
		if($products[$proid] and ($products[$proid]['countryid']==$b['mop_id'] or (!$products[$proid]['countryid'] and $b['mop_id']=0)))
		{
			$prname='price_'.$b['shop_type'];	//hansi qiymete endirim edeceyimizi tapiriq
			if($b['type']==1)//endirim tipine gore hesablama edim endirimli qiymeti elave edirik
			{
				$priced=ceil($products[$proid][$prname]*(100-$b['value'])/100);
			}
			else
			{
				$priced=$products[$proid][$prname]-$b['value'];
			}
			//massive melumatlari elave edirik
			
			$products[$proid]['discount']=$b['value'];
			$products[$proid]['disc_price']=$priced;
		}
	}
	//*********************************************************************************************************************************
	

	//Butun mehsul qiymetlerini secilmish olkenin currency-sine ceviririk***************************************************************
	$lng01sor=$db->prepare('SELECT c.short_name, c.u_id as currid FROM  currency c, olkeler o where  o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang');

	$lng01sor->execute(array( 'olke'=>$_SESSION['country'], 'lang'=>$lng1 ));
	
	$bi=$lng01sor->fetch(PDO::FETCH_ASSOC);
	
	
	//butun currency rates secilib arraya salinir******************************
	$lng01sor=$db->prepare('SELECT * FROM  currency_rates');

	$lng01sor->execute();
	$cr=ARRAY();
	while($bcr=$lng01sor->fetch(PDO::FETCH_ASSOC))
	{
		$crid=$bcr['id'];
		$cr[$crid]=$bcr;
	}
	//*************************************************************************
	
	foreach ($products as $key => $val) 
	{
		if(@$products[$key]['countryid']) // eger country id varsa problem yoxdur
		{
		}
		else //yoxdursa qiymetler konvert olunmalidir
		{
			
			if($products[$key]['currid']==$bi['currid'])//eger hal hazir ki valyuta novu secilmish olke ile eynidirse hecne etmirik
			{
				
			}
			else //eger ferqlidirse qiymet hesablanir. ve valyuta novu elave olunur
			{
				
				$t1=$products[$key]['currid'];
				$t2=$bi['currid'];
				$prname='price_'.$shop_type;
				$shname='shipping_'.$shop_type;
				$products[$key][$prname]=currconverter($db,$products[$key][$prname],$t1,$t2); //price hesablanir
				$products[$key][$shname]=currconverter($db,$products[$key][$shname],$t1,$t2); //shipping hesablanir
				
				if(@$products[$key]['disc_price'])//eger discount varsa o da hesablanir
				{
					$products[$key]['disc_price']=currconverter($db,$products[$key]['disc_price'],$t1,$t2); //price hesablanir
				
				}
				
				$products[$key]['countryid']=$_SESSION['country'];
				$products[$key]['currid']=$bi['currid'];
				$products[$key]['short_name']=$bi['short_name'];
			}
			
		}
	}
//print_r($products);

$total=0;
foreach($products as $key=>$value)
{
	if(@$value['discount']){ $p=$value['disc_price']; } else {	$p=$value['price_1'];	}
	$s=$value['shipping_1'];
	$total+=($p+$s)*$realprodsay[$key];
	$curr=$value['currid'];
}
//*************************************************************************************************************************

//echo $total;

if(is_numeric($total))
{
	
	//butun currency rates secilib arraya salinir******************************
	$lng01sor=$db->prepare('SELECT * FROM  currency_rates');

	$lng01sor->execute();
	$cr=ARRAY();
	while($bcr=$lng01sor->fetch(PDO::FETCH_ASSOC))
	{
		$crid=$bcr['id'];
		$cr[$crid]=$bcr;
	}
	//*************************************************************************
	$t1=$_SESSION['countrycurrency'];
	$t2=$_SESSION['u_curr'];
	$ucurrname=$cr[$t2]['NAME'];
	if($t1==$t2)//eger hal hazir ki valyuta novu secilmish olke ile eynidirse hecne etmirik
	{
		$amount=$total;
	}
	else //eger ferqlidirse qiymet hesablanir. ve valyuta novu elave olunur
	{
						
		$amount=currconverter($db,$total,$t1,$t2,2); //price hesablanir
	}
	
	
	
	//finding product value in USD because it will be sent to the main user(system) ********************
	
	$t1=$_SESSION['countrycurrency'];
	$t2=1;
	
	if($t1==$t2)//eger hal hazir ki valyuta novu secilmish olke ile eynidirse hecne etmirik
	{
		$lnsamount=$total;
	}
	else //eger ferqlidirse qiymet hesablanir. ve valyuta novu elave olunur
	{
						
		$lnsamount=currconverter($db,$total,$t1,$t2,2); //price hesablanir
	}
	
	//**************************************************************************************************
}
//echo $amount;
$_SESSION['post_reg_data']['amount']=$amount;

$a=$db->prepare('SELECT * from `olkeler` where  `l_id` =1 and kat_id=:olke limit 1');

$a->execute(ARRAY( 'olke' => $_SESSION['country']));
$ab=$a->fetch(PDO::FETCH_ASSOC);



$serial=substr($ab['name'], 0,2);
$serial=strtoupper($serial);
$pas='';
for($i=1; $i<=2; $i++)
{
	$b=rand(100,999);
	@$pas.=$b;
}
$serial=$serial.'-'.$pas;
$_SESSION['post_reg_data']['serial']=$serial;
$error=0;
$errortype=ARRAY();




// name filter************************

	$_SESSION['post_reg_data']['fname'] = str_replace(' ', '', $_SESSION['post_reg_data']['fname']); // Replaces all spaces with hyphens.

	$_SESSION['post_reg_data']['fname'] = preg_replace('/[^A-Za-z0-9]/', '', $_SESSION['post_reg_data']['fname']); // Removes special chars.

	if(strlen($_SESSION['post_reg_data']['fname'])<3 or strlen($_SESSION['post_reg_data']['fname'])>20)
	{
		$error=4;
		$errortype[]=4; // first name lenth is not correct
	}


	$_SESSION['post_reg_data']['fname']=strtolower($_SESSION['post_reg_data']['fname']);
	$_SESSION['post_reg_data']['fname']=ucfirst($_SESSION['post_reg_data']['fname']);
//*********************************************************************

//  surname filter************************

	$_SESSION['post_reg_data']['lname'] = str_replace(' ', '', $_SESSION['post_reg_data']['lname']); // Replaces all spaces with hyphens.

	$_SESSION['post_reg_data']['lname'] = preg_replace('/[^A-Za-z0-9]/', '', $_SESSION['post_reg_data']['lname']); // Removes special chars.

	if(strlen($_SESSION['post_reg_data']['lname'])<3 or strlen($_SESSION['post_reg_data']['lname'])>40)
	{
		$error=5;
		$errortype[]=5; // first name lenth is not correct
	}


	$_SESSION['post_reg_data']['lname']=strtolower($_SESSION['post_reg_data']['lname']);
	$_SESSION['post_reg_data']['lname']=ucfirst($_SESSION['post_reg_data']['lname']);
//*********************************************************************




$phn=$_SESSION['post_reg_data']['pref1'].$_SESSION['post_reg_data']['phone'];
$mbl=$_SESSION['post_reg_data']['pref2'].$_SESSION['post_reg_data']['mobile'];

//print_r($errortype);


	$sql=$db->prepare(
	"INSERT INTO `eshop` 
	(
		`id`, 
		`ad`, 
		`soyad`,
		`cins`, 
		`d_tarixi`, 
		`adress_line1`, 
		`adress_line2`, 
		`post_code`, 
		`country`, 
		`national_id`, 
		`city`, 
		`state`, 
		`phone`, 
		`mobile`, 
		`mail`, 
		`s_id`, 
		`date`, 
		`u_id`) 
		VALUES (
		NULL, 
		:ad , 
		:soyad , 
		:cins , 
		:d_tarixi ,
		:adress_line1 , 
		:adress_line2 , 
		:post_code , 
		:country , 
		:national_id , 
		:city , 
		:state , 
		:phone , 
		:mobile , 
		:mail , 
		1 , 
		CURRENT_DATE() , 
		:u_id )");

		$sql->execute(ARRAY(
		'ad'=>$_SESSION['post_reg_data']['fname'],
		'soyad'=>$_SESSION['post_reg_data']['lname'],
		'cins'=>$_SESSION['post_reg_data']['gender'],
		'd_tarixi'=>$_SESSION['post_reg_data']['dob'],
		'adress_line1'=>$_SESSION['post_reg_data']['adr1'],
		'adress_line2'=>$_SESSION['post_reg_data']['adr2'],
		'post_code'=>$_SESSION['post_reg_data']['zip'],
		'country'=>$_SESSION['country'],
		'national_id'=>$_SESSION['post_reg_data']['national'],
		'city'=>$_SESSION['post_reg_data']['city'],
		'state'=>$_SESSION['post_reg_data']['state'],
		'phone'=>$phn,
		'mobile'=>$mbl,
		'mail'=>$_SESSION['post_reg_data']['mail'],
		'u_id'=>$_SESSION['id']
		));	
	
  $newu_id = $db->lastInsertId();	
	

	
	$sql2=$db->prepare("INSERT INTO `orders` (
	`id`, 
	`bask_user_id`, 
	`bask_orddate`, 
	`ord_src`, 
	`bask_s_id`, 
	`basket_total`, 
	`bask_currency`, 
	`bask_adress`, 
	`bask_tel`, 
	`bask_mob`, 
	`bask_fname`, 
	`bask_lname`, 
	`bask_zip`, 
	`bask_state`, 
	`bask_mail`, 
	`bask_city`, 
	`bask_country`, 
	`payment_type`) 
	VALUES 	(
	NULL , 
	:osid , 
	CURRENT_DATE() , 
	'1' , 
	'2' , 
	:total , 
	:curr , 
	:adr1 , 
	:tel , 
	:mobile , 
	:fname , 
	:lname , 
	:zip , 
	:state , 
	:mail , 
	:city , 
	:country ,
	:payoption)");
	
	
	$sql2->execute(ARRAY(
	'osid'=>$newu_id,
	'fname'=>$_SESSION['post_reg_data']['fname'],
	'lname'=>$_SESSION['post_reg_data']['lname'],
	'total'=>$total,
	'curr'=>$curr,
	'adr1'=>$_SESSION['post_reg_data']['adr1'],
	'tel'=>$phn,
	'mobile'=>$mbl,
	'zip'=>$_SESSION['post_reg_data']['zip'],
	'state'=>$_SESSION['post_reg_data']['state'],
	'city'=>$_SESSION['post_reg_data']['city'],
	'mail'=>$_SESSION['post_reg_data']['mail'],
	'country'=>$_SESSION['country'],
	'payoption'=>$payoption
	));
	
	
	
 $ordid = $db->lastInsertId();	
 
 $sql3=$db->prepare("
	INSERT INTO `order_prod` (
	`id`, 
	`o_id`, 
	`p_id`, 
	`c_id`, 
	`price`, 
	`ship`, 
	`say`) 
	VALUES (
	NULL, 
	:ordid, 
	:pid, 
	:cid, 
	:price, 
	:ship, 
	:count)");

//create array for function******************
$prodarray=ARRAY();
//*******************************************
foreach($products as $key=>$value)
{
	//adding value to prodarray for futher processing in updRPCount**************
	$prodarray[]=ARRAY($value['u_id'],$realprodsay[$key]);
	//***************************************************************************
	if(@$value['discount']){ $p=$value['disc_price']; } else {	$p=$value['price_2'];	}
	
	$sql3->execute(ARRAY(
	'ordid'=>$ordid,
	'pid'=>$value['u_id'],
	'cid'=>$value['currid'],
	'price'=>$p,
	'ship'=>$value['shipping_2'],
	'count'=>$realprodsay[$key]
	));
}


insertOrderStockRp($db,$ordid);
updRPCount($db,$prodarray);
	//#####################################################################################
	
	if($error>0 or !$sql or !$sql2 or !$sql3)
	{
		$db->rollBack();
		$sql8=$db->prepare('UPDATE `reg_steps` SET `s_id` = "5" WHERE `id` ="'.$_SESSION['reg_id'].'" limit 1');		
		$sql8->execute(ARRAY());
		//should be redirected to error page 
		//exit();
		
	}
	else
	{
		$sql8=$db->prepare('UPDATE `reg_steps` SET `s_id` = "4" WHERE `id` ="'.$_SESSION['reg_id'].'" limit 1');		
		$sql8->execute(ARRAY());
		$db->commit();
	}
	
	
	
	//Getting product names for e-mail************************************************
				
	$sql='select m.name as mad , op.say from orders o, order_prod op, mehsul m where o.bask_user_id= :id and o.ord_src=3 and o.id=op.o_id and op.p_id=m.u_id and m.l_id=:lng ';
	$a=$db->prepare($sql);
	$a->execute(ARRAY('id'=>$newu_id,'lng'=>$lng1 ));
	$prodtxt='';
	while($ab=$a->fetch(PDO::FETCH_ASSOC))
	{
		$prodtxt.=$ab['mad']. ' ( '.$ab['say'].' piece(s) )<br />';
	}

	//********************************************************************************
	//creating mail text *************************************************************
	
	$phone=$_SESSION['post_reg_data']['pref1'].$_SESSION['post_reg_data']['phone'];
	$mobile=$_SESSION['post_reg_data']['pref1'].$_SESSION['post_reg_data']['mobile'];
	$ftd=$pd['mailtext'][$lng];
	$mailtext="<body><style>.menulink{text-decoration: none;text-transform: uppercase;color: #43b9da;font-size: 16px;font-weight: 700;display: block;line-height: 53px;float:left;margin-right:15px;font-family: museosanscyr, Arial, sans-serif;}.leftplaceholder{display: inline-block;width: 100px;float: left;}.headercontainer{-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);}</style><div class='headercontainer'><table border=0 width='900'><tr><td style='text-align:center'><img src='http://lnsinvest.net/img/logo_email.png' align='center' width='170' style='float:left;margin-right:55px;'><a href='".$site_url.$lng."/menu/about_company/about_lns/' class='menulink'>About Company</a><a href='".$site_url.$lng."/menu/how_it_works/sign_in_procedures/' class='menulink'>How it works</a><a href='".$site_url.$lng."/menu/opportunity/' class='menulink'>Opportunity</a><a href='".$site_url.$lng."/news/' class='menulink'>News</a><a href='".$site_url.$lng."/menu/support/email_support/' class='menulink'>Support</a></td></tr></table></div><br/><div class='headercontainer'><table border=0 width='900'><tr><td width='220' style='border-right: 1px solid rgba(0, 0, 0, 0.08);' valign='top'><img src='http://lnsinvest.net/img/luciana2.jpg' align='center' width='170' style='margin-left:50px;'><br /><br /><div style='margin-left:63px;font-size: 12px;font-family: sans-serif;'>".$pd['amessagefrom'][$lng]."</div></td><td style='color: #363636;font-size: 12px;font-family: sans-serif;padding-left:10px;'>".sprintf($ftd, $_SESSION['post_reg_data']['fname'], $_SESSION['post_reg_data']['lname'], $_SESSION['login'], $serial, strtoupper($_SESSION['login']), $total.' '.$ucurrname, $_SESSION['post_reg_data']['mail'], $phone, $mobile, $_SESSION['post_reg_data']['adr1'], $prodtxt )."</td></tr></table></div></body>";
	
				
		
	//sending mail to customer************************************************************************************************
	$xmailx=$_SESSION['post_reg_data']['mail'];
	$xnamex=$_SESSION['post_reg_data']['fname'].' '.$_SESSION['post_reg_data']['lname'];

	$curl = curl_init();

	curl_setopt_array($curl, [
	  CURLOPT_URL => "https://api.sendinblue.com/v3/smtp/email",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "{\"sender\":{\"name\":\"LNS INTERNATIONAL\",\"email\":\"no-reply@lnsint.net\"},\"to\":[{\"email\":\"$xmailx\",\"name\":\"$xnamex\"}],\"replyTo\":{\"email\":\"no-reply@lnsint.net\"},\"htmlContent\":\"$mailtext\",\"subject\":\"LNS new product purchase\"}",
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
	
		
	if ($err) 
	{
		$sql8=$db->prepare('UPDATE `reg_steps` SET `s_id` = "7" WHERE `id` ="'.$_SESSION['reg_id'].'" limit 1');		
		$sql8->execute(ARRAY());
		//echo $err;
		//here it should redirect to error page
		echo '
		<script> 
			localStorage.clear();
			location.replace("'.$site_url.$lng.'/shop/thankyou/");
		</script>';//this temporary should be removed in production server
	} 
	else 
	{
		$sql8=$db->prepare('UPDATE `reg_steps` SET `s_id` = "6" WHERE `id` ="'.$_SESSION['reg_id'].'" limit 1');		
		$sql8->execute(ARRAY());
		echo '
		<script> 
			localStorage.clear();
			location.replace("'.$site_url.$lng.'/shop/thankyou/");
		</script>';
	}
		
		
?>