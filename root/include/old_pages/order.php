<?php 
	
 ?>
<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title">Оформить заказ</h1>
			</div>
			<div class="middle_content">
				<div class="order_form">
					<div class="block_title">Заполните поля для заказа товаров:</div>
					<form action="#">
						<div class="form_item">
							<label for="">Имя:</label>
							<input type="email" class="form_text">
						</div>
						<div class="form_item">
							<label for="">Фамилия:</label>
							<input type="email" class="form_text">
						</div>
						<div class="form_item">
							<label for="">Электронный адрес:</label>
							<input type="email" class="form_text">
						</div>
						<div class="form_item">
							<label for="">Телефон:</label>
							<input type="email" class="form_text">
						</div>
						
						<div class="form_item">
							<label for="">Страна:</label>
							<select name="olke_id" id="olke_id">
								<option value="" selected="" disabled=""> -- Select country -- </option>
								  <?PHP 
                            $valyuta1 = mysqli_query($connection,'SELECT * FROM olkeler WHERE l_id=1 and sub_id=0 ');
							while ($valyuta2 = mysqli_fetch_assoc($valyuta1)) {
                                echo '<option value="'.$valyuta2['kat_id'].'">'.$valyuta2['name'].'</option>';
                            }	
	                       ?>
							</select>
						</div>
						<div class="form_item">
							<label for="">Город:</label>
							<select name="sheher_id" id="sheher_id">
							</select>
						</div>
						<div class="form_item">
							<label for="">Способ оплаты:</label>
							<select>
								<option value="Россия">Онлайн</option>
								<option value="Белоруссия">Наличными</option>
							</select>
						</div>
						<div class="form_item">
							<label for="">Способ доставки:</label>
							<select>
								<option value="Россия">Курьером</option>
								<option value="Белоруссия">Самовывоз</option>
							</select>
						</div>
						<div class="form_item form_textarea">
							<label for="">Добавить примечание</label>
							<textarea></textarea>
						</div>
						<div class="form_actions">
							<input type="submit" class="form_submit" value="Заказать товар">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
	$("#olke_id").change(function() {
		var olke_id = $(this).val();
		if(olke_id != "") {
			$.ajax({
				url:"<?=$site_url.'get_city.php?lng='.$lng2;?>",
				data:{o_id:olke_id},
				type:'POST',
				success:function(response) {
					var resp = $.trim(response);
					$("#sheher_id").html(resp);
				}
			});
		} else {
			$("#sheher_id").html("<option value=''>------- Select --------</option>");
		}
	});
});

</script>