<div class="middle_content about_page clearfix">
	<div class="short_desc clearfix">		
		<?php
		$menu_sor12=$db->prepare('SELECT  * FROM pages WHERE l_id="'.$lng1.'"  and page=:uid '); 
		$menu_sor12->execute(array('uid' => s($_GET['cat']) ));
		$menu_cek12=$menu_sor12->fetch(PDO::FETCH_ASSOC); 
		?>
		<div class="main_desc">
		<?php echo $menu_cek12['name']; ?></div>
		<div class="image"><img src="<?php echo $site_url.'cms/images/'.$menu_cek12['dir'] ?>" alt="О LNS"></div>
		<div class="description">
		<?php echo $menu_cek12['text']; ?>
		</div>
	</div>
	<div class="about_wrap clearfix">
		<div class="register_form">
			<div class="block_title">Заполните поля для регистрации</div>
			<form action="#">
				<div class="form_item">
					<label for="">Электронный адрес:</label>
					<input type="email" class="form_text">
				</div>
				<div class="form_item">
					<label for="">Имя:</label>
					<input type="text" class="form_text">
				</div>
				<div class="form_item">
					<label for="">Номер телефона:</label>
					<input type="text" class="form_text">
				</div>
				<div class="form_item">
					<label for="">Пароль:</label>
					<input type="password" class="form_text">
				</div>
				<div class="form_item">
					<label for="">Повторить пароль:</label>
					<input type="password" class="form_text">
				</div>
				<div class="form_item form_checkbox">
					<input type="checkbox" name="rules" id="rules">
					<label for="rules">Я согласен с <a href="#" target="_blank">правилами сайта</a></label>
				</div>
				<div class="form_actions"><input type="submit" class="form_submit" value="Зарегистрироваться"></div>
			</form>
		</div>
	</div>
</div>