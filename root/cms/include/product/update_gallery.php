<?php

$blogquera=$db->prepare('SELECT * FROM product_gallery where id=?');
	$blogquera->execute([$_POST['id']]);
    
    $demand = $blogquera->fetch(PDO::FETCH_ASSOC);
    
    $gallery_id =  $demand['product_id'];
    
    echo $gallery_id;
    
    $blogquerd=$db->prepare('update product_gallery set ordering = ? where id=?');
	$updatecont=$blogquerd->execute([$_POST['order'],$_POST['id']]);
	
	header('Location:'.$site_url.'product/add_gallery/'.$gallery_id.'/');
    exit();
	


?>