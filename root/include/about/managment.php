<div class="middle_content about_page clearfix">
	<div class="about_wrap clearfix">
		<div class="about_sidebar">

			<?php
			$lnsor=$db->prepare('SELECT * FROM menu where l_id=:lid  and url_tag=:ut  ');
			$lnsor->execute(array('lid'=>$lng1 , 'ut'=>$_GET['cat']));
			$lncount=$lnsor->rowCount();
			$decods=0;
			$lncek=$lnsor->fetch(PDO::FETCH_ASSOC);
			echo $lncek['text'];
			?>

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
				<!--<script async src="https://static.addtoany.com/menu/page.js"></script>-->
                <script async src="<?PHP echo $site_url?>js/addToAny.js"></script>
				<!-- AddToAny END -->
			</div>
		</div>
		<div class="about_main manager">
			<div class="block_content">
			<?php
			$lng01sor=$db->prepare('SELECT * FROM worker where l_id=:lid  order by ordering asc  ');
			$lng01sor->execute(array('lid'=>$lng1));
			$lng01count=$lng01sor->rowCount();
			$decods=0;
			while ($lng01cek=$lng01sor->fetch(PDO::FETCH_ASSOC))
			{
			$decods++;
			?>
				<div class="col">
					<div class="image"><img src="<?php echo $site_url.'cms/images/'.$lng01cek['picture']; ?>" alt="<?php echo $lng01cek['full_name']; ?>"></div>
					<div class="name"><?php echo $lng01cek['full_name']; ?></div>
					<div class="post"><?php echo $lng01cek['vezife']; ?></div>
					<div class="name"><?php echo $lng01cek['text']; ?></div>
				</div>
			<?php
			}
			?>
			</div>
		</div>
	</div>
</div>