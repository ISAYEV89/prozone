<?php 
if(isset($page) && $page=='shop_category'){

	$gelen_url = strip_tags($_GET['val']);
	$select_kat = '';
	$select_olke_kat = '';
	if(strpos($gelen_url, '-')!==FALSE){
		$url_parcala = explode('-',$gelen_url);
		if(is_array($url_parcala) && count($url_parcala)==2){
			$select_kat = " `elanlar`.kat_id='".mysqli_real_escape_string($connection,$url_parcala[1])."' and ";
			$olke_url = mysqli_real_escape_string($connection,$url_parcala[0]);
		}else{
			die('Yanlish cehd edirsiz!');
		}
	}else{
		$olke_url = mysqli_real_escape_string($connection,$_GET['val']);
	}
	$olke_kategoriyalari = [];
	$secilen_olke = mysqli_query($connection,"select * from `olkeler` where l_id='".$lng."'  and s_id='0' and url_tag='".$olke_url."' limit 1");
	if(mysqli_num_rows($secilen_olke)>0)
	{
		$secilmish_olke = mysqli_fetch_array($secilen_olke);
	
		$vayutalar = [];

		$sql_val = @mysqli_query($connection,"select kat_id, name from valyuta where l_id='".$lng."'") or die('error val.');
		while($row = mysqli_fetch_assoc($sql_val)){
			$valyutalar[$row['kat_id']] = $row['name'];
		}
		// mehsul hissesi
		$mehsul_olke = mysqli_query($connection,"select * from mehsul_olke where olke_id='".$secilmish_olke['kat_id']."'");
		/*
		butun hallar
		1. halda all country secilen ama icinde qiymeti ferqli olmayanlar (en axrnci shertde)
		2. halda all country secilen ama icinde qiymeti ferqli olanlar
		3. halda all country secilen qiymeti ferqli olanlar ve olmayanlar birge 
		4. halda all country secilmeyen ancaq qiymeti ferqli olan
		5. halda all country secilmeyen ve umumiyyetle bu olkeye aid olmayanlir

		*/
		// ferqli qiymeti olan mehsullar tablesinden olkenin id-sne uygun olanlar 
		if(mysqli_num_rows($mehsul_olke)>0){
			$ferqli_qiymetli_mehsullar = [];
			$i=0;
			while($row = mysqli_fetch_assoc($mehsul_olke)){
				$ferqli_qiymetli_mehsullar['elan_id'][$i] = $row['elan_id'];
				$ferqli_qiymetli_mehsullar['olke_id'][$row['elan_id']] = $row['olke_id'];
				$ferqli_qiymetli_mehsullar['price1'][$row['elan_id']] = $row['price1'];
				$ferqli_qiymetli_mehsullar['price2'][$row['elan_id']] = $row['price2'];
				$ferqli_qiymetli_mehsullar['price3'][$row['elan_id']] = $row['price3'];
				$ferqli_qiymetli_mehsullar['valyuta_id'][$row['elan_id']] = $row['valyuta_id'];
				$i++;
			}
			$all_country_elanlar = mysqli_query($connection, "select * from elanlar where {$select_kat} l_id='".$lng."' and s_id='0'");
			$j=0;
			$all_qiymetli_mehsullar = [];
			while($row = mysqli_fetch_assoc($all_country_elanlar)){
				if($row['all_country']==1){
					// 2-ci hali yeni all_country 1 olan ama ferqli qiymetli bashqa mehsullar da olan 
					if(in_array($row['elan_id'],$ferqli_qiymetli_mehsullar['elan_id'])){
					
						if(!in_array($row['kat_id'],$olke_kategoriyalari)){
							$olke_kategoriyalari[] = $row['kat_id'];
						}

						$all_qiymetli_mehsullar['elan_id'][$j]   = $row['elan_id'];
						$all_qiymetli_mehsullar['name'][$j]      = $row['name'];
						$all_qiymetli_mehsullar['image_url'][$j] = $row['image_url'];
						$all_qiymetli_mehsullar['price1'][$j]    = $ferqli_qiymetli_mehsullar['price1'][$row['elan_id']];
						$all_qiymetli_mehsullar['price2'][$j]    = $ferqli_qiymetli_mehsullar['price2'][$row['elan_id']];
						$all_qiymetli_mehsullar['price3'][$j]    = $ferqli_qiymetli_mehsullar['price3'][$row['elan_id']];
						$all_qiymetli_mehsullar['valyuta_id'][$j]= $ferqli_qiymetli_mehsullar['valyuta_id'][$row['elan_id']];
					}else{

						if(!in_array($row['kat_id'],$olke_kategoriyalari)){
							$olke_kategoriyalari[] = $row['kat_id'];
						}

						// 3. halda  -  yeni dovrun gedishatinda ferqli qiymeti olmayan ama all_country-si 1 olanlar
						$all_qiymetli_mehsullar['elan_id'][$j]    = $row['elan_id'];
						$all_qiymetli_mehsullar['name'][$j]       = $row['name'];
						$all_qiymetli_mehsullar['image_url'][$j]  = $row['image_url'];
						$all_qiymetli_mehsullar['price1'][$j]     = $row['price1'];
						$all_qiymetli_mehsullar['price2'][$j]     = $row['price2'];
						$all_qiymetli_mehsullar['price3'][$j]     = $row['price3'];
						$all_qiymetli_mehsullar['valyuta_id'][$j] = $row['valyuta_id'];
					}
				}else{	
					// butun olkelere aid olmayan ancaq - ferqli qiymeti olanlari olan
					$ferqli_qiymetli_olkeler = explode(',',$row['different_price_country']);
					// bu olkenin idsi different_price_idnin icinde olan
					if(in_array($secilmish_olke['kat_id'],$ferqli_qiymetli_olkeler)){

						if(!in_array($row['kat_id'],$olke_kategoriyalari)){
							$olke_kategoriyalari[] = $row['kat_id'];
						}

						$all_qiymetli_mehsullar['elan_id'][$j]    = $row['elan_id'];
						$all_qiymetli_mehsullar['name'][$j]       = $row['name'];
						$all_qiymetli_mehsullar['image_url'][$j]  = $row['image_url'];
						$all_qiymetli_mehsullar['price1'][$j]     = $ferqli_qiymetli_mehsullar['price1'][$row['elan_id']];
						$all_qiymetli_mehsullar['price2'][$j]     = $ferqli_qiymetli_mehsullar['price2'][$row['elan_id']];
						$all_qiymetli_mehsullar['price3'][$j]     = $ferqli_qiymetli_mehsullar['price3'][$row['elan_id']];
						$all_qiymetli_mehsullar['valyuta_id'][$j] = $ferqli_qiymetli_mehsullar['valyuta_id'][$row['elan_id']];
					}else{
					
						continue;
					}
				}
				$j++;
			}

		}else{
		
			$all_country_elanlar = mysqli_query($connection, "select * from elanlar where {$select_kat} all_country='1' and l_id='".$lng."' and s_id='1'");
			$j=0;
			$all_qiymetli_mehsullar = [];
			while($row = mysqli_fetch_assoc($all_country_elanlar)){
				if(!in_array($row['kat_id'],$olke_kategoriyalari)){
					$olke_kategoriyalari[] = $row['kat_id'];
				}
				$all_qiymetli_mehsullar['elan_id'][$j]    = $row['elan_id'];
				$all_qiymetli_mehsullar['image_url'][$j]  = $row['image_url'];
				$all_qiymetli_mehsullar['name'][$j]       = $row['name'];
				$all_qiymetli_mehsullar['price1'][$j]     = $row['price1'];
				$all_qiymetli_mehsullar['price2'][$j]     = $row['price2'];
				$all_qiymetli_mehsullar['price3'][$j]     = $row['price3'];
				$all_qiymetli_mehsullar['valyuta_id'][$j] = $row['valyuta_id'];
				$j++;
			}
		}
		/*
		echo "<pre>";
		var_dump($all_qiymetli_mehsullar);
		echo "</pre>";
		die();
		*/
		$olke_kateqoriya  = mysqli_query($connection,"select kat_id from olke_kateqoriya where olke_id='".$secilmish_olke['kat_id']."' order by kat_id asc") or die('error olke-kat');
		$in_this_ids = '';
		if(mysqli_num_rows($olke_kateqoriya)>0){
			$in_this_ids = 'kat_id in(';
			while($row = mysqli_fetch_assoc($olke_kateqoriya)){
				$in_this_ids .= $row['kat_id'].',';
			}
		
			$in_this_ids = rtrim($in_this_ids,',');
			$in_this_ids .= ') ';
			$select_kat_olke = 'SELECT * from `kateqoriyalar` where '.$in_this_ids.' and l_id="'.$lng.'" and status=0   ORDER BY ordering desc';
		}else{
			$select_kat_olke = 'SELECT * from `kateqoriyalar` where kat_id="nulldata" and l_id="'.$lng.'" and status=0   ORDER BY ordering desc';
		}
	}else{
		die('bele olke bazada yoxdur');
	}
	/*
	die('err2');
	if(isset($kat_id) && is_numeric($kat_id)){
		$sql = "select * from `kateqoriyalar` where l_id='".$lng."'  and s_id='0' and kat_id='".$kat_id."' limit 1";
	$result = mysqli_fetch_assoc(mysqli_query($connection,$sql)) or die('bele kateqoriya yoxdur');
	
	if(count($olke_kategoriyalari)>1){
			$select_olke_kat = "  kat_id in(".implode(',',$olke_kategoriyalari).") ";
	}elseif(count($olke_kategoriyalari)==1){
			$select_olke_kat = "  kat_id in(".$olke_kategoriyalari[0].") ";
	}else{
			$select_olke_kat = "  kat_id in(0) ";
	}

	*/

?>


<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title">Продукция</h1>
			</div>
			<div class="middle_content clearfix">
				<div class="left_sidebar">
					<div class="block_products_sidebar">
						<div class="block_content">
						<?php
								$olkeler=mysqli_QUERY($connection,'SELECT * from olkeler');
								// die($select_kat_olke);
								$product_cat=mysqli_QUERY($connection,$select_kat_olke);
								// $olkeler['kat_id']=  $product_cat['different_country'];
								if(mysqli_num_rows($product_cat)>0){
								while($product_cats=MYSQLI_FETCH_ARRAY($product_cat))
								{	
 						?>
								<div class="col active col_1">
									<div class="image"><a href="#"><img src="images/prod_1.svg" alt=""></a></div>
									<div class="title"><div class="field_content">
										<a href="<?=$site_url.$lng2;?>/shop_category/<?=$olke_url.'-'.$product_cats['kat_id']?>/"><?php echo $product_cats['name']?></a>
									</div></div>
								</div>
						<?php }
					}else{
						die('No product');
					}
						?>
						</div>
					</div>
				</div>	
				<div class="page_content">
					<div class="block_goods good_page">
						<div class="good_header clearfix">
							<div class="label">Сортировать по:</div>
							<div class="links_wrap">
								<a href="#" class="link active">Цена<span></span></a>
								<a href="#" class="link">Популярность</a>
								<a href="#" class="link">Новизна</a>
							</div>
						</div>
						<div class="good_content">
							
							<?php 
						// $pro= mysqli_query($connection,"SELECT * FROM elanlar");
							for ($i=0; $i < count($all_qiymetli_mehsullar['elan_id']); $i++) { 
								// explode('||', $all_qiymetli_mehsullar['image_url'][$i])[0]//parcaliyib ilkin gotur

							?>

							<a href="<?=$site_url.$lng2;?>/single/<?=$olke_url.'/'.$all_qiymetli_mehsullar['elan_id'][$i]?>/" target="_blank">
								
									<div class="col col_<?=($i+1);?>">
										<div class="image">
											<div class="field_content"><img src="<?=$site_url?>products/elanlar/<?=explode('||', $all_qiymetli_mehsullar['image_url'][$i])[0];?>"></div>
										</div>
										<div class="title"><a href="<?=$site_url.$lng2;?>/single/<?=$olke_url.'/'.$all_qiymetli_mehsullar['elan_id'][$i]?>/" target="_blank"><?=$all_qiymetli_mehsullar['name'][$i];?></a></div>
										<div class="price_wrap">
											<div class="old_price"><?=$all_qiymetli_mehsullar['price1'][$i];?></div>
											<div class="price"><?=$all_qiymetli_mehsullar['price2'][$i];?><span><?=$valyutalar[$all_qiymetli_mehsullar['valyuta_id'][$i]];?></span></div>
										</div>
										</a> 
										<!-- <div class="add_to_basket"><a href="#">Купить</a></div> -->
										<form method="post" action="<?=$site_url.$lng2?>/basket/add__<?php echo $all_qiymetli_mehsullar['elan_id'][$i];?>/">
										<div class="add_to_basket">
											<input type="hidden" name="quantity" value="1" size="" />
											<input type="hidden" name="ccid" value="<?=$secilmish_olke['kat_id'];?>" size="" />
											<input data-text="Add To Cart" type="submit" value="Səbətə at" class="add_to_basket" style="background: transparent; border: 2px solid #43b9da; padding: 6px 15px;" /></div></form>
									</div>
							
							
							<?php 
								if($i>0 && ($i%3)==0){
									// echo '<div class="line">Разделяющая черта</div>';
								}
							}
							?> 
						</div>

						<section class="paginator">
							<ul>
							<li class="paginator-prev"><a href="#"></a></li>
								<li><a href="#">1</a></li>
								<li class="active"><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li class="paginator-next"><a href="#"></a></li>
							</ul>
						</section>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php 
	/*
	}else{
		die();
	}
	*/
}else{

}
?>