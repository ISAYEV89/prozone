<div class="middle_content support_email clearfix">
	<div class="image_wrap">
		<?php
		$menu_sor12=$db->prepare('SELECT  * FROM pages WHERE l_id="'.$lng1.'"  and page=:uid '); 
		$menu_sor12->execute(array('uid' => s($_GET['cat']) ));
		$menu_cek12=$menu_sor12->fetch(PDO::FETCH_ASSOC); 
		?>
		<div class="image"><img src="<?php echo $site_url.'cms/images/'.$menu_cek12['dir'] ?>" alt=""></div>
		<div class="text">
			<?php echo $menu_cek12['text']; ?>
		</div>
	</div>
	<div class="text_wrap">
			<?php echo $menu_cek12['text1']; ?>
		<div class="block_feedback_support">
			<div class="block_container clearfix">
				<div class="block_sidebar">
					<div class="block_title">Остались вопросы?</div>
					<div class="subtitle">Напишите нам и мы радостью ответим.</div>
				</div>
				<div class="block_form">
					<form action="#">
						<div class="group_item clearfix">
							<div class="form_item"><input type="text" class="form_text" placeholder="Имя"></div>
							<div class="form_item"><input type="text" class="form_text" placeholder="Телефон"></div>
							<div class="form_item"><input type="text" class="form_text" placeholder="E-mail"></div>
						</div>
						<div class="form_item"><textarea placeholder="Текст сообщения"></textarea></div>
						<div class="form_actions"><input type="submit" class="form_submit" value="Отправить"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>