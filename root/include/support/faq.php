<div class="middle_content clearfix">
	<div class="block_faq">
		<?php
		$lng01sor=$db->prepare('SELECT * FROM  faq where  l_id=:lid order by ordering asc   ');
		$lng01sor->execute(array('lid'=>$lng1)); 
		$lng01count=$lng01sor->rowCount();
		$dkd=0;
		while ($lng01cek=$lng01sor->fetch(PDO::FETCH_ASSOC)) 
		{  
		$dkd++;
		?>
		<div class="col <?php if($dkd==1){ echo 'active'; } ?>">
			<div class="title"><?php echo $lng01cek['sual']; ?></div>
			<div class="description"><?php echo $lng01cek['cavab']; ?></div>
		</div>				
		<?php
		}  
		?>
	</div>
</div>