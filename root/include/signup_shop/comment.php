<?php
 $path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/inc/confing.php";
include_once($path);    
        
        $comments_number=$db->prepare('select * from comment where product_id = ? order by date desc');
        $comments_number->execute([$_POST['suggest']]);
        $count = $comments_number->rowCount();
        
        $comments=$db->prepare('select * from comment where product_id = ? order by date desc limit '.$_POST['limit']);
        $comments->execute([$_POST['suggest']]);
          
    if($comments->rowCount() > 0){$n=0;    
    ?>
    <?php while($comment = $comments->fetch(PDO::FETCH_ASSOC)){ ?>
	<?php
	
        $comment_user = $db->prepare('select * from user where id = ?');
        $comment_user->execute([$comment['user_id']]);
        $cmmnt_user = $comment_user->fetch(PDO::FETCH_ASSOC);
    ?>
	<div class="review">
        
		<div class="name"><?php echo $cmmnt_user['ad'].' '.$cmmnt_user['soyad']  ?></div>

		<div class="date">
		    <?php $dekar=substr($comment['date'], 5,2);  echo substr($comment['date'], 8,2).' '.mounth($dekar,$lng1).' '.substr($comment['date'], 0,4).', '.substr($comment['date'], 10,6); ?>
		    </div>

		<div class="review_body">

			<?php echo $comment['text'] ?> 

		</div>
    </div>
    <?php  } 
        if($count > $_POST['limit']){
    ?>
	
	<div class="more_reviews">Загрузить еще</div>
    <?php
        } 
    } ?>
 