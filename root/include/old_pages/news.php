<div class="middle">
		<div class="container">
			<div class="page_title_wrapper">
				<h1 class="page_title">Новости</h1>
			</div>
			<div class="middle_content clearfix">
				<div class="page_news">
					<?php
					$xeberler22=mysqli_QUERY($connection,'SELECT * from `site_xeberler` where l_id="'.$lng.'" and status=0 ORDER BY ordering');
					while($xeberler=MYSQLI_FETCH_ARRAY($xeberler22))
					{	
			    	 ?>
					<div class="col col_1">
						<div class="image"><a href="<?PHP echo $site_url.$lng2; ?>/xeber/<?PHP echo $xeberler['url_tag'] ; ?>/"><img src="<?php echo $site_url;?>products/<?php echo $xeberler['photo'];?>" alt=""></a></div>
						<div class="date"><?php echo $xeberler['current_date'];?></div>
						<div class="title"><a href="<?PHP echo $site_url.$lng2; ?>/xeber/<?PHP echo $xeberler['url_tag'] ; ?>/"><?php echo $xeberler['description'];?></a></div>
					</div>
					<?php }?>
					<section class="paginator">
						<ul>
						<li class="paginator-prev"><a href="#"></a></li>
							<li><a href="#">1</a></li>
							<li class="active"><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li class="paginator-next"><a href="#"></a></li>
						</ul>
					</section>
				</div>
			</div>
		</div>
	</div>