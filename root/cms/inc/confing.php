<?php 

error_reporting(0);

session_start(); 

ob_start();

try

{
	$db= new PDO ("mysql:host=localhost; dbname=lnsintne_main; charset=utf8;","lnsintne_mainu","1q2w3e4r5t!QA" ,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION SQL_BIG_SELECTS=1')); 
    //$db= new PDO ("mysql:host=localhost:3302; dbname=lnsint; charset=utf8;","root","");

}

catch(PDOException $e)

{

 	echo $e->getMessage();

}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$db->setAttribute(PDO::SQL_BIG_SELECTS, PDO::ERRMODE_EXCEPTION);
function s ($a)

{

	$a = htmlspecialchars($a); 

	$a = trim($a); 

	$a = strip_tags($a); 

	$a = addslashes($a); 

	$a = stripslashes($a); 

    return $a;

}

function sck ($a)

{

	$a = trim($a); 

    return $a;

}

function arrtostr ($a)

{

	$count = count($a);

	$str=''; 

	for ($i=0; $i <$count ; $i++) 

	{ 

		if ($i==0) 

		{

			$str='"'.$a[$i].'"';

		}

		else

		{

			$str=$str.',"'.$a[$i].'"';

		}

		

	}

    return $str;

}

function mounth ($a,$b)

{

	if($b==1)

	{

		switch ($a) 

		{

			case '01':

			$str='January';

			break;

			case '02':

			$str='February';

			break;

			case '03':

			$str='March';

			break;

			case '04':

			$str='April';

			break;

			case '05':

			$str='May';

			break;

			case '06':

			$str='June';

			break;

			case '07':

			$str='July';

			break;

			case '08':

			$str='August';

			break;

			case '09':

			$str='September';

			break;

			case '10':

			$str='October';

			break;

			case '11':

			$str='November';

			break;

			case '12':

			$str='December';

			break;



			

			default:

			$str='error';

			break;

		}

	}

	elseif($b==2)

	{

		switch ($a) 

		{

			case '01':

			$str='Ocak';

			break;

			case '02':

			$str='Şubat';

			break;

			case '03':

			$str='Mart';

			break;

			case '04':

			$str='Nisan';

			break;

			case '05':

			$str='Mayıs';

			break;

			case '06':

			$str='Haziran';

			break;

			case '07':

			$str='Temmuz';

			break;

			case '08':

			$str='Ağustos';

			break;

			case '09':

			$str='Eylül';

			break;

			case '10':

			$str='Ekim';

			break;

			case '11':

			$str='Kasım';

			break;

			case '12':

			$str='Aralık';

			break;



			

			default:

			$str='error';

			break;

		}

	}

	elseif($b==3)

	{

		switch ($a) 

		{

			case '01':

			$str='Январь';

			break;

			case '02':

			$str='Февраль';

			break;

			case '03':

			$str='Март';

			break;

			case '04':

			$str='Апрель';

			break;

			case '05':

			$str='Май';

			break;

			case '06':

			$str='Июнь';

			break;

			case '07':

			$str='Июль';

			break;

			case '08':

			$str='Август';

			break;

			case '09':

			$str='Сентябрь';

			break;

			case '10':

			$str='Октябрь';

			break;

			case '11':

			$str='Ноябрь';

			break;

			case '12':

			$str='Декабрь';

			break;



			

			default:

			$str='error';

			break;

		}

	}

	else

	{				

		switch ($a) 

		{

			case '01':

			$str='January';

			break;

			case '02':

			$str='February';

			break;

			case '03':

			$str='March';

			break;

			case '04':

			$str='April';

			break;

			case '05':

			$str='May';

			break;

			case '06':

			$str='June';

			break;

			case '07':

			$str='July';

			break;

			case '08':

			$str='August';

			break;

			case '09':

			$str='September';

			break;

			case '10':

			$str='October';

			break;

			case '11':

			$str='November';

			break;

			case '12':

			$str='December';

			break;



			

			default:

			$str='error';

			break;

		}	

	}

    return $str;

}

function seo ($a)

{

	$a = htmlspecialchars($a); 

	$a = trim($a); 

	$a = stripslashes($a); 

	$tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',' ',',','?');

	$eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','');

	$a = str_replace($tr,$eng,$a);

	$a = strtolower($a);

	$a = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $a);

	$a = preg_replace('/\s+/', '-', $a);

	$a = preg_replace('|-+|', '-', $a);

	$a = preg_replace('/#/', '', $a);

	$a = str_replace('.', '', $a);

	$a = trim($a, '-');

	return $a;

}


function updRPCount($db, $mas)
{
	foreach($mas as $val)
	{
		$pid=$val[0];
		$say=$val[1];
		$sql=$db->prepare('select * from stock_rp_mehsul where m_uid=:id');
		$sql->execute(ARRAY('id'=>$pid));
		
		$sql2=$db->prepare('update stock_rp set say=say- :a1, say2=say2+ :a2 where id=:id');
		$sql3=$db->prepare('update stock_rp_prod set say=say- :a1, say2=say2+ :a2 where rp_id=:id');
		while($b=$sql->fetch(PDO::FETCH_ASSOC))
		{
			$srp_id=$b['srp_id'];
			$rpsay=$say*$b['unit_count'];
			
			$sql2->execute(ARRAY('a1'=>$rpsay,'a2'=>$rpsay,'id'=>$srp_id));
			$sql3->execute(ARRAY('a1'=>$rpsay,'a2'=>$rpsay,'id'=>$srp_id));
		}
	}
}
?>