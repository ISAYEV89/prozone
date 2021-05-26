<?php 
    
    $links = $db->prepare('select * from menu');
    $links->execute();
    
    while($menu_link=$links->fetch(PDO::FETCH_ASSOC)){
        if(strlen(strval($menu_link['link']))>0  ){
            $link = strval($menu_link['link']);
            
            $link_extension = substr($link,18);
            //echo  $link_extension.'<br>';
            
            $link = 'http://lnsint.net'.$link_extension;
            
            $update = $db->prepare('update menu set link = ? where id = ?');
            $update->execute([$link,$menu_link['id']]);
            
            echo $link.'<br>';
        }else{
            echo '1<br>';
        }
    }

?>