 <?php 
if(isset($u_id) && $u_id!=""){
	$sql = "select * from `site_menu` where l_id='".$lng."'  and status='0' and u_id='".$u_id."' limit 1";
	// die($sql);
	$result = mysqli_fetch_assoc(mysqli_query($connection,$sql)) or die('bele menu yoxdur');

 ?> 
 <br><br>
 <div class="middle">
		<div class="container">
				<div class="block_products">
					<div class="block_title">Ölkələr</div>
					<div class="block_content">
							<?php
								$country=mysqli_QUERY($connection,'SELECT * from `olkeler` where l_id="'.$lng.'" and sub_id=0 ORDER BY ordering desc');
								while($country_list=MYSQLI_FETCH_ARRAY($country))
								{	
 							?>
		
						<div class="col col_1">
								<div class="image"><a href="<?PHP echo $lng2; ?>/shop_category/<?PHP echo $country_list['url_tag'] ; ?>/"><img src="products/<?php echo $country_list['image_url'];?>" alt=""></a></div>
								<div class="title"><a href="<?PHP echo $site_url.$lng2; ?>/shop_category/<?PHP echo $country_list['url_tag'] ; ?>/"><?php echo $country_list['name'];?></a></div>
						</div>

						<?php }?>
							
					</div>
				</div>
		</div>
	</div>
<?php
}else{
	//
}

?>