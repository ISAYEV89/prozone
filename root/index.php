<?PHP
include 'inc/config.php';
include 'inc/language.php';


$lngquer=$db->prepare('SELECT * from lng , (SELECT u_id as def , short_name as sn from lng where `default` is not null ) g ');
$lngquer->execute();
$lng_sname = array();
$lng_uid = array();
$default = array();
while($lngfc=$lngquer->fetch(PDO::FETCH_ASSOC))
{
  $default_name=$lngfc['sn'];
  $default_uid=$lngfc['def'];
  array_push($lng_sname, $lngfc['short_name']);
  array_push($lng_uid, $lngfc['u_id']);
}
if (@$_GET['lng'] && in_array(@$_GET['lng'], $lng_sname))
{
  $lng=@$_GET['lng'];
  $row=array_search(@$_GET['lng'], $lng_sname);
  $lng1=$lng_uid[$row];
  $_SESSION['lng']=$lng;
}
elseif ($_SESSION['lng'] && in_array($_SESSION['lng'], $lng_sname)) 
{
  $lng=@$_SESSION['lng'];
  $row=array_search(@$_SESSION['lng'], $lng_sname);
  $lng1=$lng_uid[$row];
}
else 
{
  $lng=$default_name;
  $lng1=$default_uid;
}
if (@$_GET['state']!='')
{ 
  switch (@$_GET['state']) 
  {
    case 'login':  $source='login'; $page='login'; $dbfrom='site_general'; $dblink=''; $dbc_id=''; break;
    case 'relogin':  $source='relogin'; $page='relogin'; $dbfrom='site_general'; $dblink=''; $dbc_id=''; break;
    case 'yearpay': 
		if(isset($_GET['cat']) and $_GET['cat']=='pay_by_system')
		{
			$source='yearpay/pay_by_system';
			$page='pay_by_system';
			$dbfrom='site_general';
			$dblink='';
			$dbc_id='';
		}
		else
		{
			$source='yearpay/yearpay';
			$page='yearpay';
			$dbfrom='site_general';
			$dblink='';
			$dbc_id='';
		}		
	break;
    case 'loginupdate':  $source='loginupdate'; $page='loginupdate'; $dbfrom='site_general'; $dblink=''; $dbc_id=''; break;
    case 'lostpassword':   
	if (isset($_GET['cat'])) 
	{          
        $source='lostpassword/'.$_GET['cat']; $page='lostpassword'; $dbfrom='site_general'; $dblink=''; $dbc_id='';;
    } 
	else 
	{        
        $source='lostpassword/index'; $page='lostpassword'; $dbfrom='site_general'; $dblink=''; $dbc_id='';
    }	
	break;
    case 'signup_shop':      
		if(isset($_GET['cat']) and $_GET['cat']=='basket')
		{
			$source='signup_shop/basket'; 
			$page='basket';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}
		elseif(isset($_GET['cat']) and $_GET['cat']=='pd')
		{
			$source='signup_shop/pd'; 
			$page='pd';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}     
		elseif(isset($_GET['cat']) and $_GET['cat']=='shippay')
		{
			$source='signup_shop/shippay'; 
			$page='shippay';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}     
		elseif(isset($_GET['cat']) and $_GET['cat']=='review')
		{
			$source='signup_shop/review'; 
			$page='review';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}     
		elseif(isset($_GET['cat']) and $_GET['cat']=='confirm')
		{
			$source='signup_shop/confirm'; 
			$page='confirm';
			$dbfrom='menuhhh'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}     
		elseif(isset($_GET['cat']) and $_GET['cat']=='thankyou')
		{
			$source='signup_shop/thankyou'; 
			$page='thankyou';
			$dbfrom='menuhhh'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}		
		elseif(!isset($_GET['cat']) and !isset($_GET['cname']))
		{
			$source='signup_shop/category';
			$page='category';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';                      
		}     
		elseif(isset($_GET['cat']) and !isset($_GET['cname']))
		{
			$source='signup_shop/category'; 
			$page='category';
			$dbfrom='mehsul'; 
			$dblink=s($_GET['cat']);
			$dbc_id='u_id=';
		}    
		elseif(isset($_GET['cat']) and isset($_GET['cname']) and strpos(strval($_GET['cname']),'p') !== false)
		{
			$source='signup_shop/category';
			$page='category';
			$dbfrom='mehsul'; 
			$dblink=s($_GET['cat']);
			$dbc_id='u_id=';
		}		  
		elseif(isset($_GET['cat']) and isset($_GET['cname']) and $_GET['cname'] >0)
		{
			$source='signup_shop/detail'; 
			$page='detail';
			$dbfrom='mehsul'; 
			$dblink=s($_GET['cname']);
			$dbc_id='u_id=';
		}    
	break;     
					  
    case 'shop':
		if(isset($_GET['cat']) and $_GET['cat']=='confirm')
		{
			$source='shop/confirm'; 
			$page='confirm';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}
		elseif(isset($_GET['cat']) and $_GET['cat']=='pd')
		{
			$source='shop/pd'; 
			$page='pd';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}
		elseif(isset($_GET['cat']) and $_GET['cat']=='thankyou')
		{
			$source='shop/thankyou'; 
			$page='thankyou';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}
		elseif(isset($_GET['cat']) and $_GET['cat']=='pay_by_system')
		{
			$source='shop/pay_by_system'; 
			$page='pay_by_system';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}
		elseif(isset($_GET['cat']) and $_GET['cat']=='pay_by_pp')
		{
			$source='shop/pay_by_pp'; 
			$page='pay_by_pp';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}
		elseif(isset($_GET['cat']) and $_GET['cat']=='basket')
		{
			$source='shop/basket'; 
			$page='basket';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}
		elseif(isset($_GET['cat']) and $_GET['cat']=='review')
		{
			$source='shop/review'; 
			$page='review';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}
		elseif(isset($_GET['cat']) and $_GET['cat']=='shippay')
		{
			$source='shop/shippay'; 
			$page='shippay';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';            
		}
		elseif(!isset($_GET['cat']) and !isset($_GET['cname']))
        {
			$source='shop/category'; 
			$page='category';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='u_id=';
		}
		elseif(isset($_GET['cat']) and !isset($_GET['cname']))
		{
			$source='shop/category'; 
			$page='category';
			$dbfrom='mehsul'; 
			$dblink=s($_GET['cat']);
			$dbc_id='u_id=';
		}
		elseif(isset($_GET['cat']) and isset($_GET['cname']) and strpos(strval($_GET['cname']),'p') !== false)
		{
			$source='shop/category'; 
			$page='category';
			$dbfrom='mehsul'; 
			$dblink=s($_GET['cat']);
			$dbc_id='u_id=';
		}		  
		elseif(isset($_GET['cat']) and isset($_GET['cname']) and $_GET['cname'] >0)
		{
			$source='shop/detail'; 
			$page='detail';
			$dbfrom='mehsul'; 
			$dblink=s($_GET['cname']);
			$dbc_id='u_id=';
		}
	break; 
	case 'menu':  
		if (isset($_GET['cat']) && isset($_GET['cname']) && isset($_GET['child']  )) 
		{
			$source='menu/detail'; 
			$page='detail'; 
			$dbfrom='menu'; 
			$dblink=s($_GET['child']); 
			$dbc_id='url_tag=';
		}
		else
		{
			$source='menu/index'; 
			$page='index'; 
			$dbfrom='menu'; 
			$dblink=s($_GET['cat']); 
			$dbc_id='url_tag=';
		}
    break;    
    case 'contact':  $source='contact'; $page='contact'; $dbfrom='menu'; $dblink=s($_GET['state']); $dbc_id='url_tag='; break;
    case 'sign-up':  $source='sign/index'; $page='index'; $dbfrom='menu'; $dblink=s($_GET['state']); $dbc_id='url_tag='; break;
    case 'about':
		if(isset($_GET['cat']) and !isset($_GET['cname']))
		{
			$source='about/index'; 
			$page='index';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='url_tag=';      
		}
	break;
    case 'basket':     
		if(!isset($_GET['cat']) and !isset($_GET['cname']) )
		{
			$source='basket/index'; 
			$page='index';
			$dbfrom='site_general'; 
			$dblink='';
			$dbc_id='';
		}
		elseif(isset($_GET['cat']) and !isset($_GET['cname']) and $_GET['cat']=='shippay' )
		{
			$source='basket/shippay';
			$page='shippay';
			$dbfrom='site_general'; 
			$dblink='';
			$dbc_id='';
		}
		elseif(isset($_GET['cat']) and !isset($_GET['cname']) and $_GET['cat']=='order' )
		{
			$source='basket/order';
			$page='order';
			$dbfrom='site_general';
			$dblink='';
			$dbc_id=''; 
		}
	break;
    case 'support': 
		if(isset($_GET['state']))                        
		{
			$source='support/index';
			$page='index';
			$dbfrom='support';
			$dblink=s($_GET['state']);
			$dbc_id='url_tag=';
		}
		elseif(!isset($_GET['cat']))
		{
			$source='support/index';
			$page='index';
			$dbfrom='menu';
			$dblink=s($_GET['state']);
			$dbc_id='url_tag=';
		}
	break;
    case 'news':
		if(!isset($_GET['cat']) and !isset($_GET['cname']))
		{
			$source='news/category';
			$page='category';
			$dbfrom='menu';
			$dblink=s($_GET['state']);
			$dbc_id='url_tag='; 
		} 
		elseif(isset($_GET['cat']) and $_GET['cat']==0 and !isset($_GET['cname']) )
		{
			$source='news/category';
			$page='category';
			$dbfrom='menu'; 
			$dblink=s($_GET['state']);
			$dbc_id='url_tag=';
		}
		elseif(isset($_GET['cat']) and $_GET['cat']>0 and !isset($_GET['cname']))
		{
			$source='news/detail';
			$page='detail';
			$dbfrom='blog_content'; 
			$dbfrom='blog_content';
			$dblink=s($_GET['cat']);
			$dbc_id='url_tag=';
		}
	break;
    default:   $source='home';   $page='home';  $dbfrom='site_general';   $dblink=''; $dbc_id='';    break;
  }
} 
else 
{ 
	$source='home'; 
	$page='home';
	$dbfrom='site_general'; 
	$dblink='';
	$dbc_id='';
}
if ($dblink=='' && $dbc_id=='')
{
  $tdk=$db->prepare('SELECT * from '.$dbfrom.' where  l_id="'.s($lng1).'"');
}
elseif($dblink!='' && $dbc_id!='')
{
  $tdk=$db->prepare('SELECT * from '.$dbfrom.' where  '.$dbc_id.'"'.$dblink. '" and l_id="'.s($lng1).'"');
}
$tdk->execute();
$tdkc=$tdk->fetch(PDO::FETCH_ASSOC);

$tdks2=$db->prepare('SELECT * from site_general where l_id=:lis ');
$tdks2->execute(array('lis'=>$lng1));
$tdkc2=$tdks2->fetch(PDO::FETCH_ASSOC);
/* echo $source;
echo'<br>';
echo$_GET['cat'];
echo'<br>';
echo$_GET['state']; */

//******script for clearing localstorage**************
$prs=explode('/',$_SERVER["HTTP_REFERER"]);
if(!empty($prs[4]) and $prs[4]!=$_GET['state'])
{
	echo'<script>localStorage.clear();</script>';
}
//****************************************************
include 'include/header.php';
include 'include/'.$source.'.php';
include 'include/footer.php';
?>