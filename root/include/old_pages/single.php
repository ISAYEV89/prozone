<?php 
if(!isset($_GET['page']) or $_GET['page']!='single' or !isset($_GET['val']) or !is_numeric($_GET['val'])){
	echo'<script>window.location="'.$site_url.'";</script>';   
	die();
}
$id = (int)$_GET['val'];

?>
<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<div class="page_title">Продукция</div>
			</div>
			<div class="middle_content clearfix">
				<div class="left_sidebar">
					<div class="block_products_sidebar">
					<!-- 	<div class="block_content">
								<?php
								$olkeler=mysqli_QUERY($connection,'SELECT * from olkeler');
								$product_cat=mysqli_QUERY($connection,'SELECT * from `kateqoriyalar` where '.$select_olke_kat.' and l_id="'.$lng.'" and status=0   ORDER BY ordering desc');
								// $olkeler['kat_id']=  $product_cat['different_country'];
								while($product_cats=MYSQLI_FETCH_ARRAY($product_cat))
								{	
 						?>
								<div class="col active col_1">
									<div class="image"><a href="#"><img src="images/prod_1.svg" alt=""></a></div>
									<div class="title"><div class="field_content">
										<a href="<?=$site_url.$lng2;?>/shop_category/<?=$olke_url.'-'.$product_cats['kat_id']?>/"><?php echo $product_cats['name']?></a>
									</div></div>
								</div>
						<?php }?> -->
	
						</div>
					</div>
				</div>	
				<?php 
						
                    	$products= mysqli_query($connection,"SELECT name, image_url, description, elan_id FROM elanlar WHERE l_id='".(int)$lng."' AND elan_id='".(int)mysqli_real_escape_string($connection,trim(strip_tags($id)))."' ORDER BY elan_id DESC LIMIT 1") or die("xeta");
           			 
                    	if(mysqli_num_rows($products)>0){
                    		
                    		$row = mysqli_fetch_array($products);
                ?>
				<div class="page_content node_goods">
					<h1 class="node_title"><?=$row['name']?></h1>
					<div class="node_top clearfix">
						<div class="node_field article">
							<span class="label">Артикул:</span>
							<span class="field_content">45971644</span>
						</div>
						<div class="node_field available">
							<span class="field_content">Есть в наличии</span>
						</div>
						<div class="node_field reviews_count">
							<span class="label">Отзывов:</span>
							<span class="field_content">254</span>
						</div>
					</div>
					<div class="node_main_wrap clearfix">
						<div class="image_wrapper">
							<div class="main_images">
								<div class="image"><a href="#"><img src="images/node_good.png" alt=""></a></div>
								<div class="image"><a href="#"><img src="images/node_good.png" alt=""></a></div>
								<div class="image"><a href="#"><img src="images/node_good.png" alt=""></a></div>
							</div>
							<div class="thumb_images">
								<div class="image"><div class="field_content">
									<img src="images/node_good_1.png" alt="">
								</div></div>
								<div class="image"><div class="field_content">
									<img src="images/node_good_2.png" alt="">
								</div></div>
								<div class="image"><div class="field_content">
									<img src="images/node_good_3.png" alt="">
								</div></div>
							</div>
						</div>
						<div class="price_wrapper">
							<div class="old_price">2 699</div>
							<div class="price">1 999 руб</div>
							<div class="good_basket clearfix">
								<div class="good_basket_btns clearfix">
									<div class="good_basket_min">Минус</div>
									<input type="text" class="good_basket_input form_text" disabled value="1">
									<div class="good_basket_plus">Плюс</div>
								</div>
								<div class="good_basket_add"><a href="#">Купить</a></div>
							</div>
							<div class="one_click">Купить в один клик</div>
							<div class="short_desc">
								К услугам покупателей часов LNS все функции веб-сайта, помогающие сделать верный выбор часов экстра-класса. В этом кроется единственная причина успеха компании LNS.
							</div>
							<div class="countdown_block">
								<div class="block_content">
									<div class="time_wrap">
										<div class="time_title">До конца акции осталось:</div>
										<div class="countdown_origin" data-time="15052017">
											<div class="countdown_layout">
												<span class="tim">
													<span class="digit_group digit_group_1">
														<span class="digit count{d10}">{d10}</span>
														<span class="digit count{d1}">{d1}</span>		
													</span>
												    <span class="digit_Sep"></span>
													<span class="digit_group">
														<span class="digit count{h10}">{h10}</span>
														<span class="digit count{h1}">{h1}</span>
													</span>
												    <span class="digit_Sep"></span>
													<span class="digit_group">
														<span class="digit count{m10}">{m10}</span>
														<span class="digit count{m1}">{m1}</span>
													</span>
												    <span class="digit_Sep"></span>
													<span class="digit_group last">
														<span class="digit count{s10}">{s10}</span>
														<span class="digit count{s1}">{s1}</span>
													</span>
												</span>
												<span class="text">
												    <span class="day_text time_text">{dl}</span>
												    <span class="hour_text time_text">{hl}</span>
												    <span class="min_text time_text">{ml}</span>
												    <span class="sec_text time_text">{sl}</span>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				       <?php 

                    	}else{
                        	echo'<script>window.location="'.$site_url.'";</script>'; 
                        	die();
                    	}
		            ?>
			</div>
		</div>
	</div>
