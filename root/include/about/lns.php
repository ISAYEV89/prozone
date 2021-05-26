<div class="middle_content about_page clearfix">
	<div class="short_desc clearfix">
		<?php
		$menu_sor12=$db->prepare('SELECT  * FROM pages WHERE l_id="'.$lng1.'"  and page=:uid '); 
		$menu_sor12->execute(array('uid' => s($_GET['cat']) ));
		$menu_cek12=$menu_sor12->fetch(PDO::FETCH_ASSOC); 
		?>
		<div class="main_desc">
			<?php echo $menu_cek12['name']; ?></div>
		<div class="image"><img src="<?php echo $site_url.'cms/images/'.$menu_cek12['dir'] ?>" alt=""></div>
		<div class="description">
		<?php echo $menu_cek12['text']; ?>
		</div>
	</div>
	<div class="about_wrap clearfix">
		<div class="about_sidebar">
			<div class="socials_buttons">
				<div class="social_label">Поделиться:</div>
				<div class="social-likes" data-counters="no">
					<div class="facebook" title="Поделиться ссылкой на Фейсбуке"><span>Facebook</span></div>
					<div class="twitter" title="Поделиться ссылкой в Твиттере"><span>Twitter</span></div>
					<div class="vkontakte" title="Поделиться ссылкой во Вконтакте"><span>Вконтакте</span></div>
					
				</div>
				<!-- AddToAny BEGIN -->
				<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
				<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
				<a class="a2a_button_viber"></a>
				<a class="a2a_button_whatsapp"></a>
				<a class="a2a_button_telegram"></a>
				</div>
				<!--<script async src="https://static.addtoany.com/menu/page.js"></script>-->
                <script async src="<?PHP echo $site_url?>js/addToAny.js"></script>
                <!-- AddToAny END -->
			</div>
		</div>
		<div class="about_main">
			<div class="benefits_wrap">
			<?php
			$menu_sor0=$db->prepare('SELECT  * FROM  xams  WHERE s_id is NULL and type="1" and  l_id="'.$lng1.'" order  by ordering asc '); 
			$menu_sor0->execute();
			while($menu_cek0=$menu_sor0->fetch(PDO::FETCH_ASSOC))
			{  
			?>
				<div class="col">
					<div class="image">
						<div class="field_content"><img src="<?php echo $site_url.'cms/images/'.$menu_cek0['icon']; ?>" alt=""></div>
					</div>
					<div class="title"> <?php echo $menu_cek0['text']; ?></div>
				</div>
			<?php
			}  
			?>
			</div>
			<div class="main_text">
				<?php echo $menu_cek12['text1']; ?>
				<img src="<?php echo $site_url.'cms/images/'.$menu_cek12['dir1'] ?>"  class="right_back">
				<?php echo $menu_cek12['text2']; ?>
				<div class="video"><iframe src="<?php echo $menu_cek12['name1']; ?>" allowfullscreen></iframe></div>
				<?php echo $menu_cek12['text3']; ?>
			</div>
		</div>
	</div>
</div>