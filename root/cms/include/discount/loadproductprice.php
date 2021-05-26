<?PHP
include '../../inc/confing.php';

$p_uid=$_GET['puid'];

$lngins=$db->prepare('select * from mehsul where u_id=:uid  and l_id=1 ');

$bo=$lngins->execute(array('uid'=>$p_uid ));
  
$b=$lngins->fetch(PDO::FETCH_ASSOC);

?>
<div class="x_title">

	<h2><?PHP echo $b['name'];?> Standard Prices </h2>

	<div class="clearfix"></div>

</div>
<input type="hidden" name="product" value="<?PHP echo $p_uid; ?>">
<div class="x_content">   
	<div class="form-group" id="allcount"  >
		<label class="control-label col-md-3 col-sm-3 col-xs-12">Eshop price - <span style="border:1px solid black;display: inline-block;padding: 3px;"><?PHP echo $b['price_1'];?> $USD</span>:</label>
		<div class="col-md-9 col-sm-9 col-xs-12" style="padding-top:8px;">
			<input type="text" name="v|0|1" />
			<select name="t|0|1" style="height: 24px;   width: 70px;">
				<option value="1">%</option>
				<option value="2">fixed</option>
			</select>
		</div>
	</div>   
	<div class="form-group" id="allcount"  >
		<label class="control-label col-md-3 col-sm-3 col-xs-12">Registration price - <span style="border:1px solid black;display: inline-block;padding: 3px;"><?PHP echo $b['price_2'];?> $USD</span>:</label>
		<div class="col-md-9 col-sm-9 col-xs-12"  style="padding-top:8px;">
			<input type="text" name="v|0|2" />
			<select name="t|0|2" style="height: 24px;   width: 70px;">
				<option value="1">%</option>
				<option value="2">fixed</option>
			</select>
		</div>
	</div>   
	<div class="form-group" id="allcount"  >
		<label class="control-label col-md-3 col-sm-3 col-xs-12">Commission shop - <span style="border:1px solid black;display: inline-block;padding: 3px;"><?PHP echo $b['price_3'];?> $USD</span>:</label>
		<div class="col-md-9 col-sm-9 col-xs-12" style="padding-top:8px;">
			<input type="text" name="v|0|3" />
			<select name="t|0|3" style="height: 24px;   width: 70px;">
				<option value="1">%</option>
				<option value="2">fixed</option>
			</select>
		</div>
	</div>
</div>


<?PHP
$oc=$db->prepare('select o.* , mop.price_1 , mop.price_2 , mop.price_3, c.short_name, mop.id mopid from mehsul_olke_price mop, olkeler o, currency c where mop.m_u_id=:muid and o.kat_id=mop.o_u_id and o.l_id=1 and o.currency_id=c.u_id and c.l_id=1');
$oc->execute(array('muid'=>$p_uid ));

while($b1=$oc->fetch(PDO::FETCH_ASSOC))
{
	?>
	<div class="x_title">

		<h2><?PHP echo $b['name'];?> prices for <?PHP echo $b1['name'];?> </h2>

		<div class="clearfix"></div>

	</div>
	<div class="x_content">   
		<div class="form-group" id="allcount"  >
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Eshop price - <span style="border:1px solid black;display: inline-block;padding: 3px;"><?PHP echo $b1['price_1'].' '.$b1['short_name'];?> </span>:</label>
			<div class="col-md-9 col-sm-9 col-xs-12" style="padding-top:8px;">
				<input type="text" name="v|<?PHP echo $b1['mopid']; ?>|1" />
				<select name="t|<?PHP echo $b1['mopid']; ?>|1" style="height: 24px;   width: 70px;">
					<option value="1">%</option>
					<option value="2">fixed</option>
				</select>
			</div>
		</div>   
		<div class="form-group" id="allcount"  >
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Registration price - <span style="border:1px solid black;display: inline-block;padding: 3px;"><?PHP echo $b1['price_2'].' '.$b1['short_name'];?></span>:</label>
			<div class="col-md-9 col-sm-9 col-xs-12"  style="padding-top:8px;">
				<input type="text" name="v|<?PHP echo $b1['mopid']; ?>|2" />
				<select name="t|<?PHP echo $b1['mopid']; ?>|2" style="height: 24px;   width: 70px;">
					<option value="1">%</option>
					<option value="2">fixed</option>
				</select>
			</div>
		</div>   
		<div class="form-group" id="allcount"  >
			<label class="control-label col-md-3 col-sm-3 col-xs-12">Commission shop - <span style="border:1px solid black;display: inline-block;padding: 3px;"><?PHP echo $b1['price_3'].' '.$b1['short_name'];?></span>:</label>
			<div class="col-md-9 col-sm-9 col-xs-12" style="padding-top:8px;">
				<input type="text" name="v|<?PHP echo $b1['mopid']; ?>|3" />
				<select name="t|<?PHP echo $b1['mopid']; ?>|3" style="height: 24px;   width: 70px;">
					<option value="1">%</option>
					<option value="2">fixed</option>
				</select>
			</div>
		</div>
	</div>
	
	<?PHP
}

?>