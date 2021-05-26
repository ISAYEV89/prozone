<?php 
try 
{
	$db= new PDO("mysql:host=localhost; dbname=lns; charset=utf8" , 'root' , '541@3@541');
}
catch(Exception $e) 
{
    echo $e->getMessage();
}

function s ($a)
{
	$a = htmlspecialchars($a); 
	$a = trim($a); 
	$a = stripslashes($a); 
    return $a;
}

// echo 'sad';
// print_r($_POST);
if (isset($_POST['ltl']) and $_POST['ltl']=="za") 
{
  // echo 'sad';
  $aassor = $db->prepare("SELECT * FROM olkeler where sub_id=".$_POST['name']." and l_id='1'   ");
  $aassor->execute();
  // echo 'sad'.$asd=$aassor->rowCount();
  while($aacek=$aassor->fetch(PDO::FETCH_ASSOC))
  { ?>
    <option value="<?php echo $aacek['kat_id'] ?>"><?php  echo $aacek['name']; ?></option>
  <?php

    // echo $aacek['name'];
  } 
}
?>