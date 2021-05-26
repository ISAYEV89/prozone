<?PHP
if($_POST['filter']=='filter')
{
	
	$frm='';
	$frmc='';
	$frmp='';
	if(!empty($_POST['startd']))
	{
		$frm.=' and o.bask_orddate >="'.$_POST['startd'].'"';
		$frmc.=' and o.bask_orddate >="'.$_POST['startd'].'"';
	}
	if(!empty($_POST['endd']))
	{
		$frm.=' and o.bask_orddate <="'.$_POST['endd'].'"';
		$frmc.=' and o.bask_orddate <="'.$_POST['endd'].'"';
	}
	if($_POST['country']!=0)
	{
		$frm.=' and o.bask_country ="'.$_POST['country'].'"';
		$frmp.=' and o.bask_country ="'.$_POST['country'].'"';
	}
	if($_POST['city']!=0)
	{
		$frm.=' and o.bask_city ="'.$_POST['city'].'"';
		$frmp.=' and o.bask_city ="'.$_POST['city'].'"';
	}
	if(!empty($_POST['prod']))
	{
		if (($key = array_search(0, $_POST['prod'])) !== false)
		{
			unset($_POST['prod'][$key]);
		}
		if(count($_POST['prod'])>0)
		{
			$arr=implode(',',$_POST['prod']);
			$frm.=' and op.p_id in ('.$arr.')';
		}
	}
	if($_POST['sts']!=0)
	{
		if (($key = array_search(0, $_POST['sts'])) !== false)
		{
			unset($_POST['sts'][$key]);
		}
		if(count($_POST['sts'])>0)
		{
			$arr=implode(',',$_POST['sts']);
			$frm.=' and o.ds_id in ('.$arr.')';
			$frmc.=' and o.ds_id in ('.$arr.')';
		}
		
	}
	if($_POST['pymntsts']!=0)
	{
		if (($key = array_search(0, $_POST['pymntsts'])) !== false)
		{
			unset($_POST['pymntsts'][$key]);
		}
		if(count($_POST['pymntsts'])>0)
		{
			$arr=implode(',',$_POST['pymntsts']);
			echo $frm.=' and o.bask_s_id in ('.$arr.')';
			//$frmc.=' and o.bask_s_id in ('.$arr.')';
		}		
	}
}
else
{
	$frm='and o.bask_orddate >= DATE_ADD(CURDATE(), INTERVAL -100 DAY)';
	$frmc='and o.bask_orddate >= DATE_ADD(CURDATE(), INTERVAL -100 DAY)';
}

//ancaq orders table-da olan olkeleri secmek ucun sql**************************************************************************
$country_arr_sql='select group_concat(bask_country separator ",") as trt from orders o where bask_s_id=2 '.$frmc;
$country_arr=$db->prepare($country_arr_sql);
$country_arr->execute();
$country_ar=$country_arr->fetch(PDO::FETCH_ASSOC);
$allc=$country_ar['trt']; //all countries that are in current selection
/*****************************************************************************************************************************/


//ancaq orders table-da olan sheherleri secmek ucun sql**************************************************************************
$city_arr_sql='select group_concat(DISTINCT bask_city separator ",") as trt from orders o where bask_s_id=2 '.$frmc;
$city_arr=$db->prepare($city_arr_sql);
$city_arr->execute();
$city_arr=$city_arr->fetch(PDO::FETCH_ASSOC);
$allcy=$city_arr['trt']; //all countries that are in current selection
/*****************************************************************************************************************************/


//ancaq orders table-da olan productlari secmek ucun sql**************************************************************************
$prod_arr_sql='select group_concat(DISTINCT op.p_id separator ",") as trt from orders o, order_prod op where bask_s_id=2 and o.id=op.o_id '.$frmc.$frmp;
$prod_arr=$db->prepare($prod_arr_sql);
$prod_arr->execute();
$prod_ar=$prod_arr->fetch(PDO::FETCH_ASSOC);
$allp=$prod_ar['trt']; //all countries that are in current selection
/*****************************************************************************************************************************/



$blogquer=$db->prepare('
SELECT 
	o.*, u.login, u.serial ,cc.name as cname, c.name ccity, cr.NAME curn, op.say 
	
FROM 
	`orders` o, user u , olkeler c,
	(select kat_id, name from olkeler where l_id=1 and sub_id=0) cc,
	currency_rates cr,
    order_prod op

where 
	o.bask_user_id=u.id  and o.bask_city=c.kat_id and c.l_id=1 and o.bask_country=cc.kat_id and bask_currency=cr.id
    and o.id=op.o_id '.$frm.' 

Group by o.id
order by `o`.`bask_orddate` asc , `o`.`id` asc');


$blogquer->execute(); 


$olkesql=$db->prepare('select kat_id, name from olkeler where l_id=1 and sub_id=0 and kat_id in ('.$allc.')');
$olkesql->execute();

if($_POST['country'])
{
	$citysql=$db->prepare('select kat_id, name from olkeler where l_id=1 and sub_id="'.$_POST['country'].'" and kat_id in ('.$allcy.')');
	$citysql->execute();
}

$prodsql=$db->prepare('select u_id, name from mehsul where l_id=1 and s_id=1 and u_id in ('.$allp.')');
$prodsql->execute();
?>
<div class="col-md-14 col-sm-14 col-xs-14">
<div class="x_panel">
    <div class="x_title">
		<form action="" method="post">
			<div  class="col-md-2 col-sm-2 col-xs-2">
				<div class="form-group">
					<label for="datepicker" class="dpl">Start date:</label>
					<input type="text" name="startd" id="datepicker" class="w100">
				</div>
				<div class="form-group">
					<label for="datepicker" class="dpl">end date:</label>
					<input type="text" name="endd" id="datepicker2"  class="w100">
				</div>
			</div>
			<div  class="col-md-3 col-sm-3 col-xs-3">
				<div class="form-group">
					<select name="country" id="countrysel" class="filterselect">
						<option value="0">Countries</option>
						<?PHP
						//$carr=explode(',',$allc);
						$sl='';
						while ($olke=$olkesql->fetch(PDO::FETCH_ASSOC)) 
						{
							if($_POST['country']==$olke['kat_id'])	{	$sl='selected';	}
							else									{	$sl='';			}
							echo'<option value="'.$olke['kat_id'].'" '.$sl.'>'.$olke['name'].'</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<select name="city" id="citysel"  class="filterselect">
						<option value="0">Cities</option>
						<?PHP
						if($citysql)
						{
							$sl='';
							while ($city=$citysql->fetch(PDO::FETCH_ASSOC)) 
							{
								if($_POST['city']==$city['kat_id'])	{	$sl='selected';	}
								else								{	$sl='';			}
								echo'<option value="'.$city['kat_id'].'" '.$sl.'>'.$city['name'].'</option>';
							}							
						}
						?>
					</select>
				</div>
			</div>
			<div  class="col-md-4 col-sm-4 col-xs-4">
				<div class="form-group">
					<select name="prod[]" id="productsel" class="filterselect"  multiple>
						<option value="0">-------</option>
						<?PHP
						$sl='';
						while ($prod=$prodsql->fetch(PDO::FETCH_ASSOC)) 
						{
							if($_POST['prod'])
							{
								if(in_array($prod['u_id'],$_POST['prod']))	{	$sl='selected';	}
								else										{	$sl='';			}
							}
							echo'<option value="'.$prod['u_id'].'"  '.$sl.'>'.$prod['name'].'</option>';
						}
						?>
					</select>
				</div>
			</div>
			<br clear="all"> 
			<div  class="col-md-2 col-sm-1 col-xs-1">
				<div class="form-group">
					<select name="sts[]" id="dsidtsel"  multiple style="width:170px;">
					<?PHP
					$stsname=array('Delivery status','In review','Printed','Shipped','Delivered');
					$sl='';
					for($iy=0;$iy<=4;$iy++)
					{
						if($_POST['sts'])
						{
							if(in_array($iy,$_POST['sts']))	{	$sl='selected';	}
							else							{	$sl='';			}
						}
						
						echo '<option value="'.$iy.'" '.$sl.'>'.$stsname[$iy].'</option>';
					}
					?>						
					</select>
				</div>
			</div>
			<div  class="col-md-2 col-sm-1 col-xs-1">
				<div class="form-group">
					<select name="pymntsts[]" id="sidtsel"  multiple style="width:170px;">
					<?PHP
					$stsname=array('Payment status','Not payed','Already Payed','Payment Failed'); 
					$sl='';
					for($iy=0;$iy<=3;$iy++)
					{
						if($_POST['pymntsts'])
						{
							if(in_array($iy,$_POST['pymntsts']))	{	$sl='selected';	}
							else									{	$sl='';			}
						}						
						echo '<option value="'.$iy.'" '.$sl.'>'.$stsname[$iy].'</option>';
					}
					?>						
					</select>
				</div>
			</div>
			<div  class="col-md-1 col-sm-1 col-xs-1">
				<div class="form-group">
					<h2 style="">Orders list</h2>
					<input type="submit" name="filter" value="filter" />
				</div>
			</div>
		</form>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
		<table id="datatable" class="table table-striped table-bordered" style="font-size:11px;">
			<thead>
			  <tr>
				<th>ID</th>
				<th>Date</th>
				<th>Name and Login</th>
				<th>Address</th>
				<th>Contacts</th>
				<th>Price</th>
				<th>Products</th>
				<th>Point</th>
				<th>Operations</th>
			  </tr>
			</thead>
			<tbody>
			  <?php 
			  $stsname=array(' ','In review','Printed','Shipped','Delivered'); //status names
			  $stscolor=array('','','#82E0AA','#D5F5E3','#D4E6F1');
			  while ($b=$blogquer->fetch(PDO::FETCH_ASSOC)) 
			  {
				$ds_id=$b['ds_id'];
				//creating product list, counts and points sum *********************************	
				$sql_mehsul=$db->prepare('
				SELECT 
					op.say, m.name , m.point
					
				FROM 
					mehsul m,
					order_prod op

				where 
					op.o_id=:id and op.p_id=m.u_id and m.l_id=1');
				$sql_mehsul->execute(ARRAY('id'=>$b['id'])); 
				$product='';
				$point=0;
				while($rd=$sql_mehsul->fetch(PDO::FETCH_ASSOC))
				{
					$product.=$rd['name'].' ( '.$rd['say'].' ) <br />';
					$point+=$rd['say']*$rd['point'];
				}
				//******************************************************************************
			  ?>
				<tr id="tr<?PHP echo $b['id'] ?>" style="background-color: <?PHP echo $stscolor[$ds_id] ?>;">
					<td><?php echo $b['id'] ?></td>
					<td><?php echo $b['bask_orddate'] ?></td>
					<td>
						<span class="labelnm">full name:</span><span class="infoholder"><?php echo $b['bask_fname'].' '.$b['bask_lname']; ?></span><br>
						<?PHP
						if($b['ord_src']==1)
						{
							$sql_gl=$db->prepare('
							SELECT 
								u.login , u.serial 
								
							FROM 
								eshop e,
								user u

							where 
								e.id=:id and u.id=e.u_id limit 1');
							$sql_gl->execute(ARRAY('id'=>$b['bask_user_id'])); 
							$gl=$sql_gl->fetch(PDO::FETCH_ASSOC);
							echo'
							<span class="labelnm">Login:</span><span class="infoholder">'.$gl['login'].'</span><br>
							<span class="labelnm">Serial:</span><span class="infoholder">'.$gl['serial'].'</span><br>';
						}
						elseif($b['ord_src']==2)
						{
							$sql_gl=$db->prepare('
							SELECT 
								u.login , u.serial 
								
							FROM 
								onlinestore u 
								

							where 
								u.id=:id limit 1');
							$sql_gl->execute(ARRAY('id'=>$b['bask_user_id'])); 
							$gl=$sql_gl->fetch(PDO::FETCH_ASSOC);
							echo'
							<span class="labelnm">Login:</span><span class="infoholder">'.$gl['login'].'</span><br>
							<span class="labelnm">Serial:</span><span class="infoholder">'.$gl['serial'].'</span><br>';
						}
						else
						{
							echo'
							<span class="labelnm">Login:</span><span class="infoholder">'.$b['login'].'</span><br>
							<span class="labelnm">Serial:</span><span class="infoholder">'.$b['serial'].'</span><br>';
						}
						?>
						
					</td>
					<td>
						<span class="labeld">Address:</span><span class="infoholder"><?php echo $b['bask_adress']; ?></span><br>
						<span class="labeld">Zip code:</span><span class="infoholder"><?php echo $b['bask_zip']; ?></span><br>
						<span class="labeld">Country:</span><span class="infoholder"><?php echo $b['cname']; ?></span><br>
						<span class="labeld">City:</span><span class="infoholder"><?php echo $b['ccity']; ?></span><br>
						<span class="labeld">State:</span><span class="infoholder"><?php echo $b['bask_zip']; ?></span><br>			
					</td>
					<td>
						<span class="labelc">e-Mail:</span><span class="infoholder"><?php echo $b['bask_mail']; ?></span><br>
						<span class="labelc">Phone:</span><span class="infoholder"><?php echo $b['bask_tel']; ?></span><br>
						<span class="labelc">Mobile:</span><span class="infoholder"><?php echo $b['bask_mob']; ?></span><br>
					</td>
					<td>
						<span class="labelx"><?php echo $b['basket_total']; ?></span><span class="infoholder"><?php echo $b['curn']; ?></span><br>
					</td>
					<td>              
						<?php echo $product; ?>
					</td>
					<td>              
						<?php echo $point; ?>
					</td>
					<td> 
						<?PHP
						if($b['bask_s_id']==1)
						{
							echo'order not payed';
						}
						elseif($b['bask_s_id']==3)
						{
							echo 'order payment failed';
						}
						else
						{
							if($b['ds_id']==5)
							{
							?>
								<select name="ordsts_<?php echo $b['id'] ?>" id="sel_<?php echo $b['id'] ?>" 
								data-id="<?php echo $b['id'] ?>" style="width:120px;" class="sts_sel">		
								<?PHP
								$sl='';
								for($iy=1;$iy<=4;$iy++)
								{
									if($b['ds_id']==$iy){	$sl='selected';	}
									else				{	$sl='';			}
									echo '<option value="'.$iy.'" '.$sl.'>'.$stsname[$iy].'</option>';
								}
								?>						
								</select>
							<?PHP
							}
							else
							{
							?>
								<a style="color:green; margin-right: 14px; float: right;" href="<?PHP echo $site_url;?>orders/assignrp/<?PHP echo $b['id']?>/">
									<i class="fa fa-plus fa-2x"></i> 
								</a>
							<?PHP
							}
						}
						?>
					</td>
				</tr>
			  <?php 
			  }
			  ?>
			</tbody>
		</table>
    </div>
  </div>
</div> 
<style>
.labeld
{
	width:49px;
	display:inline-block;
	font-weight:bold;
	text-align:right;
	margin-right:10px;
	vertical-align:top;
}
.labelc
{
	width:39px;
	display:inline-block;
	font-weight:bold;
	text-align:right;
	margin-right:10px;
	vertical-align:top;
}
.labelnm
{
	width:53px;
	display:inline-block;
	font-weight:bold;
	text-align:right;
	margin-right:10px;
	vertical-align:top;
}
.labelx
{
	min-width:20px;
	display:inline-block;
	font-weight:bold;
	text-align:right;
	margin-right:10px;
	vertical-align:top;
}
.infoholder
{
    display: inline-block;
}
.dpl
{
	min-width: 65px;
    display: inline-block;
	text-align:right;
}
.filterselect
{
	min-width:270px;
	padding:3px;
}
.w100
{
	width:100px;
}
</style>
