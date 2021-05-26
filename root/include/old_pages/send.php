	<form action="" method="post">
								<div class="group_item clearfix">
									<div class="form_item"><input type="text" class="form_text" placeholder="Имя" name="full_name"></div>
									<div class="form_item"><input type="text" class="form_text" placeholder="Телефон" name="phone"></div>
									<div class="form_item"><input type="text" class="form_text" placeholder="E-mail" name="email"></div>
								</div>
							     <div class="form_item"><textarea placeholder="Текст сообщения" name="message"></textarea></div>
								<div class="form_actions"><input type="submit" class="form_submit" value="Send" name="send"></div>
	</form>




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


?>