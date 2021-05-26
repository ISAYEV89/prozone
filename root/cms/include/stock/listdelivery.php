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