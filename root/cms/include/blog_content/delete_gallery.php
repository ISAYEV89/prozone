<?php
    
    $id = $_GET['val'];
    
    
    $blogquera=$db->prepare('SELECT * FROM blog_content_gallery where id=?');
	$blogquera->execute([$id]);
    
    $demand = $blogquera->fetch(PDO::FETCH_ASSOC);
    
    $gallery_id =  $demand['blog_id'];
    	
	$blogquerd=$db->prepare('DELETE FROM blog_content_gallery where id=?');
	$delcont=$blogquerd->execute([$id]);
	
		
	if (is_file('images/'.$$demand['image'])) 
	{
      	if (unlink('images/'.$demand['image'])) 
      	{
      	    header('Location:'.$site_url.'blog_content/add_gallery/'.$gallery_id.'/');
  	  	    exit();	
      	}
      	
	} else{
	        header('Location:'.$site_url.'blog_content/add_gallery/'.$gallery_id.'/');
  	  	    exit();
	}
				


?>