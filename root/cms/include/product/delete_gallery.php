<?php
    
    $id = $_GET['val'];
    
    
    $blogquera=$db->prepare('SELECT * FROM product_gallery where id=?');
	$blogquera->execute([$id]);
    
    $demand = $blogquera->fetch(PDO::FETCH_ASSOC);
    
    $gallery_id =  $demand['product_id'];
    	
	$blogquerd=$db->prepare('DELETE FROM product_gallery where id=?');
	$delcont=$blogquerd->execute([$id]);
	
		
	if (is_file('images/'.$$demand['image'])) 
	{
      	if (unlink('images/'.$demand['image'])) 
      	{
      	    header('Location:'.$site_url.'product/add_gallery/'.$gallery_id.'/');
  	  	    exit();	
      	}
      	
	} else{
	        header('Location:'.$site_url.'product/add_gallery/'.$gallery_id.'/');
  	  	    exit();
	}
				


?>