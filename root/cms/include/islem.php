<?php 

try 

{

    //$db= new PDO ("mysql:host=localhost; dbname=lnsinves_lns_int; charset=utf8;","lnsinves_lnsint","b%n4GrP-}UQc");
	$db= new PDO ("mysql:host=localhost; dbname=lnsintne_main; charset=utf8;","lnsintne_mainu","1q2w3e4r5t!QA");

}

catch(Exception $e) 

{

    echo $e->getMessage();

}

function s ($a)

{

	$a = htmlspecialchars($a); 

	$a = trim($a); 

	$a = stripslashes($a); 

    return $a;

}

if (isset($_POST['lng'])=="shrtnm")

{

	$lngsor = $db->prepare('SELECT id FROM lng where short_name="'.s($_POST['name']).'"  ');

	$lngsor->execute();

	$lngsay=$lngsor->rowCount();

	if($lngsay>=1)

	{

		echo "false";

	}

	else

	{

		echo "true";

	}

}

if (isset($_POST['bc'])=="tagurl")

{

	if ($_POST['id']) 

	{

		$source='and u_id!="'.s($_POST['id']).'"';

	}

	else

	{

		$source='';

	}

	$catsor = $db->prepare('SELECT id FROM blog_cat where url_tag="'.s($_POST['name']).'"  '.$source.' ');

	$catsor->execute();

	$catsay=$catsor->rowCount();

	if($catsay>=1)

	{

		echo "false";

	}

	else

	{

		echo "true";

	}

}

if (isset($_POST['bco'])=="contenttagurl")

{

	if ($_POST['id']) 

	{

		$source='and u_id!="'.s($_POST['id']).'"';

	}

	else

	{

		$source='';

	}

	$catsor = $db->prepare('SELECT id FROM blog_content where url_tag="'.s($_POST['name']).'"  '.$source.' ');

	$catsor->execute();

	$catsay=$catsor->rowCount();

	if($catsay>=1)

	{

		echo "false";

	}

	else

	{

		echo "true";

	}

}

if (isset($_POST['cc'])=="tagurlcc")

{

	if ($_POST['id']) 

	{

		$source='and u_id!="'.s($_POST['id']).'"';

	}

	else

	{

		$source='';

	}

	$catsor = $db->prepare('SELECT id FROM texnika_cat where url_tag="'.s($_POST['name']).'"  '.$source.' ');

	$catsor->execute();

	$catsay=$catsor->rowCount();

	if($catsay>=1)

	{

		echo "false";

	}

	else

	{

		echo "true";

	}

}

if (isset($_POST['mc'])=="mctagurl")

{

	if ($_POST['id']) 

	{

		$source='and u_id!="'.s($_POST['id']).'"';

	}

	else

	{

		$source='';

	}

	$catsor = $db->prepare('SELECT id FROM texnika_content where url_tag="'.s($_POST['name']).'"  '.$source.' ');

	$catsor->execute();

	$catsay=$catsor->rowCount();

	if($catsay>=1)

	{

		echo "false";

	}

	else

	{

		echo "true";

	}

}

if (isset($_POST['sc'])=="tagurlsc")

{

	if ($_POST['id']) 

	{

		$source='and u_id!="'.s($_POST['id']).'"';

	}

	else

	{

		$source='';

	}

	$catsor = $db->prepare('SELECT id FROM shop_cat where url_tag="'.s($_POST['name']).'"  '.$source.' ');

	$catsor->execute();

	$catsay=$catsor->rowCount();

	if($catsay>=1)

	{

		echo "false";

	}

	else

	{

		echo "true";

	}

}

if (isset($_POST['sco'])=="scotagurl")

{

	if ($_POST['id']) 

	{

		$source='and u_id!="'.s($_POST['id']).'"';

	}

	else

	{

		$source='';

	}

	$catsor = $db->prepare('SELECT id FROM shop_item where url_tag="'.s($_POST['name']).'"  '.$source.' ');

	$catsor->execute();

	$catsay=$catsor->rowCount();

	if($catsay>=1)

	{

		echo "false";

	}

	else

	{

		echo "true";

	}

}

if (isset($_POST['mn'])=="menu")

{

	if ($_POST['id']) 

	{

		$source='and u_id!="'.s($_POST['id']).'"';

	}

	else

	{

		$source='';

	}

	$catsor = $db->prepare('SELECT id FROM menu where url_tag="'.s($_POST['name']).'"  '.$source.' ');

	$catsor->execute();

	$catsay=$catsor->rowCount();

	if($catsay>=1)

	{

		echo "false";

	}

	else

	{

		echo "true";

	}

}

if (isset($_POST['builder'])=="fetcha")

{

	switch ($_POST['type']) 

	{

		case '1':

		$source='blog_cat';

		break;

		case '2':

		$source='texnika_cat';

		break;

		case '3':

		$source='shop_cat';

		break;		

		default:

		$source='';

		break;

	}

	$catsor = $db->prepare('SELECT * FROM '.$source.' where l_id="1" ');

	$catsor->execute();

	$catsay=$catsor->rowCount();

	if($catsay>=1)

	{

		while($catcek=$catsor->fetch(PDO::FETCH_ASSOC))

		{

			if ($catcek['name']=='') 

			{

				echo '<option value="'.$catcek['u_id'].'" > Name is free , id: '.$catcek['u_id'].'</option>';

			}

			else

			{

				echo '<option value="'.$catcek['u_id'].'" >'.$catcek['name'].'</option>';

			}

		}

	}

	else

	{

		echo "false";

	}

}



if (isset($_POST['olk'])=="select")

{

	$catsor = $db->prepare('SELECT * FROM olkeler where l_id="1" ');

	$catsor->execute();

	$catsay=$catsor->rowCount();

	if($catsay>=1)

	{

		while($catcek=$catsor->fetch(PDO::FETCH_ASSOC))

		{
            $currency = $db->prepare("SELECT * FROM currency WHERE u_id=:uid AND l_id=:lid");
            $currency->execute(['uid'=>$catcek['currency_id'], 'lid'=>'1']);
            $cur = $currency->fetch(PDO::FETCH_ASSOC);

			echo '<option value="'.$catcek['kat_id'].'" >'.$catcek['name'].'&nbsp;&nbsp;&nbsp;'.$cur['short_name'].'<i class="'.$cur['sign_fa'].'"></i>'.'</option>';

		}

	}

	else

	{

		echo "false";

	}

}

?>