 <?php 
if(isset($u_id) && $u_id!=""){
	$sql = "select * from `site_menu` where l_id='".$lng."'  and status='0' and u_id='".$u_id."' limit 1";
	// die($sql);
	$result = mysqli_fetch_assoc(mysqli_query($connection,$sql)) or die('bele menu yoxdur');

 ?> 
 	<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title"><?=$result["name"]?></h1>
			</div>
			<div class="about_menu">
				<div class="block_content">
					<ul class="menu">
		                <?php
		                	if($result["sub_id"]==0){
		                		$sub=mysqli_QUERY($connection,'SELECT * from `site_menu` where l_id="'.$lng.'" and sub_id="'.$u_id.'" ORDER BY ordering desc');
		                	}else{
		                		$sub=mysqli_QUERY($connection,'SELECT * from `site_menu` where l_id="'.$lng.'" and sub_id="'.$result["sub_id"].'" ORDER BY ordering desc');
		                	}

							while($sub_menu=MYSQLI_FETCH_ARRAY($sub))
							{		
 						?>

						<li><a <?php echo $sub_menu['url_tag']==$_GET["val"] ? 'class="active"' : '';?> href="<?PHP echo $site_url.$lng2; ?>/pages/<?PHP echo $sub_menu['url_tag'] ; ?>/"><?php echo $sub_menu['name'];?></a></li>

						<?php }?>
					</ul>
				</div>
			</div>
			<div class="middle_content about_page clearfix">
				<div class="short_desc clearfix">
					<div class="main_desc">
						<?=$result["name"]?>
					</div>
					<div class="image">
						<img src="<?php echo $site_url;?>products/<?php echo $result['photo'];?>">
					</div>
					<div class="description">
						<?=$result["text"]?></p>
					</div>
				</div>
				<div class="about_wrap clearfix">
					<div class="about_sidebar">
						<div class="socials_buttons">
							<div class="social_label">Поделиться:</div>
							<div class="social-likes" data-counters="no">
								<div class="facebook" title="Поделиться ссылкой на Фейсбуке"><span>Facebook</span></div>
								<div class="vkontakte" title="Поделиться ссылкой во Вконтакте"><span>Вконтакте</span></div>
								<div class="plusone" title="Поделиться ссылкой в Гугл-плюсе"><span>Google</span>+</div>
								<div class="twitter" title="Поделиться ссылкой в Твиттере"><span>Twitter</span></div>
							</div>
							<!-- AddToAny BEGIN -->
							<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
							<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
							<a class="a2a_button_viber"></a>
							<a class="a2a_button_whatsapp"></a>
							<a class="a2a_button_telegram"></a>
							</div>
							<script async src="https://static.addtoany.com/menu/page.js"></script>
							<!-- AddToAny END -->
						</div>
					</div>
					<div class="about_main">
						<!-- <div class="benefits_wrap">
							<div class="col">
								<div class="image">
									<div class="field_content"><img src="images/benefit_1.svg" alt=""></div>
								</div>
								<div class="title"> Огромный выбор<br> товаров в наличии<br> и на заказ</div>
							</div>
							<div class="col">
								<div class="image">
									<div class="field_content"><img src="../images/benefit_2.svg" alt=""></div>
								</div>
								<div class="title">Отдаем безусловный <br> приоритет покупателю, <br> нежели прибыли</div>
							</div>
							<div class="col">
								<div class="image">
									<div class="field_content"><img src="images/benefit_3.svg" alt=""></div>
								</div>
								<div class="title">Только<br> сертифицированный<br> товар</div>
							</div>
							<div class="col">
								<div class="image">
									<div class="field_content"><img src="images/benefit_4.svg" alt=""></div>
								</div>
								<div class="title">Прием заказов 24 часа <br> в сутки</div>
							</div>
						</div> -->
					<!-- 	<div class="main_text">
							<h3>Любые действия или деятельность, способные причинить или направленные на причинение ущерба репутации компании LNS</h3>
							<p>
								Любые действия или деятельность, способные причинить или направленные на причинение ущерба репутации компании LNS, ее клиентам, или способные нанести ущерб коммерческим интересам компании LNS считаются недобросовестными и влекут за собой отмену права Клиента на совершение покупок.Любое информация противозаконного, мошеннического, угрожающего, оскорбительного, клеветнического, дискредитирующего, вульгарного, порнографического, вредного, назойливого, нечестного характера, либо посягающая на конфиденциальность данных другого клиента, или пропагандирующая ненависть, расовую, этническую и прочую неприязнь, или подлежит соглашению о конфиденциальности, или посягает на нашу интеллектуальную собственность и прочие права, в том числе и третьей стороны Любая внутренняя информация о той или иной компании
							</p>
							<img src="images/about2.jpg" alt="" class="right_back">
							
								Веб-сайт электронной торговли LNS удобен в использовании и предлагает широкий выбор часов швейцарского производства под собственным брендом. К услугам покупателей часов LNS все функции веб-сайта, помогающие сделать верный выбор часов экстра-класса. В этом кроется единственная причина успеха компании LNS, стремящейся к постоянному расширению ассортимента, не требуя ничего взамен.
							</p>
							<p>
								Отдавая безусловный приоритет удовлетворенному покупателю, нежели прибыли, компания LNS предлагает своим клиентам круглосуточную техническую онлайн-поддержку. Любые действия или деятельность, способные причинить или направленные на причинение ущерба репутации компании LNS, ее клиентам, или способные нанести ущерб коммерческим интересам компании LNS считаются недобросовестными и влекут за собой отмену права Клиента
							</p>
							<p>
								Отдавая безусловный приоритет удовлетворенному покупателю, нежели прибыли, компания LNS предлагает своим клиентам круглосуточную техническую онлайн-поддержку. Любые действия или деятельность, способные причинить или направленные на причинение ущерба репутации компании LNS, ее клиентам, или способные нанести ущерб коммерческим интересам компании LNS считаются недобросовестными и влекут за собой отмену права Клиента
							</p>
							<div class="video"><iframe src="https://www.youtube.com/embed/hKLyOeZZx4c" allowfullscreen></iframe></div>
							<h3>LNS считаются недобросовестными и влекут за собой отмену права Клиента</h3>
							<p>
								Любые действия или деятельность, способные причинить или направленные на причинение ущерба репутации компании LNS, ее клиентам, или способные нанести ущерб коммерческим интересам компании LNS считаются недобросовестными и влекут за собой отмену права Клиента на совершение покупок. Любое информация противозаконного, мошеннического, угрожающего, оскорбительного, клеветнического, дискредитирующего, вульгарного, порнографического, вредного, назойливого, нечестного характера, либо посягающая на конфиденциальность данных другого клиента, или пропагандирующая ненависть, расовую, этническую и прочую неприязнь, или подлежит соглашению о конфиденциальности, или посягает на нашу интеллектуальную собственность и прочие права, в том числе и третьей стороны Любая внутренняя информация о той или иной компании
							</p>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}else{
	//
}
?>


