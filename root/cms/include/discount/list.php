<?php

if ($_POST['upid']) 

{

  $db->begintransaction();

  $lngins=$db->prepare('UPDATE currency_rates set value=:ord  where id=:udi ');

  $lnginscon=$lngins->execute(array('ord'=>s($_POST['upval']) , 'udi'=>s($_POST['upid']) ));

  if ($lnginscon) 

  {

    $db->commit();

    header('Location:'.$site_url.'currencyrates/list/456852/');

  }

  else

  {

    $db->rollBack();

    header('Location:'.$site_url.'currencyrates/list/456456/');

  }

}


?>

<div class="col-md-14 col-sm-14 col-xs-14">

  <?php 

  if ($_GET['val']=='456852') 

  {

  ?>

  <br></br>

  <div style="margin-top:10px; " class="alert alert-success alert-dismissible fade in" role="alert">

    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

    </button>

    <strong>Process ended with success !</strong>

  </div>

  <?php

  }

  elseif ($_GET['val']=='456456') 

  {

  ?>

  <br></br>

  <div style="margin-top:10px; " class="alert alert-danger alert-dismissible fade in" role="alert">

    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

    </button>

    <strong>Process ended with not success !</strong>

  </div>

  <?php

  }  

  ?>

  <div class="x_panel">

    <div class="x_title">

      <h2>Product discounts</h2>

      <div class="clearfix"></div>

    </div>

    <div class="x_content">
		<a style="float: right;" class="btn btn-success" href="<?php echo $site_url.'discount/add/' ?>"><i class="fa fa-plus"></i> Əlavə et </a>

      <table id="datatable" class="table table-striped table-bordered">

        <thead>

          <tr>

            <th>ID</th>

            <th>Product name</th>

            <th>Discount Value</th>

            <th>Discount_Country</th>

            <th>Discounted_shops</th>

            <th>Real price</th>

            <th>Discounted price</th>

            <th>Start date</th>

            <th>End date</th>

            <th>Status</th>

            <th>Do</th>

          </tr>

        </thead>

        <tbody>

          <?php 

						
			$blogquer=$db->prepare('SELECT md.* , m.name, m.image_url, m.price_1, m.price_2, m.price_3  FROM mehsul_discount md, mehsul m where m.u_id=md.m_u_id and m.l_id=1 order by md.id DESC');

			$blogquer->execute();
			
			while ($b=$blogquer->fetch(PDO::FETCH_ASSOC)) 

          {
			  if($b['mop_id']!=0)
			  {
				  $sql=$db->prepare('SELECT c.short_name cname , o.name oname , mop.price_1, mop.price_2, mop.price_3 FROM currency c, mehsul_olke_price mop, olkeler o where mop.id="'.$b['mop_id'].'" and o.l_id=1 and o.kat_id=mop.o_u_id and o.currency_id=c.u_id and c.l_id=1');
				  $sql->execute();
				  $curr=$sql->fetch(PDO::FETCH_ASSOC);
				  
				  $olke=$curr['oname'];
				  $price1=$curr['price_1'];
				  $price2=$curr['price_2'];
				  $price3=$curr['price_3'];
				  $valy=$curr['cname'];
			  }
			  else
			  {
				  $olke='All countries';
				  $price1=$b['price_1'];
				  $price2=$b['price_2'];
				  $price3=$b['price_3'];
				  $valy='USD';
			  }
			  
			  if($b['type']==1)
			  {
				  //burda mehsulun faizle olan quymeti hesablanacaq
				  $val=$b['value'].'%';
				  $dprice1=ceil(($price1*(100-$b['value']))/100);
				  $dprice2=ceil(($price2*(100-$b['value']))/100);
				  $dprice3=ceil(($price3*(100-$b['value']))/100);
				  
			  }
			  else
			  {
				  //burda ise fixed qiymet cixilacaq
				  $val=$b['value'].' '.$valy;
				  $dprice1=$price1-$b['value'];
				  $dprice2=$price2-$b['value'];
				  $dprice3=$price3-$b['value'];
				  
				
			  }
			  
			  switch ($b['shop_type'])
			  {
				  case '1':
					$shoptype='E-shop:';
					$rprice=$price1.' '.$valy;
					$dprice=$dprice1.' '.$valy;
				  break;
				  case '2':
					$shoptype='Registration:';
					$rprice=$price2.' '.$valy;
					$dprice=$dprice2.' '.$valy;
				  break;
				  case '3':
					$shoptype='Commision Shop:';
					$rprice=$price3.' '.$valy;
					$dprice=$dprice3.' '.$valy;
				  break;
			  }
			  switch($b['s_id'])
			  {
				  case '1':
					$sts='Active';
				  break;
				  case '2':
					$sts='Not started yet';
				  break;
				  case '3':
					$sts='Finished';
				  break;
				  case '4':
					$sts='Manually Stopped';
				  break;
			  }

          ?>

          <tr>
            <td><?php echo $b['id']; ?></td>
            <td><img style="width: 35px;" src="<?php echo $site_url.'images/'.$b['image_url']; ?>"><?php echo $b['name']; ?></td>
            <td><?php echo $val; ?></td>
            <td><?php echo $olke; ?></td>
            <td><?php echo $shoptype; ?></td>
            <td><?php echo $rprice; ?></td>
            <td><?php echo $dprice; ?></td>
            <td><?php echo $b['start']; ?></td>
            <td><?php echo $b['end']; ?></td>
            <td><?php echo $sts; ?></td>
            <td>
				<form style=" float: right;" method="POST" action="<?php echo $site_url.'discount/delete/' ?>">

					<input type="hidden" name="delid" value="<?php echo $b['id'] ?>">

					<button type="button"  onclick="dsomo(this);" name="dbtn"  style="color: red; background-color: rgba(0,0,0,0); border:none;" href="">

						<i class="fa fa-trash fa-2x" ></i>

					</button>

				</form>

				<a style="margin-right: 5px; float: right;" href="<?php echo $site_url.'discount/edit/'.$b['id'].'/' ?>">

				<i class="fa fa-edit fa-2x" ></i> 

				</a>
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