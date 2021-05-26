<?php

$shop_type=1; //burda hansi ehsopla ishlediyimizi qeyd edirik (1 e-shop, 2 registration, 3 commission shop)
$ucurr=$_SESSION['u_curr']; //we'll use it in javascript to calculate the price in different format
$pcurr=$_SESSION['countrycurrency']; //we'll use it in javascript to calculate the price in different format
//echo '<pre>';
	//print_r($_SESSION);
	//print_r($_POST);
	//echo'</pre>';
	$_SESSION['post_shop_data']=$_POST;
	 $uid=$_SESSION['id'];
	 $sess=JSON_encode($_SESSION);
	 $post=JSON_encode($_POST);
	 

$db->beginTransaction(); 

$mehsulsor=$db->prepare("INSERT INTO `reg_steps` (`id`, `u_id`, `date`, `shop_type`, `session`, `post`, `s_id`) VALUES (NULL, '$uid', CURRENT_TIMESTAMP, '$shop_type', '$sess', '$post', '1')");
$mehsulsor->execute();

$reg_id=$db->lastInsertId();
//echo $reg_id;
$_SESSION['reg_id']=$reg_id;

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
//print_r($realprodid2);

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
		if($products[$proid])
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
	
	$lng01sor=$db->prepare('SELECT md.* FROM mehsul_discount md where  m_u_id in ('.$idss.') and s_id=1 and shop_type=:shop_type and (mop_id=0 or mop_id=:country)');

	$lng01sor->execute(array( 'country'=>$_SESSION['country'],  'shop_type'=>$shop_type )); 
	

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
	
//print_r($products);	

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
				$products[$key][$prname]=currconverter($db,$products[$key][$prname],$t1,$t2); 	//price hesablanir
				$products[$key][$shname]=currconverter($db,$products[$key][$shname],$t1,$t2);	//shipping hesablanir
				
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

$regpoint=0;
$total=0;
foreach($products as $key=>$value)
{
	$regpoint+=$value['point']*$realprodsay[$key];
	if(@$value['discount']){ $p=$value['disc_price']; } else {	$p=$value['price_1'];	}
	$s=$value['shipping_1'];
	$total+=($p+$s)*$realprodsay[$key];
	$curr=$value['currid'];
}
//*************************************************************************************************************************


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

if (isset($_POST['payoption']))
{
	//findong balance of lns**********************************************************
	$checkuser = $db->prepare("SELECT * FROM user u WHERE id=1 limit 1");
	$checkuser->execute();
	$lns = $checkuser->fetch(PDO::FETCH_ASSOC);
	//********************************************************************************
	
	if ($_POST['payoption']==1) // payment by life bank.
	{
		$finsrc=1; //finance source new registration with lb
		if ($_SESSION['lb']>=$amount) 
		{
			$tp=$_SESSION['lb']-$amount; //from balance
			$tp2=$lns['balans_1']+$amount; //to balance
			
			
			$withdrawal = $db->prepare("UPDATE user SET balans_1=balans_1-:amount WHERE id=:login");
			$with = $withdrawal->execute(['amount'=>(float)$amount, 'login'=>$_SESSION['id']]);
			
			$insert = $db->prepare("UPDATE user SET balans_1=balans_1+:amount WHERE id=1");
			$ins = $insert->execute(['amount'=>(float)$lnsamount]);
			
			$transaction = $db->prepare("INSERT INTO `lifebank` (`id`, `balans_source`, `from_amount`, `to_amount`, `from_balance`, `to_balance`, `from`, `to`, `from_curr`, `to_curr`, `date`, `s_id`) VALUES (NULL, '1', '".$amount."', '$lnsamount', '".$tp."', '".$tp2."', '".$_SESSION['id']."', '1', '".$_SESSION['u_curr']."', '1', CURRENT_TIMESTAMP, '2')");
			$trans = $transaction->execute( );
			
			//finding last row in finance table **********************************************
			$sql='select * from finance order by id desc limit 1';
			$a=$db->prepare($sql);
			$a->execute();
			$ab=$a->fetch(PDO::FETCH_ASSOC);
			//print_r($ab);
			
			//inserting to finance table******************************************************
			
			$balans=round($ab['balans']+$lnsamount,2);
			$sql='insert into finance (`amount`, `balans`, `type`) values (:am , :bl , "1")';
			$fininsert=$db->prepare($sql);
			$fininsert->execute(ARRAY('am'=>$lnsamount , 'bl'=> $balans));
			$fid = $db->lastInsertId();
			//inserting into fin_type table****************************************************
			$sql='INSERT INTO `fin_type` (
			`f_id`, 
			`type`, 
			`real_amount`, 
			`real_currency`, 
			`amount`, 
			`from_id`, 
			`to_id`) VALUES ( 
			:fid, :finsrc, :total, :curr, :ttlusd, :from, "1")';
			$fin_typeinsert=$db->prepare($sql);
			$fin_typeinsert->execute(ARRAY('fid'=>$fid , 'finsrc'=> $finsrc , 'total'=> $amount , 'curr'=> $_SESSION['u_curr'] , 'ttlusd'=> $lnsamount, 'from'=> $_SESSION['id'] ));
			
			
			
			if ($trans && $ins && $with && $fininsert && $fin_typeinsert) 
			{
				$success = 1;
				//echo'aaaa';
			}
			else
			{
				$success = 0;
			}
		}
		else 
		{
			$success = 0;
			echo "<div class='alert alert-danger'>Not enough money</div>";
		}
	}
	elseif ($_POST['payoption']==2) 
	{
		$tp=$_SESSION['cb']-$amount;
		$tp2=$lns['balans_1']+$lnsamount;
		
		
		$finsrc=2; //finance source new registration with cb

		if ($_SESSION['cb']>=$amount) 
		{
			$withdrawal = $db->prepare("UPDATE user SET balans_2=balans_2-:amount WHERE id=:login");
			$with = $withdrawal->execute(['amount'=>(float)$amount, 'login'=>$_SESSION['id']]);
			
			$insert = $db->prepare("UPDATE user SET balans_1=balans_1+:amount WHERE id=1");
			$ins = $insert->execute(['amount'=>(float)$amount]);
			
			$transaction = $db->prepare("INSERT INTO `lifebank` (`id`, `balans_source`, `from_amount`, `to_amount`, `from_balance`, `to_balance`, `from`, `to`, `from_curr`, `to_curr`, `date`, `s_id`) VALUES (NULL, '2', '".$amount."', '$lnsamount', '".$tp."', '".$tp2."', '".$_SESSION['id']."', '1', '".$_SESSION['u_curr']."', '1', CURRENT_TIMESTAMP, '2')");
			$trans = $transaction->execute( );
			
			$transaction2 = $db->prepare("INSERT INTO `commisionbank` (`id`, `from_amount`, `to_amount`, `from_balance`, `to_balance`, `from`, `to`, `from_curr`, `to_curr`, `date`, `s_id`) VALUES (NULL, '".$amount."', '$lnsamount', '".$tp."', '".$tp2."', '".$_SESSION['id']."', '1', '".$_SESSION['u_curr']."', '1',  CURRENT_TIMESTAMP, '7');");
			
			$trans2 = $transaction2->execute( );
			
			//finding last row in finance table **********************************************
			$sql='select * from finance order by id desc limit 1';
			$a=$db->prepare($sql);
			$a->execute();
			$ab=$a->fetch(PDO::FETCH_ASSOC);
			//print_r($ab);
			
			//inserting to finance table******************************************************
			
			$balans=round($ab['balans']+$lnsamount,2);
			$sql='insert into finance (`amount`, `balans`, `type`) values (:am , :bl , "1")';
			$fininsert=$db->prepare($sql);
			$fininsert->execute(ARRAY('am'=>$lnsamount , 'bl'=> $balans));
			$fid = $db->lastInsertId();
			//inserting into fin_type table****************************************************
			$sql='INSERT INTO `fin_type` (
			`f_id`, 
			`type`, 
			`real_amount`, 
			`real_currency`, 
			`amount`, 
			`from_id`, 
			`to_id`) VALUES ( 
			:fid, :finsrc, :total, :curr, :ttlusd, :from, "1")';
			$fin_typeinsert=$db->prepare($sql);
			$fin_typeinsert->execute(ARRAY('fid'=>$fid , 'finsrc'=> $finsrc , 'total'=> $amount , 'curr'=> $_SESSION['u_curr'] , 'ttlusd'=> $lnsamount, 'from'=> $_SESSION['id'] ));
			
			
			

			if ($trans2 && $trans && $ins && $with) {
				$success = 1;
			}
			else
			{
				$success = 0;
			}
		}
		else 
		{
			$success = 0;
		}
	}
	if (@$success == 1) 
	{
		echo "<div class='alert alert-success'>Success! Payment done ".$cr[$t1]['NAME'].' '.$total."</div>";
		$db->commit();
		
		$mehsulsor=$db->prepare("update `reg_steps` set `s_id`='2' where id='$reg_id'");
		$mehsulsor->execute();
		$update_balance = $db->prepare("SELECT * FROM user WHERE id=:id");
		$update_balance->execute(['id'=>$_SESSION['id']]);
		$balans = $update_balance->fetch(PDO::FETCH_ASSOC);
		$_SESSION['lb'] = $balans['balans_1'];
		$_SESSION['cb'] = $balans['balans_2'];
		
		echo'<script>location.replace("'.$site_url.$lng.'/shop/pd/");</script>';
	} else {
		echo "<div class='alert alert-danger'>Not enough money</div>";
		$db->rollBack();
		
		$mehsulsor=$db->prepare("update `reg_steps` set `s_id`='3' where id='$reg_id'");
		$mehsulsor->execute();
		
		echo'<script>location.replace("'.$site_url.$lng.'/shop/errorpage/2/");</script>';
	}
	
} 
else
{
	$mehsulsor=$db->prepare("update `reg_steps` set `s_id`='3' where id='$reg_id'");
	$mehsulsor->execute();
	echo'<script>location.replace("'.$site_url.$lng.'/shop/errorpage/3/");</script>';
}


?>
