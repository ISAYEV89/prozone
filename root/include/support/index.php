<div class="middle">
	<div class="container">
		<div class="page_title_wrapper">
			<h1 class="page_title">Поддержка <?php echo 1 ?> </h1>
		</div>
		<div class="about_menu">
			<div class="block_content">
				<ul class="menu">
					<?php
					$menu_sor1=$db->prepare('SELECT  tk.url_tag , tk.name , tk.link FROM menu mk , menu tk WHERE mk.s_id is NULL and mk.l_id="'.$lng1.'" and tk.l_id="'.$lng1.'" and mk.type="1" and mk.url_tag=:uid and tk.sub_id=mk.u_id'); 
					$menu_sor1->execute(array('uid' => s($_GET['state']) ));
					while($menu_cek1=$menu_sor1->fetch(PDO::FETCH_ASSOC))
					{
					?>	
						<li><a class="<?php if($_GET['cat']==$menu_cek1['url_tag']){ echo 'active';} ?>" href="<?php echo $menu_cek1['link']; ?>"><?php echo $menu_cek1['name']; ?></a></li>
					<?php 
					}  
					?>
				</ul>
			</div>
		</div>
		<?php 
		//echo  $_GET['cat'].'-----------'; 
		if(isset($_GET['cat']) and !isset($_GET['cname']) and $_GET['cat']=='faq')
		{   
			$lpage='faq';                     
		}  
		elseif(isset($_GET['cat']) and !isset($_GET['cname']) and $_GET['cat']=='email')
		{   
			$lpage='email';                    
		}     
		elseif(isset($_GET['cat']) and !isset($_GET['cname']) and $_GET['cat']=='contacts')
		{   
			$lpage='contacts';                     
		} 
		include $lpage.'.php';
		?>
	</div>
</div>