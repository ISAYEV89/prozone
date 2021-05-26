<?PHP
	$sql=$db->prepare('select * from stock');

	$sql->execute();

	
?>
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Stock list</h2>	
			<a style="float: right;" class="btn btn-success" href="<?PHP echo $site_url?>/stock/addproduct/"><i class="fa fa-plus"></i> Add New Product</a>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<table class="table table-hover">
				<thead>
					<tr>
					<th>NO</th>
					<th>ID</th>
					<th>BAR CODE</th>
					<th>NAME</th>
					<th>Quantity</th>
					<th>Status</th>
					<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?PHP
					$say=1;
					while($b=$sql->fetch(PDO::FETCH_ASSOC))
					{
						echo '
					<tr>
						<th>'.$say.'</th>
						<td>'.$b['id'].'</td>
						<td>'.$b['code'].'</td>
						<td>'.$b['ad'].'</td>
						<td>'.$b['say'].'</td>
						<td>'.$b['s_id'].'</td>
						<td>
							 <a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/editproduct/'.$b['id'].'/">
								<i class="fa fa-pencil fa-2x"></i> 
							  </a>
						</td>
					</tr>';
					$say++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?PHP

	$sql=$db->prepare('select * from stock_partiya order by ID desc');

	$sql->execute();
?>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Stock Delivery list</h2>
			<a style="float: right;" class="btn btn-success" href="<?PHP echo $site_url?>/stock/adddelivery/"><i class="fa fa-plus"></i> Add New Delivery</a>			
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<table class="table table-hover" id="delivery_list">
				<thead>
					<tr>
						<th><b>NO		</b></th>
						<th><b>ID		</b></th>
						<th><b>BAR CODE	</b></th>
						<th><b>Date		</b></th>
						<th><b>Comment	</b></th>
						<th><b>Status	</b></th>
						<th><b>Action	</b></th>
					</tr>
				</thead>
				<tbody>
					<?PHP
					$say=1;
					while($b=$sql->fetch(PDO::FETCH_ASSOC))
					{
						echo '
					<tr>
						<th>'.$say.'</th>
						<td>'.$b['id'].'</td>
						<td>'.$b['barcode'].'</td>
						<td>'.$b['date'].'</td>
						<td>'.$b['comment'].'</td>
						<td>'.$b['s_id'].'</td>
						<td>
							 <a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/adddelivery2/'.$b['id'].'/">
								<i class="fa fa-list-ul"></i> 
							  </a>
							 <a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/editdelivery/'.$b['id'].'/">
								<i class="fa fa-pencil fa-2x"></i> 
							  </a>
						</td>
					</tr>';
					$say++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?PHP

	$sql=$db->prepare('select srp.* from stock_rp srp order by srp.s_id asc ,srp.ID desc ');

	$sql->execute();
?>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Stock Ready Product list</h2>
			<a style="float: right;" class="btn btn-success" href="<?PHP echo $site_url?>/stock/addrp/"><i class="fa fa-plus"></i> Add New Ready product</a>			
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<table class="table table-hover" id="delivery_list">
				<thead>
					<tr>
						<th><b>ID		</b></th>
						<th><b>Name		</b></th>
						<th><b>Date		</b></th>
						<th><b>Price	</b></th>
						<th><b>Stock Sale price	</b></th>
						<th><b>Amount			</b></th>
						<th><b>Related products	</b></th>
						<th><b>Status			</b></th>
						<th><b>Action			</b></th>
					</tr>
				</thead>
				<tbody>
					<?PHP
					while($b=$sql->fetch(PDO::FETCH_ASSOC))
					{
						
						$sql2=$db->prepare('
						select 
							group_concat(`m`.`name` SEPARATOR " <br>") mname 
						from 
							stock_rp_mehsul srpm, 
							mehsul m 
						where 
							m.l_id=1 and
							m.u_id=srpm.m_uid and
							srpm.srp_id="'.$b['id'].'"');
						$sql2->execute();
						$b2=$sql2->fetch(PDO::FETCH_ASSOC);
						echo '
					<tr>
						<td>'.$b['id'].'</td>
						<td>'.$b['name'].'</td>
						<td>'.$b['date'].'</td>
						<td>'.$b['price'].' $USD</td>
						<td>'.$b['price_sale_stock'].' $USD</td>
						<td>'.$b['say'].' pieces</td>
						<td>'.$b2['mname'].' </td>
						<td>'.$b['s_id'].'</td>
						<td>
							 <a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/addrp2/'.$b['id'].'/">
								<i class="fa fa-list-ul"></i> 
							  </a>'.(($b['s_id']!=10)?'<a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/editrp2/'.$b['id'].'/">
								<i class="fa fa-pencil fa-2x"></i> 
							  </a>':'').'
							 '.(($b['s_id']==10)?'
								<a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/createbarcode/'.$b['id'].'/">
									<i class="fa fa-barcode fa-2x"></i> 
								</a>
								<a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/editrpmehsul/'.$b['id'].'/">
									<i class="fa fa-plus fa-2x"></i> 
								</a>
								<a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/clonerpmehsul/'.$b['id'].'/">
									<i class="fa fa-clone fa-2x"></i> 
								</a>':'').'
						</td>
					</tr>';
					$say++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
