 <?php 
if(isset($u_id) && $u_id!=""){
	$sql = "select * from `site_menu` where l_id='".$lng."'  and status='0' and u_id='".$u_id."' limit 1";
	// die($sql);
	$result = mysqli_fetch_assoc(mysqli_query($connection,$sql)) or die('bele menu yoxdur');

 ?> 
<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title"><a href="<?PHP echo $site_url.$lng2; ?>/support_email/">Поддержка</a></h1>
			</div>
				<div class="about_menu">
				<div class="block_content">
					<ul class="menu">
		                <?php
		                	if($result["sub_id"]==0){
		                		$sub=mysqli_QUERY($connection,'SELECT * from `site_menu` where l_id="'.$lng.'" and sub_id=8 ORDER BY ordering desc');
		                	}else{
		                		$sub=mysqli_QUERY($connection,'SELECT * from `site_menu` where l_id="'.$lng.'" and sub_id="'.$result["sub_id"].'" ORDER BY ordering desc');
		                	}

							while($sub_menu=MYSQLI_FETCH_ARRAY($sub))
							{		
 						?>

						<li><a href="<?PHP echo $site_url.$lng2; ?>/support_email/<?PHP echo $sub_menu['url_tag'] ; ?>/"><?php echo $sub_menu['name'];?></a></li>

						<?php }?>
					</ul>
				</div>
			</div>
			<div class="middle_content support_email clearfix">
				<div class="image_wrap">
					<div class="image"><img src="<?php echo $site_url;?>products/<?php echo $result['photo'];?>"></div>
					<div class="text">
						<!-- <p>
							Любые действия или деятельность, способные причинить или направленные на причинение ущерба репутации компании LNS
						</p> -->
						<p>
							<?=$result["text"]?>
						</p>
					</div>
				</div>
				<div class="text_wrap">
				<!-- 	<p>Веб-сайт электронной торговли LNS удобен в использовании и предлагает широкий выбор часов швейцарского производства под собственным брендом. К услугам покупателей часов LNS все функции веб-сайта, помогающие сделать верный выбор часов экстра-класса. В этом кроется единственная причина успеха компании LNS, стремящейся к постоянному расширению ассортимента, не требуя ничего взамен.</p>

					<p>Отдавая безусловный приоритет удовлетворенному покупателю, нежели прибыли, компания LNS предлагает своим клиентам круглосуточную техническую онлайн-поддержку. Любые действия или деятельность, способные причинить или направленные на причинение ущерба репутации компании LNS, ее клиентам, или способные нанести ущерб коммерческим. интересам компании LNS считаются недобросовестными и влекут за собой отмену права Клиента</p> -->
					<div class="block_feedback_support">
						<div class="block_container clearfix">
							<div class="block_sidebar">
								<div class="block_title">Остались вопросы?</div>
								<div class="subtitle">Напишите нам и мы радостью ответим.</div>
							</div>
							<div class="block_form">
								<form action="" method="post">
									<div class="group_item clearfix">
										<div class="form_item"><input type="text" class="form_text" placeholder="Имя" name="full_name"></div>
										<div class="form_item"><input type="text" class="form_text" placeholder="Телефон" name="phone"></div>
										<div class="form_item"><input type="text" class="form_text" placeholder="E-mail" name="email"></div>
									</div>
									<div class="form_item"><textarea placeholder="Текст сообщения"></textarea name="message"></div>
									<div class="form_actions"><input type="submit" class="form_submit" value="Send" name="send"></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<?php
if (isset($_POST['send']) && $_POST['send']!=""){

	$db = new PDO('mysql:host=localhost;dbname=lns;charset=utf8', 'root', '');

	$full_name=htmlspecialchars($_POST['full_name']);

	$phone=htmlspecialchars($_POST['phone']);

	$email=htmlspecialchars($_POST['email']);

	$message=htmlspecialchars($_POST['message']);

	if ($full_name == ''  || $email == '' || $phone == '' || $message == ''){
		echo '<script>alert("Bütün bölmələr doldurulmayıb!!!")</script>';
    	echo ('<meta http-equiv="refresh" content="1; url=index.php">');
		exit();
	}

	try{
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	        $contact = $db->prepare("INSERT INTO `contact_mails` SET  full_name=:full_name, email=:email,phone=:phone,message=:message ");
	        $contact->bindParam(":full_name",$full_name,PDO::PARAM_STR);
	        $contact->bindParam(":email",$email,PDO::PARAM_STR);
	        $contact->bindParam(":phone",$phone,PDO::PARAM_STR);
	        $contact->bindParam(":message",$message,PDO::PARAM_STR);
	        $contact->execute(); 
	       mail("leylagarayeva1@gmail.com", $message,$full_name,$phone,$email);
	        echo '<script>alert("Mesajınız göndərildi, təşəkkür edirik!!!")</script>';
           header("Refresh:0; url=index.php");
        }else{
        	echo '<script>alert("Emaili Duzgun daxil edin!!")</script>';
        	echo ('<meta http-equiv="refresh" content="1; url=contact.php">');
			exit();
        }
}
	catch(PDOException $a){
		echo '<script>alert("Mesajınız göndərilmədi, yenidən cəhd edin")</script>';
		echo ('<meta http-equiv="refresh" content="1; url=contact.php">');
		exit();
	}

}else{ 
	// echo "Xəta var";
}


}else{
	//
}

?>