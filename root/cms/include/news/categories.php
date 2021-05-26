<main class="site-main">
	<div class="header-bg"></div>
	<?php 
	$contq=$db->prepare('SELECT * from menu where l_id=:lis and url_tag=:ut ');
	$contq->execute(array('lis'=>$lng1 , 'ut'=>'news' ));
	$contf=$contq->fetch(PDO::FETCH_ASSOC);
	?>
	<h1 class="page-heading"><?php echo $contf['name']; ?></h1>
	<div class="news-grid">
		<div class="news-grid-wrapper middle-container">
            <?php 
            $xamseq=$db->prepare('SELECT * FROM blog_content where l_id=? and s_id is NULL order by ordering asc ');
            $xamseq->execute([$lng1]);
            while($xamsef=$xamseq->fetch(PDO::FETCH_ASSOC))
            {
            ?>  
			<div class="news-card">
				<a class="news-card__img" href="<?php echo $site_url.$lng.'/news/'.$xamsef['url_tag'].'/' ?>">
					<img  src="<?php echo $site_url.'cms/images/'.$xamsef['picture']; ?>" srcset="<?php echo $site_url.'cms/images/'.$xamsef['picture']; ?> 1x, <?php echo $site_url.'cms/images/'.$xamsef['picture']; ?> 2x" width="290" height="250">
				</a>
				<div class="news-card__text">
					<a class="news-card__heading" href="<?php echo $site_url.$lng.'/news/'.$xamsef['url_tag'].'/' ?>">
						<span class="news-card__heading-text"><?php echo $xamsef['name'] ?></span>
					</a>
					<span class="news-card__excerpt">
                            <?php echo $xamsef['stitle'] ?>                            	
                    </span>
					<div class="news-card__bottom">
						<span class="news-card__date">
							<i></i>
							<b><?php echo $xamsef['date'] ?></b>
						</span>
						<a class="news-card__link arrow-right-link" href="<?php echo $site_url.$lng.'/news/'.$xamsef['url_tag'].'/' ?>">
							<span>детальніше</span>
							<svg xmlns="http://www.w3.org/2000/svg" width="15" height="26" viewBox="0 0 15 26">
								<path fill="#fff" d="M14.46 14.29L3.15 25.47a1.87 1.87 0 0 1-2.61 0 1.81 1.81 0 0 1 0-2.58l10-9.89-10-9.89a1.81 1.81 0 0 1 0-2.58 1.87 1.87 0 0 1 2.61 0l11.31 11.18a1.81 1.81 0 0 1 0 2.58z"></path>
							</svg>
						</a>
					</div>
				</div>
			</div>
            <?php 
            }
            ?>		
		</div>
	</div>