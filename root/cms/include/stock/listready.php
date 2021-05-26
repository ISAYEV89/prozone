<?PHP

	$sql=$db->prepare('select * from stock_rp order by ID desc');

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
						<th><b>Status			</b></th>
						<th><b>Action			</b></th>
					</tr>
				</thead>
				<tbody>
					<?PHP
					while($b=$sql->fetch(PDO::FETCH_ASSOC))
					{
						echo '
					<tr>
						<td>'.$b['id'].'</td>
						<td>'.$b['name'].'</td>
						<td>'.$b['date'].'</td>
						<td>'.$b['price'].' $USD</td>
						<td>'.$b['price_sale_stock'].' $USD</td>
						<td>'.$b['say'].' pieces</td>
						<td>'.$b['s_id'].'</td>
						<td>
							 <a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/addrp2/'.$b['id'].'/">
								<i class="fa fa-list-ul"></i> 
							  </a>'.(($b['s_id']!=10)?'<a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/editrp2/'.$b['id'].'/">
								<i class="fa fa-pencil fa-2x"></i> 
							  </a>':'').'
							 '.(($b['s_id']==10)?'<a style="color:green; margin-right: 14px; float: right;" href="'.$site_url.'/stock/createbarcode/'.$b['id'].'/">
								<i class="fa fa-barcode fa-2x"></i> 
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