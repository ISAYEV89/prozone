<?php 
error_reporting(0);
session_start(); 
ob_start();
try
{
    $db= new PDO ("mysql:host=localhost; dbname=travelin_prozone; charset=utf8;","travelin_prozone","1q2w3e4r5t!QA");
    //$db= new PDO ("mysql:host=localhost:3302; dbname=lnsint; charset=utf8;","root","");
}
catch(PDOException $e)
{
 	echo $e->getMessage();
}

$site_url='https://travelinbaku.com/prozone/';


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
	$a = addslashes($a); 
	$a = stripslashes($a); 
    return $a;
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
$_SESSION['_originalToken'] =md5("PROZONE");
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
			$str='Yanvar';
			break;
			case '02':
			$str='Fevral';
			break;
			case '03':
			$str='Mart';
			break;
			case '04':
			$str='Aprel';
			break;
			case '05':
			$str='May';
			break;
			case '06':
			$str='Iyun';
			break;
			case '07':
			$str='Iyul';
			break;
			case '08':
			$str='Avqust';
			break;
			case '09':
			$str='Sentyabr';
			break;
			case '10':
			$str='Oktyabr';
			break;
			case '11':
			$str='Noyabr';
			break;
			case '12':
			$str='Dekabr';
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
function passme($pass)
{
	$password=password_hash($pass, PASSWORD_DEFAULT);
	return $password;
}

?>