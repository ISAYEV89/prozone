<?php 

if(isset($_POST['dbtn'])){
   
   $query = $db->prepare('delete from stock where product_id = ?');
   $query->execute([$_POST['delete_id']]);
   
   header('Location:'.$site_url.'product/stock/');
}

?>