   <div class="header_container">
													<div class="header_content clearfix">
													<ul class="menu" id="menu">
<?php

				@$sql568=mysqli_QUERY($connection,"select * from `site_menu` where l_id='".$lng."' and tip='1' and s_id='0' and url_tag='".$_GET['val']."' limit 1");
				$b5985=MYSQLI_FETCH_ASSOC($sql568);

				$sql=mysqli_QUERY($connection,"select * from `site_menu` where l_id='".$lng."' and tip='1' and s_id='0' and sub_id='0' order by `ordering`asc");

				while($b=MYSQLI_FETCH_ASSOC($sql)){


					if(!empty($b['link'])){
						$lh=$site_url.$lng2.'/'.$b['link'].'/';
					}
					else{
						$lh=$site_url.$lng2.'/pages/'.$b['url_tag'].'/';
					}
						$sql11=mysqli_QUERY($connection,"select * from `site_menu` where l_id='".$lng."' and tip='1' and s_id='0' and sub_id='".$b['u_id']."' order by `ordering`asc");

						if($def_m_a==0 and $b['u_id']==1){$active='class="active"';}
						else{
							if($b['url_tag']==@$_GET['val']){$active='class="active"';} else{$active='';}
						}
						if(mysqli_num_rows($sql11)>0){


						if($b5985['sub_id']==$b['u_id']){$active='class="active"';} else{$active='';}

							echo '<li '.$active.'><a>'.$b['name'].'</a>';
						}
						else{
					echo'
				                                 
					<li '.$active.'><a href="'.$lh.'">'.$b['name'].'</a>';
						}



				if(mysqli_num_rows($sql11)>0){  }
				else{}

						$sql2=mysqli_QUERY($connection,"select * from `site_menu` where l_id='".$lng."' and tip='1' and s_id='0' and sub_id='".$b['u_id']."' order by `ordering`asc");
						while($b2=MYSQLI_FETCH_ASSOC($sql2)){
						if(!empty($b2['link']))	{
							$lh=$site_url.$lng2.'/'.$b2['link'].'/';
						}
						else{

							$lh=$site_url.$lng2.'/pages/'.$b2['url_tag'].'/';
						}


							echo'<li><a href="'.$lh.'">'.$b2['name'].'</a></li>';


															}
					if(mysqli_num_rows($sql11)>0){ echo'				</ul>
																		</div>
																		</div>'; }
					else{}
				echo'</li>
					
				';}?>
<!-- <div class="header_container">
			<div class="header_content clearfix">
				<ul class="menu" id="menu">
					<li><a href="#">О компании</a></li>
					<li><a href="#">Как это работает?</a></li>
					<li><a href="#">Продукция</a></li>
					<li><a href="#">Возможности</a></li>
					<li><a href="#">Новости</a></li>
					<li><a href="#">Поддержка</a></li>
				</ul>
			</div>
</div> -->