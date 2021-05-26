<?php 
$n=0;

$arr = explode('-',$_GET['cat']);



$page = $arr[1] != '' ? $arr[1] : 1;
$limit = 8;
$offset = ($page - 1) * $limit;
$sql = ' Limit ' . $offset . ',' . $limit;
?>
<div class="middle">

	<div class="container">

		<div class="page_title_wrapper">

			<h1 class="page_title"><?=$home_body['news'][$lng]?></h1>

		</div>

		<div class="middle_content clearfix">

			<div class="page_news">

					<?php
                    
                
                
					$lng01sor=$db->prepare('SELECT * FROM blog_content where s_id is null and l_id=:lid  order by ordering asc'.$sql);

              		$lng01sor->execute(array('lid'=>$lng1)); 

					$lng01count=$lng01sor->rowCount();

					$decods=0;

              		while ($lng01cek=$lng01sor->fetch(PDO::FETCH_ASSOC)) 

                  	{  

              		$decods++;

					?>

						<div class="col col_<?php  echo $decods;	if ($decods%4==0) { $decods=0; }?> " tt='<?php echo ($decods%5).$decods; ?>'>

							<div class="image">
                                <a href="<?php echo $site_url.$lng.'/news/'.$lng01cek['u_id'].'/'; ?>">
                                    <img src="<?php echo $site_url.'cms/images/'.$lng01cek['picture']; ?>" alt="">
                                </a>
                            </div>

							<div class="date"> <?php $dekar=substr($lng01cek['date'], 5,2);  echo substr($lng01cek['date'], 8,2).' '.mounth($dekar,$lng1).' '.substr($lng01cek['date'], 0,4).', '.substr($lng01cek['date'], 11,5); ?></div>

							<div class="title">
                                <a href="<?php echo $site_url.$lng.'/news/'.$lng01cek['u_id'].'/'; ?>">
                                    <?php echo $lng01cek['stitle'] ?>
                                </a>
                            </div>

						</div>



					<?php

              		if ($decods%4==0) 

              		{

              			?>

						<div class="line">------</div>

              			<?php 

              		}

					}  

					?>

                <?php
                    $contractquer=$db->prepare('SELECT * FROM blog_content where s_id is null and l_id=:lid  order by ordering asc');
                    $contractquer->execute(array('lid'=>$lng1));
                    $say=$contractquer->rowCount();
                ?>
				<section class="paginator">

					<ul>

					
                        <?php
                    $pCount = ceil($say/$limit);
                    $p = $page;
                    if ($arr[1]!='') {
                        $p = $arr[1];
                    } else $p = 1;
                    ?>
                    <li class="paginator-prev"><a <?php if($p>1){ echo 'href="'.$site_url.''.$lng.'/news/0-'.intval($p-1).'/"'; } ?> ></a></li>
                    <?php    
                    for ($i = 1; $i <= $pCount; $i++) { 
                            
                         if ($i == $p) { ?>
                            <li class="active"><a style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/news/0-'.$i.'/'; ?>"><?php echo $i; ?></a></li>
                        <?php } else if ($i <= 2) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/news/0-'.$i.'/'; ?>"><?php echo $i.''; ?></a></li>
                        <?php } else if ($pCount - 2 <= $i) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/news/0-'.$i.'/'; ?>"><?php echo $i.''; ?></a></li>
                        <?php } else if (($p - 2) <= $i AND ($p + 2) >= $i) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/news/0-'.$i.'/'; ?>"><?php echo $i.''; ?></a></li>
                        <?php } else if ($i < $p) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/news/0-'.round(($p - 2) / 2).'/';?>"><?php echo '...'; ?></a></li>
                            <?php $i = $p - 2;
                        } else if ($i > $p) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/news/0-'.round(($pCount  + $p) / 2).'/'; ?>"><?php echo '...'; ?></a>
                            </li>
                            <?php $i = $pCount - 2;
                        }  
            
                    }
                    ?>
                        
					<li class="paginator-next"><a <?php if($p!=$pCount){ echo 'href="'.$site_url.''.$lng.'/news/0-'.intval($p+1).'/"'; } ?>></a></li>
						
					</ul>

				</section>
				

			</div>

		</div>

	</div>

</div>