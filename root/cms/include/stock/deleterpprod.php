
<?PHP
		//echo'<pre>';
		//print_r($_SESSION);
		//echo'</pre>';
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
	$id=$_GET['val'];
	
		/*
		$prid=$_POST['prid'];
		$td=explode('|',$prid);
		
		$sppid=$td[1];
		$spid=$td[0];
		
		$prsay=$_POST['prsay'];
		*/
		$sql=$db->prepare('select * from stock_rp_prod where id=:id limit 1');
		$sql->execute(ARRAY('id'=>"$id"));
		$b=$sql->fetch(PDO::FETCH_ASSOC);
		$prid=$b['pr_id'];
		$pid=$b['p_id'];
		$pnu=$b['pnu'];
		$psu=$b['psu'];
		$prsay=$b['say'];
		$rp_id=$b['rp_id'];
		$sppid=$b['spp_id'];
		
		$sql=$db->prepare('update stock_rp_prod set s_id=2 where id=:id');
		$sql->execute(ARRAY('id'=>"$id"));
		
		//$srp_id= $db->lastInsertId();
		
		//*******Updating count in stock table***********************************
		$sql=$db->prepare('update stock set say = say + :say where id= :id');
		$sql->execute(ARRAY('id'=>"$prid",'say'=>"$prsay"));
		//***********************************************************************		
		
		//*******Updating stock_rp prices update ***********************************
		$pn=$pnu*$prsay;
		$ps=$psu*$prsay;
		$sql=$db->prepare('update stock_rp set price =price - :pn , price_sale_stock= price_sale_stock - :ps where id= :id');
		$sql->execute(ARRAY('id'=>"$id",'pn'=>"$pn", 'ps'=>"$ps"));
		//***********************************************************************
		
		//*******Updating stock_par_prod for say ***********************************
		$pn=$pnu*$prsay;
		$ps=$psu*$prsay;
		$sql=$db->prepare('update stock_par_prod set say =say + :say where id= :id');
		$sql->execute(ARRAY('id'=>"$sppid",'say'=>"$prsay"));
		//***********************************************************************	
		
		//*******inserting to stock_log ***********************************
		$fl=$_SESSION['flogin_id'];
		$sql=$db->prepare('insert into stock_log (p_id, say, type, src, price_buy, src_id, s_id, a_id) values (:prid, :prsay, 5, 3, :prvalue, :spp_id, 1, :a_id)');
		$sql->execute(ARRAY('spp_id'=>"$id",'prid'=>"$prid",'prsay'=>"$prsay",'prvalue'=>"$ps" , 'a_id'=>"$fl"));
		//***********************************************************************	
		
		
		echo "<br><br><center><b><font size='4' color='red'>Product deleted from list</font></b></center></br><br>
		<script>
		function redi(){
		document.location='$site_url/stock/addrp2/$rp_id/'
		}
		setTimeout(\"redi()\", 3000);
		</script>";
	
	
?>


		
