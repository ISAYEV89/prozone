


<!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->


<div class="middle">

	<div class="container">

		<div class="page_title_wrapper">

			<h1 class="page_title">News </h1>

		</div>
        
		<div class="middle_content about_page node_news clearfix">

			<div class="about_wrap clearfix">

				<div class="about_sidebar">

					<?php
				

					$lng01sor=$db->prepare('SELECT * FROM blog_content where s_id is null and l_id=:lid and u_id=:uid  ');

              		$lng01sor->execute(array('lid'=>$lng1 , 'uid'=>s($_GET['cat'])));

					$lng01count=$lng01sor->rowCount();

					$lng01cek=$lng01sor->fetch(PDO::FETCH_ASSOC);

					$decods=0;

				 	?>

					
				
				</div>

				<div class="about_main">

					<div class="short_desc clearfix">

						<div class="main_desc"><?php echo $lng01cek['name']; ?></div>
						
						<div class="node_created"><?php $dekar=substr($lng01cek['date'], 5,2);  echo substr($lng01cek['date'], 8,2).' '.mounth($dekar,$lng1).' '.substr($lng01cek['date'], 0,4).', '.substr($lng01cek['date'], 10,6); ?></div>






			             <div class="image"><img src="<?php echo $site_url.'cms/images/'.$lng01cek['photo1']; ?>" alt="<?php echo $lng01cek['name']; ?>" style="float: left;margin-right: 30px;margin-bottom:30px;"></div> 
			
						<div class="description">
               
					    	<?php echo $lng01cek['text']; ?>

						</div>

					</div>

					<div class="main_text">

						<h3>

							<?php echo $lng01cek['name2']; ?></h3>



							<?php echo $lng01cek['text1']; ?>
                        
                        <?php if($lng01cek['photo2'] !=null && $lng01cek['photo2']!=''){ ?>
						    <img src="<?php echo $site_url.'cms/images/'.$lng01cek['photo2']; ?>" alt="<?php echo $lng01cek['name']; ?>" class="right_back">
                        <?php } ?>

            
							<?php echo $lng01cek['text2']; ?>
                            <!--start slider -->
    <?php
        $query = $db->prepare('select * from blog_content_gallery where blog_id = ? order by ordering ASC');
        $query->execute([$lng01cek['u_id']]);
    ?>

  <div class="demo-gallery" <?php if($query->rowCount()==0){ echo 'style="display:none"'; } ?>>
    <ul id="lightgallery">
      <?php
            $n=1;
        while($image = $query->fetch(PDO::FETCH_ASSOC)){    
        ?>
      <li data-src="<?php echo $site_url.'cms/images/'.$image['image']; ?>">
        <a href="" >
          <img class="img-responsive" src="<?php echo $site_url.'cms/images/'.$image['image']; ?>" >
          <div class="demo-gallery-poster">
                <img src="<?php echo $site_url.'images/icon/zoom.png' ?>">

          </div>
          
        </a>
      </li>
      <?php } ?>
    </ul>
   
  </div>

<!-- end slider -->
<?php if($lng01cek['youtube_link']!=null && $lng01cek['youtube_link']!=''){ ?>
    <?php echo $lng01cek['youtube_link'] ?>
<?php } ?>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>



<style>



.lightgallery a img {
  width: 300px;
} 

.small {
  font-size: 11px;
  color: #999;
  display: block;
  margin-top: -10px
}

.cont {
  text-align: center;
}

.page-head {
  padding: 60px 0;
  text-align: center;
}

.page-head .lead {
  font-size: 18px;
  font-weight: 400;
  line-height: 1.4;
  margin-bottom: 50px;
  margin-top: 0;
}

.btn {
  -moz-user-select: none;
  background-image: none;
  border: 1px solid transparent;
  border-radius: 2px;
  cursor: pointer;
  display: inline-block;
  font-size: 14px;
  font-weight: normal;
  line-height: 1.42857;
  margin-bottom: 0;
  padding: 6px 12px;
  text-align: center;
  vertical-align: middle;
  white-space: nowrap;
  text-decoration: none;
}

.btn-lg {
  border-radius: 2px;
  font-size: 18px;
  line-height: 1.33333;
  padding: 10px 16px;
}

.btn-primary:hover {
  background-color: #fff;
  color: #152836;
}

.btn-primary {
  background-color: #152836;
  border-color: #0e1a24;
  color: #ffffff;
}

.btn-primary {
  border-color: #eeeeee;
  color: #eeeeee;
  transition: color 0.1s ease 0s, background-color 0.15s ease 0s;
}

.page-head h1 {
  font-size: 42px;
  margin: 0 0 20px;
  color: #FFF;
  position: relative;
  display: inline-block;
}


.page-head h1 .version {
  bottom: 0;
  color: #ddd;
  font-size: 11px;
  font-style: italic;
  position: absolute;
  width: 58px;
  right: -58px;
}

.demo-gallery{
    height:200px;
    margin-top:50px;
    overflow:hidden;
}
.demo-gallery > ul {
  margin-bottom: 0;
  padding-left: 15px;
}

.demo-gallery > ul > li {
  margin-bottom: 15px;
  width: 270px;
  display: inline-block;
  margin-right: 15px;
  list-style: outside none none;
}

.demo-gallery > ul > li a {
  border: 3px solid #FFF;
  border-radius: 3px;
  display: block;
  overflow: hidden;
  position: relative;
  float: left;
}

.demo-gallery > ul > li a > img {
  -webkit-transition: -webkit-transform 0.15s ease 0s;
  -moz-transition: -moz-transform 0.15s ease 0s;
  -o-transition: -o-transform 0.15s ease 0s;
  transition: transform 0.15s ease 0s;
  -webkit-transform: scale3d(1, 1, 1);
  transform: scale3d(1, 1, 1);
  height: 100%;
  width: 100%;
}

.demo-gallery > ul > li a:hover > img {
  -webkit-transform: scale3d(1.1, 1.1, 1.1);
  transform: scale3d(1.1, 1.1, 1.1);
}

.demo-gallery > ul > li a:hover .demo-gallery-poster > img {
  opacity: 1;
}

.demo-gallery > ul > li a .demo-gallery-poster {
  background-color: rgba(0, 0, 0, 0.1);
  bottom: 0;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  -webkit-transition: background-color 0.15s ease 0s;
  -o-transition: background-color 0.15s ease 0s;
  transition: background-color 0.15s ease 0s;
}

.demo-gallery > ul > li a .demo-gallery-poster > img {
  left: 50%;
  margin-left: -10px;
  margin-top: -10px;
  opacity: 0;
  position: absolute;
  top: 50%;
  -webkit-transition: opacity 0.3s ease 0s;
  -o-transition: opacity 0.3s ease 0s;
  transition: opacity 0.3s ease 0s;
}

.demo-gallery > ul > li a:hover .demo-gallery-poster {
  background-color: rgba(0, 0, 0, 0.5);
}

.demo-gallery .justified-gallery > a > img {
  -webkit-transition: -webkit-transform 0.15s ease 0s;
  -moz-transition: -moz-transform 0.15s ease 0s;
  -o-transition: -o-transform 0.15s ease 0s;
  transition: transform 0.15s ease 0s;
  -webkit-transform: scale3d(1, 1, 1);
  transform: scale3d(1, 1, 1);
  height: 100%;
  width: 100%;
}

.demo-gallery .justified-gallery > a:hover > img {
  -webkit-transform: scale3d(1.1, 1.1, 1.1);
  transform: scale3d(1.1, 1.1, 1.1);
}

.demo-gallery .justified-gallery > a:hover .demo-gallery-poster > img {
  opacity: 1;
}

.demo-gallery .justified-gallery > a .demo-gallery-poster {
  background-color: rgba(0, 0, 0, 0.1);
  bottom: 0;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  -webkit-transition: background-color 0.15s ease 0s;
  -o-transition: background-color 0.15s ease 0s;
  transition: background-color 0.15s ease 0s;
}

.demo-gallery .justified-gallery > a .demo-gallery-poster > img {
  left: 50%;
  margin-left: -10px;
  margin-top: -10px;
  opacity: 0;
  position: absolute;
  top: 50%;
  -webkit-transition: opacity 0.3s ease 0s;
  -o-transition: opacity 0.3s ease 0s;
  transition: opacity 0.3s ease 0s;
}

.demo-gallery .justified-gallery > a:hover .demo-gallery-poster {
  background-color: rgba(0, 0, 0, 0.5);
}

.demo-gallery .video .demo-gallery-poster img {
  height: 48px;
  margin-left: -24px;
  margin-top: -24px;
  opacity: 0.8;
  width: 48px;
}

.demo-gallery.dark > ul > li a {
  border: 3px solid #04070a;
}


</style>

