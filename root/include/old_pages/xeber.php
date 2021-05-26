<?php 
if(isset($page) && $page=='xeber'){
	// die($u_id);
	if(isset($u_id) && is_numeric($u_id)){
		$sql = "select * from `site_xeberler` where l_id='".$lng."'  and status='0' and u_id='".$u_id."' limit 1";
	$result = mysqli_fetch_assoc(mysqli_query($connection,$sql)) or die('bele xeber yoxdur');
?>
<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title"><?php echo $result['name'];?></h1>
			</div>
			<div class="middle_content about_page node_news clearfix">
				<div class="about_wrap clearfix">
					<div class="about_sidebar">
						<div class="node_created">10 марта 2017, 19:20</div>
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
						<div class="short_desc clearfix">
							<div class="main_desc"><?php echo $result['description'];?></div>
							<div class="image"><img src="products/<?php echo $result['photo'];?>"></div>
							<div class="description">
								<?php echo $result['text'];?>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php 
	}else{
		die('bele bir xeber tapilmadi');
	}
}else{

	
}
?>