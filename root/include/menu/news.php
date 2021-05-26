<div class="middle">

	<div class="container">

		<div class="page_title_wrapper">

			<h1 class="page_title">Новости</h1>

		</div>

		<div class="middle_content clearfix">

			<div class="page_news">

					<?php
                    
                
					$lng01sor=$db->prepare('SELECT * FROM blog_content where s_id is null and l_id=:lid  order by ordering asc  ');

              		$lng01sor->execute(array('lid'=>$lng1)); 

					$lng01count=$lng01sor->rowCount();

					$decods=0;

              		while ($lng01cek=$lng01sor->fetch(PDO::FETCH_ASSOC)) 

                  	{  

              		$decods++;

					?>

						<div class="col col_<?php  echo $decods;	if ($decods%4==0) { $decods=0; }?> " tt='<?php echo ($decods%5).$decods; ?>'>

							<div class="image">
<!--                                <a href="--><?php //echo $site_url.$lng.'/news/'.$lng01cek['u_id'].'/'; ?><!--">-->
                                    <img src="<?php echo $site_url.'cms/images/'.$lng01cek['picture']; ?>" alt="">
<!--                                </a>-->
                            </div>

							<div class="date"> <?php $dekar=substr($lng01cek['date'], 5,2);  echo substr($lng01cek['date'], 8,2).' '.mounth($dekar,$lng1).' '.substr($lng01cek['date'], 0,4).', '.substr($lng01cek['date'], 11,5); ?></div>

							<div class="title">
<!--                                <a href="--><?php //echo $site_url.$lng.'/news/'.$lng01cek['u_id'].'/'; ?><!--">-->
                                    <?php echo $lng01cek['stitle'] ?>
<!--                                </a>-->
                            </div>

						</div>



					<?php

              		if ($decods%4==0) 

              		{

              			?>

						<div class="line">Разделяющая черта</div>

              			<?php 

              		}

					}  

					?>

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