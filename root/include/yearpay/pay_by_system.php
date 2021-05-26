<div class="middle">
    <div class="container">
        <div class="page_title_wrapper"><h1 class="page_title"><?PHP echo $yearpay['title'][$lng]; ?></h1></div>        <div class="middle_content middle_content--pay" >
            <?PHP
            $db->beginTransaction();
            $sas = $db->prepare('SELECT 			`u`.*			FROM 			`user` u			WHERE			`u`.`id`="' . $_SESSION['lock_id'] . '"	LIMIT 1');
            $sas->execute();
            $b = $sas->fetch(PDO::FETCH_ASSOC);
			//finding payment values for convert, first couple vaucher and etc and converting it to their currencies**********
			$limits=$db->prepare("Select * from `salary`");
			$limits->execute();
			$pay_val=ARRAY();
 			// payment values for countries
			while($limit=$limits->fetch(PDO::FETCH_ASSOC))
			{
				$cid=$limit['c_id'];
				$pay_val[$cid]=$limit;
			}			
			$ucon=$b['country'];			
			if(!empty($pay_val[$ucon]))
			{
				$pymnt=$pay_val[$ucon];	
			}
			else
			{
				$pymnt=$pay_val[0];
			}

			$l_arr=explode('@',$pymnt['yearpay']);
			$l_arr2=ARRAY();
			foreach($l_arr as $value)
			{
				$g=explode('-',$value);
				$l_arr2[]=$g;
			}

			foreach($l_arr2 as $vl)
			{
				if(($_SESSION['lock_rt']>=$vl[0] and $_SESSION['lock_rt']<$vl[1]))
				{
					$mblg=$vl[2];
					$lnsamount=$vl[2];
					break 1;	// it will stop foreach iteraton and go for next id	
				}
			}

			$mblg=currconverter($db,$mblg,1,$_SESSION['u_curr2'],2);
			//*************************************************
			//commisionbankdan odenish edilecek

			if($mblg>$b['balans_2'])
			{
				$_SESSION['fail'] = 'ok';
			}
			else
			{
				$withdrawal = $db->prepare("UPDATE user SET balans_2=balans_2-:amount WHERE id=:login limit 1");
				$with = $withdrawal->execute(['amount'=>(float)$mblg, 'login'=>$_SESSION['lock_id']]);
				$ubal2=$b['balans_2']-$mblg;
				$transaction2 = $db->prepare("INSERT INTO `commisionbank` 
				(
					`id`,
					`from_amount`,
					`to_amount`,
					`from_balance`,
					`to_balance`,
					`from`,
					`to`,
					`from_curr`,
					`to_curr`,
					`date`,
					`s_id`
				)
				VALUES
				(
					NULL,
					'".$mblg."',
					'$lnsamount',
					'".$ubal2."',
					'0',
					'".$_SESSION['lock_id']."',
					'1',
					'".$_SESSION['u_curr2']."',
					'1',
					CURRENT_TIMESTAMP,
					'5'
				);");

				$trans2 = $transaction2->execute();	
				
				//finding last row in finance table **********************************************
				$sql='select * from finance order by id desc limit 1';
				$a=$db->prepare($sql);
				$a->execute();
				$ab=$a->fetch(PDO::FETCH_ASSOC);

				//inserting to finance table******************************************************												
				$balans=round($ab['balans']+$lnsamount,2);
				$sql='insert into finance (`amount`, `balans`, `type`) values (:am , :bl , "1")';
				$fininsert=$db->prepare($sql);
				$fininsert->execute(ARRAY('am'=>$lnsamount , 'bl'=> $balans));
				$fid = $db->lastInsertId();				
				
				//inserting into fin_type table****************************************************	
				$sql='INSERT INTO `fin_type` (`f_id`,`type`,`real_amount`,`real_currency`,`amount`,`from_id`,`to_id`) 
				VALUES 				
				(:fid, :finsrc, :total, :curr, :ttlusd, :from, "1")';
				$fin_typeinsert=$db->prepare($sql);
				$fin_typeinsert->execute( ARRAY('fid'=>$fid ,'finsrc'=> "18",'total'=> $mblg,'curr'=> $_SESSION['u_curr2'] , 'ttlusd'=> $lnsamount, 'from'=> $_SESSION['lock_id'] ));
				
				$sql='update `user` set l_a_date=curdate() where id=:id limit 1';
				$userupd=$db->prepare($sql);
				$userupd->execute(ARRAY('id'=>$_SESSION['lock_id']));
				if ($trans2 && $with && $fininsert && $fin_typeinsert && $userupd)
				{
					$success = 1;
				}
				else
				{
					$success = 0;
				}
			}
			if(@$_SESSION['fail'] == 'ok' or $success == 0)
			{
				$db->rollBack();
				$_SESSION['fail'] = 'ok';
			}
			else
			{
				$db->commit();
				$_SESSION['success'] = 'ok';
			}
			if (@$_SESSION['success'])
			{ 
				unset($_SESSION['success']); unset($_SESSION['lock_id']);			
			?>
                <div style="margin-top:10px; " class="alert alert-success alert-dismissible fade in" role="alert">
                    <strong class="pay-content"><?PHP echo $yearpay['succ'][$lng]; ?></strong>
				</div>
			<?PHP
			}
			elseif(@$_SESSION['fail'])
			{
                unset($_SESSION['fail']);?>
                <div style="margin-top:10px; " class="alert alert-danger alert-dismissible fade in" role="alert">
                    <strong class="pay-content"><?PHP echo $yearpay['nosucc'][$lng]; ?></strong>
                </div>
			<?php
			}

			//echo '<meta http-equiv="refresh" content="0;url='.$site_url.$lng.'/relogin/" />';			?>
            <a href="<?PHP echo $site_url; ?>" class="btn-back" > <?PHP echo $menu['backbtn'][$lng]; ?>  </a>
        </div>
    </div>
</div>
<style>
    .middle_content--pay {
        padding-top: 25px;
        padding-bottom: 46px;
        text-align: center;
        min-height: 50vh;
    }    .btn-back {
        height: 48px;
        -webkit-box-shadow: 0 2px 2px rgb(15 55 66 / 10%);
        box-shadow: 0 2px 2px rgb(15 55 66 / 10%);        background: #43b9da;        text-shadow: 0 1px 1px rgb(0 0 0 / 15%);        font-size: 24px;
        font-weight: 300;
        border: none;
        padding: 0 20px;
        color: #fff;        line-height: 46px;
        display: inline-block;
        text-decoration: none;
    }    .btn-back:hover {
        opacity: .8;
    }
    .pay-content {        display: block;
        margin-bottom: 22px;
        font-size: 24px;
    }
</style>