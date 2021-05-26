<?php

$blogquera=$db->prepare('SELECT * FROM blog_content_gallery where id=?');
	$blogquera->execute([$_POST['id']]);
    
    $demand = $blogquera->fetch(PDO::FETCH_ASSOC);
    
    $gallery_id =  $demand['blog_id'];
    
    echo $gallery_id;
    
    $blogquerd=$db->prepare('update blog_content_gallery set ordering = ? where id=?');
	$updatecont=$blogquerd->execute([$_POST['order'],$_POST['id']]);
	
	header('Location:'.$site_url.'blog_content/add_gallery/'.$gallery_id.'/');
    exit();
	


?>