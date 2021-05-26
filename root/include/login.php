<?php
if(isset($_POST['loginPost']) && isset($_POST['_originalToken']) && $_POST['_originalToken']==$_SESSION['_originalToken'])
{
    ?>
    <style>
        #page{
            display:none !important;
        }
        .page{
            display:none !important;
        }
        .lds-spinner{
            display:inline-block !important;
            position: fixed;
        }

        .addthis-smartlayers-desktop, .addthis-smartlayers {
            display: none;
        }

    /*    body {
            overflow: hidden;
        }*/
    </style>


    
    <?php
	if(isset($_POST['login']) && isset($_POST['pass']))
	{
		$login=htmlspecialchars(addslashes($_POST['login']));
		$password=htmlspecialchars(addslashes($_POST['pass']));
		$pass_real=htmlspecialchars(addslashes($_POST['pass']));
		
		$sas=$db->prepare('SELECT 
		`u`.country, 
		`u`.`soyad`,  
		`u`.`ad`, 
		`u`.`pass`, 
		`u`.`phone`,
		`u`.`adress_line1`,
		`u`.`mail`,
		`u`.`id`,
		`u`.`last_login`,
		`u`.`login`,
		`u`.`question`,
		`u`.`serial`,
		`u`.`l_a_date`,
		`t`.`derinlik`,
		`t`.`reg_type`,
		`t`.`left_say`,
		`t`.`i_date`,
		`t`.`right_say`,
		`u`.`balans_1`,
		`u`.`balans_2`,
		`u`.`balans_3`,
		`u`.`lock`,
		`u`.`ip`,
		TIMESTAMPDIFF(year,l_a_date, now() ) vaxt_ferq,
		`c`.`currency_id`,
		`c`.`currency2_id`,
		`cr`.`short_name` curname
		
		FROM 
		
		`user` u ,
		`tree` t,
		`olkeler` c ,
		`currency` cr
		
		WHERE 
		
		`u`.`login`="'.$login.'" and 
		`u`.`id`=`t`.`u_id` and 
		`u`.`country`=`c`.`kat_id` and 
		`c`.`currency2_id`=`cr`.u_id and
		`c`.`l_id`=1 and 
		`cr`.`l_id`=1
		
		LIMIT 1');
		
		$sas->execute();
		$cnt=$sas->rowCount();
		
		if($cnt==1)
		{
			$b = $sas->fetch(PDO::FETCH_ASSOC);
			if(password_verify($password, $b['pass']))
			{
				
			$date1=date("Y-m-d");
			$date2 = $b['l_a_date'];
			$diff = abs(strtotime($date2) - strtotime($date1));
			$years = floor($diff / (365*60*60*24));
			if($b['vaxt_ferq']>0)
			{
				
				$_SESSION['lock_id']=$b['id'];
				$_SESSION['lock_ser']=$b['serial'];
				$_SESSION['lock_rt']=$b['reg_type'];
				$_SESSION['lock_lad']=$b['l_a_date'];
				$_SESSION['u_curr']=$b['currency_id'];
				$_SESSION['u_curr2']=$b['currency2_id'];
				$_SESSION['u_currname']=$b['curname'];
				echo '<meta http-equiv="refresh" content="0;url='.$site_url.$lng.'/yearpay/" />';
				exit;
			}
			if($login=='lns' or $login=='LNS')
			{
				
			}
			elseif(strlen($login)>3 and strlen($login)<20 and preg_match('/^[a-z0-9.]+$/i', $login)==1)
			{
				
			}
			else
			{
				$_SESSION['false_login']=$b['login'];
				$_SESSION['question']=$b['question'];
				$_SESSION['pass_real']=$pass_real;
				echo '<meta http-equiv="refresh" content="0;url='.$site_url.$lng.'/loginupdate/" />';
				exit;
			}
			//if login is not-ok we'll redirect it to login update page
			//else everything is ok
		
			$_SESSION['last_activity'] = time();
			$_SESSION['left_phone']=$b['phone'];
			$_SESSION['left_address']=$b['adress_line1'];
			$_SESSION['left_mail']=$b['mail'];
			$_SESSION['id']=$b['id'];
			$_SESSION['login']=$b['login'];
			$_SESSION['x_ps']=$b['pass'];
			$_SESSION['x0_ad']=$b['ad'];
			$_SESSION['x0_sa']=$b['soyad'];
			$_SESSION['serial']=$b['serial'];
			$_SESSION['question']=$b['question'];
			$_SESSION['derinlik']=$b['derinlik'];
			$_SESSION['ls']=$b['left_say'];
			$_SESSION['rs']=$b['right_say'];
			$_SESSION['lb']=$b['balans_1'];
			$_SESSION['vb']=$b['balans_3'];
			$_SESSION['cb']=$b['balans_2'];
			$_SESSION['ll']=$b['last_login']; //last login time
			$_SESSION['i_date']=$b['i_date']; //invest date
			$_SESSION['side']=$b['side'];
			$_SESSION['u_id']=$b['u_id'];
			$_SESSION['country']=$b['country'];
			$_SESSION['u_curr']=$b['currency_id'];
			$_SESSION['u_curr2']=$b['currency2_id'];
			$_SESSION['u_currname']=$b['curname'];
			
			$a=$b['login'].$b['id'];
			$ni = date("H:i:s");
			$a=crypt($a,$ni);
			$sasa=$db->prepare('UPDATE `user` SET `user`.`time`= CURTIME(),`user`.`last_login`= NOW(),`user`.`pass_real`= "'.$pass_real.'",`kod` = "'.$a.'", `ip`="'.$_SERVER['REMOTE_ADDR'].'" where `id`="'.$_SESSION['id'].'" limit 1');
			$sasa->execute();
			$_SESSION['kod']=$a;
				
				
				
				
				
?>
				<script>window.open(<?php echo $site_url.'user/'.$lng.'/'?>);</script>;
<?php
			echo '<meta http-equiv="refresh" content="0;url='.$site_url.'user/" />';
			}
			else
			{
				@$_SESSION['attempt']+=1;
				if(@$_SESSION['attempt']>=3)
				{
					//mysqli_query($connection,'UPDATE `user` SET `ip`="'.$_SERVER['REMOTE_ADDR'].'",`lock`=1,`lock_time`=now() where `login`="'.$login.'" limit 1');
				}
				
					echo 	'<script>
					location.replace("'.$site_url.$lng.'/");
				</script>';
				}
						
		}
		else
		{
			@$_SESSION['attempt']+=1;
			if(@$_SESSION['attempt']>=3)
			{
				//mysqli_query($connection,'UPDATE `user` SET `ip`="'.$_SERVER['REMOTE_ADDR'].'",`lock`=1,`lock_time`=now() where `login`="'.$login.'" limit 1');
			}
			
				echo 	'<script>
		 		location.replace("'.$site_url.$lng.'/");
		 	</script>';
		}
    }
    else
    {
      echo "<script> alert('Please fill in all fields')</script>";
    }
}
else
{
 	if(isset($_POST['loginPost']) )
 	{
 	}
	if(isset($_GET['val']) )
	{
 	}
 	if($_GET['val']=='ok' )
 	{
 	}
 	if(isset($_POST['_originalToken']) )
 	{
 	}
 	if($_POST['_originalToken']==$_SESSION['_originalToken'])
 	{
 	}
// 		exit();
	echo 	'<script>
		 		location.replace("'.$site_url.$lng.'/");
		 	</script>';
?>
<!--div class="login_block">
	<div class="block_content">
		<div class="close">Закрыть</div>
		<div class="block_title">Войдите на сайт</div>
			<form action="<?=$site_url.$lng?>/login/" method="post">
			<input type="hidden" name="_originalToken" value="<?=$_SESSION['_originalToken'];?>"/>
			<div class="form_item"><input type="text" class="form_text" placeholder="Логин" name="login"></div>
			<div class="form_item"><input type="password" class="form_text" placeholder="Пароль" name="pass"></div>
			<div class="form_actions">
				<a href="#">Забыли пароль?</a>
				<input type="submit" class="form_submit" value="Войти" name="loginPost">
			</div>
			<div class="bot_wrap">
				<div class="title">Нет аккаунта?</div>
				<a href="#">Зарегистрируйтесь сейчас!</a>
			</div>
		</form>
	</div -->
	<!--div class="popup_fon"></div !-->
</div>
<?php
}
?>