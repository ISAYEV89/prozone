<?PHP
 ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL); 

 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$shop_type=2; //burda hansi ehsopla ishlediyimizi qeyd edirik (1 e-shop, 2 registration, 3 commission shop)
if($_SERVER["HTTP_REFERER"]!=$site_url.$lng.'/signup_shop/review/')// check refering page
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


	$a=$db->prepare('SELECT * from `olkeler` where  `l_id` =1 and kat_id=:olke limit 1');
	$a->execute(ARRAY( 'olke' => $_SESSION['signup_country_id']));
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
	$error=0;
	$errortype=ARRAY();

	//setting login filters************************************************

	   $_SESSION['post_reg_data']['login'] = str_replace(' ', '', $_SESSION['post_reg_data']['login']); // Replaces all spaces with hyphens.
	   $_SESSION['post_reg_data']['login'] = preg_replace('/[^A-Za-z0-9\_]/', '', $_SESSION['post_reg_data']['login']); // Removes special chars.
		if(strlen($_SESSION['post_reg_data']['login'])<3 or strlen($_SESSION['post_reg_data']['login'])>20)
		{
			$error=1;
			$errortype[]=1; // login lenth is not correct
		}
		$a=$db->prepare('SELECT * from `user` where  `login` = :mailx limit 1');
		$a->execute(ARRAY('mailx'=>$_SESSION['post_reg_data']['login']));
		$ab=$a->fetch(PDO::FETCH_ASSOC);	
		if($ab['serial'])
		{		
			$error=1;
			$errortype[]=2; // login already taken
		}
		
		$a=$db->prepare('SELECT * from `onlinestore` where  `login` =:mailx limit 1');
		$a->execute(ARRAY('mailx'=>$_SESSION['post_reg_data']['login']));
		$ab=$a->fetch(PDO::FETCH_ASSOC);	
		if($ab['serial'])
		{		
			$error=3;
			$errortype[]=2; // login already taken
		}	
		
		$_SESSION['post_reg_data']['login']=strtolower($_SESSION['post_reg_data']['login']);
	//*********************************************************************


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
	//  mname filter************************
		$_SESSION['post_reg_data']['mname'] = preg_replace('/[^A-Za-z0-9]\ /', '', $_SESSION['post_reg_data']['mname']); // Removes special chars.
		if(strlen($_SESSION['post_reg_data']['mname'])<3 or strlen($_SESSION['post_reg_data']['mname'])>60)
		{
			$error=6;
			$errortype[]=6; // mother name lenth is not correct
		}
		$_SESSION['post_reg_data']['mname']=strtolower($_SESSION['post_reg_data']['mname']);
		$_SESSION['post_reg_data']['mname']=ucfirst($_SESSION['post_reg_data']['mname']);
	//*********************************************************************
	//  successor filter************************
		$_SESSION['post_reg_data']['sucsessor'] = preg_replace('/[^A-Za-z0-9]\ /', '', $_SESSION['post_reg_data']['sucsessor']); // Removes special chars.
		if(strlen($_SESSION['post_reg_data']['sucsessor'])<3 or strlen($_SESSION['post_reg_data']['sucsessor'])>60)
		{
			$error=7;
			$errortype[]=7; // successor lenth is not correct
		}
		$_SESSION['post_reg_data']['sucsessor']=strtolower($_SESSION['post_reg_data']['sucsessor']);
		$_SESSION['post_reg_data']['sucsessor']=ucfirst($_SESSION['post_reg_data']['sucsessor']);
	//*********************************************************************

	$_SESSION['post_reg_data']['pass']=passme($_SESSION['post_reg_data']['pass']);
	$phn=$_SESSION['post_reg_data']['pref1'].$_SESSION['post_reg_data']['phone'];
	$mbl=$_SESSION['post_reg_data']['pref2'].$_SESSION['post_reg_data']['mobile'];

	//*****MEhsullarin qiymetlerin hesablayiriq********************************************************************************

	$xxs=explode('@',$_POST['pordinfo']);
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
		$lng01sor->execute(array('lid'=>$lng1 , 'olke'=>$_SESSION['signup_country_id'] )); 
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
		$lng01sor->execute(array( 'olke'=>$_SESSION['signup_country_id'], 'lang'=>$lng1 ));
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
				$products[$proid]['countryid']=$_SESSION['signup_country_id'];
				$products[$proid]['currid']=$b['currid'];
				$products[$proid]['short_name']=$b['short_name'];
			}		
		}	
		//*********************************************************************************************************************************
		
		//EGER discount varsa onu da hesablayib elave edirik*******************************************************************************
		$idss=implode(',',$prodid_arr);	
		$lng01sor=$db->prepare('SELECT md.* FROM mehsul_discount md where  m_u_id in ('.$idss.') and s_id=1 and shop_type=:shop_type and (mop_id=0 or mop_id=:country)');
		$lng01sor->execute(array( 'country'=>$_SESSION['signup_country_id'],  'shop_type'=>$shop_type )); 
		while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC)) 
		{
			$proid=$b['m_u_id'];
			if(@$products[$proid] and (@$products[$proid]['countryid']==$b['mop_id'] or (@!$products[$proid]['countryid'] and @$b['mop_id']=0)))
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
		$lng01sor->execute(array( 'olke'=>$_SESSION['signup_country_id'], 'lang'=>$lng1 ));	
		$bi=$lng01sor->fetch(PDO::FETCH_ASSOC);	
		
		$currname=$bi['short_name'];
		
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
					$products[$key]['countryid']=$_SESSION['signup_country_id'];
					$products[$key]['currid']=$bi['currid'];
					$products[$key]['short_name']=$bi['short_name'];
				}			
			}
		}

	$regpoint=0;
	$total=0;
	foreach($products as $key=>$value)
	{
		$regpoint+=$value['point']*$realprodsay[$key];
		if(@$value['discount']){ $p=$value['disc_price']; } else {	$p=$value['price_2'];	}
		$s=$value['shipping_2'];
		$total+=($p+$s)*$realprodsay[$key];
		$curr=$value['currid'];
	}
	//*************************************************************************************************************************


	if(@$error!=0)
	{
		?>
		<div class="order_form user_settings">
			<div class="form_item" style="text-align:center;">
				<h3 style="text-align:center;">
				<?PHP echo $confirm['errormsg'][$lng]; ?>
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
    <script src="<?php echo $site_url; ?>js/jquery.js"></script>

	<script>
		$('#backBtn').click(function()
		{
			window.history.back();
		})
	</script>	
		<?PHP
	}
	else
	{
		
		$sql=$db->prepare(
		"INSERT INTO `onlinestore` 
		(
			`id`, 
			`serial`, 
			`login`, 
			`ad`, 
			`soyad`, 
			`varis`, 
			`cins`, 
			`ana_ad`, 
			`d_tarixi`, 
			`pass`, 
			`pass_real`, 
			`question`, 
			`answer`, 
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
			`kod`, 
			`s_id`, 
			`date`, 
			`spon_id`, 
			`reg_type`) 
			VALUES (
			NULL, 
			:serial , 
			:login , 
			:ad , 
			:soyad , 
			:varis , 
			:cins , 
			:ana_ad , 
			:d_tarixi , 
			:pass , 
			:pass_real , 
			:question , 
			:answer , 
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
			NULL , 
			1 , 
			CURRENT_DATE() , 
			:spon_id , 
			:reg_type )");

			$sql->execute(ARRAY(
			'serial'=>$serial,
			'login'=>$_SESSION['post_reg_data']['login'],
			'ad'=>$_SESSION['post_reg_data']['fname'],
			'soyad'=>$_SESSION['post_reg_data']['lname'],
			'varis'=>$_SESSION['post_reg_data']['sucsessor'],
			'cins'=>$_SESSION['post_reg_data']['gender'],
			'ana_ad'=>$_SESSION['post_reg_data']['mname'],
			'd_tarixi'=>$_SESSION['post_reg_data']['dob'],
			'pass'=>$_SESSION['post_reg_data']['pass'],
			'pass_real'=>$_SESSION['post_reg_data']['pass2'],
			'question'=>$_SESSION['post_reg_data']['question'],
			'answer'=>$_SESSION['post_reg_data']['answer'],
			'adress_line1'=>$_SESSION['post_reg_data']['adr1'],
			'adress_line2'=>$_SESSION['post_reg_data']['adr2'],
			'post_code'=>$_SESSION['post_reg_data']['zip'],
			'country'=>$_SESSION['signup_country_id'],
			'national_id'=>$_SESSION['post_reg_data']['national'],
			'city'=>$_SESSION['post_reg_data']['city'],
			'state'=>$_SESSION['post_reg_data']['state'],
			'phone'=>$phn,
			'mobile'=>$mbl,
			'mail'=>$_SESSION['post_reg_data']['mail'],
			'spon_id'=>$_SESSION['signup_referer_id'],
			'reg_type'=>$regpoint
			));	
		 $osid = $db->lastInsertId();
			
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
			'2' , 
			'1' , 
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
			'4')");	
			
			$sql2->execute(ARRAY(
			'osid'=>$osid,
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
			'country'=>$_SESSION['signup_country_id']
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
		//redirecting to payment pages according to payoptions*********************************************
		$payoption=$_POST['payoption'];
		
		
		switch($payoption)
		{
			case 3:
				echo '<script>location.replace("'.$site_url.$lng.'/signup_shop/pd/'.$osid.'-'.$serial.'/1/3/");</script>';
			break;
			case 4:
			break;
			case 5:
			break;
			case 6:
				
				//converting all prices to USD if different********************************************************************************
				if($curr==1)
				{
					$ttlusd=$total;
				}
				else
				{
					$t1=$curr;
					$t2=1;
					$ttlusd=currconverter($db,$total,$t1,$t2); //price hesablanir
				}
				
				//*************************************************************************************************************************
	?>
				<form action="https://www.paypal.com/it/cgi-bin/webscr" method="post" id="ppform">
					<input type="hidden" name="cmd" value="_xclick">
					<input type="hidden" name="business" value="pervizmuradkhan@gmail.com">
					<input type="hidden" name="item_name" value="LNS INTERNATIONAL eSHOP">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="return" value="<?PHP echo $site_url.$lng.'/signup_shop/pd/'.$osid.'-'.$serial.'/1/6/';?>">
					<input type="hidden" name="amount" value="<?PHP echo $ttlusd;?>">
				</form>
				<script>
					$(document).ready(function(){
					$("#ppform").submit();
					});
				</script>
	<?PHP
			break;
			case 7:
			break;
		}
		
		//*************************************************************************************************
	}
}
?>