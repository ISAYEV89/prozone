<?php

$data=[];



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

 require $_SERVER['DOCUMENT_ROOT'].'/test/lns/vendor/phpmailer/phpmailer/src/Exception.php';
 require $_SERVER['DOCUMENT_ROOT'].'/test/lns/vendor/phpmailer/phpmailer/src/PHPMailer.php';
 require $_SERVER['DOCUMENT_ROOT'].'/test/lns/vendor/phpmailer/phpmailer/src/SMTP.php';

$name=$_POST['name'];
$surname=$_POST['surname'];
$country=$_POST['country'];
$passport=$_POST['passport'];

$message="name:$name, surname:$surname, country:$country, passport:$passport";
      $mail = new PHPMailer(true);     
       try {
  
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'mail.webcity.az';                        
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'efgan@webcity.az';                     // SMTP username
    $mail->Password   = 'b@843nE*{ToH';                               // SMTP password
    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 465;                                     // TCP port to connect to
   
    //Recipients
    $mail->setFrom('efgan@webcity.az', 'LNS');
    $mail->addAddress('efgan@webcity.az', 'efgan@webcity.az');

    $recipients = array(
        'efqanesc@gmail.com' => 'Person One'
    );
    foreach($recipients as $e => $n)
    {
        $mail->AddCC($e, $n);
    }



    
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject ="LNS SIGN UP";
    $mail->Body    = $message;
    $mail->AltBody = 'alt basliq';
    
    if($mail->send()){
        $data['ok']='success';
    };
    

} catch (Exception $e) {
    
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    


}
echo json_encode($data);