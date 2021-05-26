<div class="middle">

	<div class="container">

		<div class="page_title_wrapper">

			<h1 class="page_title">О компании</h1>

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

		if(isset($_GET['cat']) and !isset($_GET['cname']) and $_GET['cat']=='lns')

		{

			$lpage='lns';

		}

		elseif(isset($_GET['cat']) and !isset($_GET['cname']) and $_GET['cat']=='banks')

		{

			$lpage='banks';

		}

		elseif(isset($_GET['cat']) and !isset($_GET['cname']) and $_GET['cat']=='buisness')

		{

			$lpage='buisness';

		}

		elseif(isset($_GET['cat']) and !isset($_GET['cname']) and $_GET['cat']=='managment')

		{

			$lpage='managment';

		}

		include $lpage.'.php';

		?>

	</div>

</div>