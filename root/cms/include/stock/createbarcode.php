
<?PHP
		//echo'<pre>';
		//print_r($_SESSION);
		//echo'</pre>';
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	$id=$_GET['val'];
	
	
	
	$sql=$db->prepare('select * from stock_rp where id=:id and s_id=10 limit 1');

	$sql->execute(ARRAY("id"=>$id));
	
	$b=$sql->fetch(PDO::FETCH_ASSOC);
	if($b['id'])
	{
		if(!empty($b['md5']))
		{
			$svg=$b['barcode_src'];
		}
		else
		{
			//barcode creation phase**********************
			include('barcode.php');
			$generator = new barcode_generator();
			//********************************************
			//********************************************
			$length = 10;
			$used_symbols = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
			 
			$data=substr(str_shuffle($used_symbols), 0, $length);
			$options='';
			$format='png';
			$symbology='code-128';
			
			$svg = $generator->render_svg($symbology, $data, $options);
			//echo $svg;
			//********************************************
			
			//Updateing database with new data************
			$sql=$db->prepare('update stock_rp set md5= :data, barcode_src= :svg where id=:id and s_id=10 limit 1');

			$sql->execute(ARRAY("id"=>$id , "data"=>$data , "svg"=> $svg));
			//********************************************
		}
		$name=$b['name'];
		?>
		<div class="col-md-10 col-sm-10 col-xs-10" id="printable">
			<div class="printarea" >
				<img src="<?PHP echo $site_url; ?>images/logoesas1.svg" alt="LNS | Вместе для лучшей жизни" title="LNS | Вместе для лучшей жизни" width="200" style="    float: left; margin: 44px;">
				<div style="text-align: left; padding: 10px;">
					<span style="font-weight: bold;    font-size: 16px;    color: black;    padding-left: 19px;"><?PHP echo $name;?></span><br />
					<?PHP echo $svg;?>
				</div>
				
			</div>
			<button class="print avoid-this" >PRINT this</button>
		</div>
		<?PHP
		
	}
	else
	{
		echo "<br><br><center><b><font size='4' color='red'>This product is not Finalised or does not exist!</font></b></center></br><br>
		<script>
		function redi(){
		document.location='$site_url/stock/listready/'
		}
		setTimeout(\"redi()\", 3000);
		</script>";
	}
	

/* Output directly to standard output. */
//$generator->output_image($format, $symbology, $data, $options);

/* Create bitmap image. */
//$image = $generator->render_image($symbology, $data, $options);
//imagepng($image);
//imagedestroy($image);

/* Generate SVG markup. */

?>
<style>
.printarea
{
	size: 8.5in 11in;
	border: 3px solid black;
	background:white;
	text-align: center;
}
</style>

