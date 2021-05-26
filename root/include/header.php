<!doctype html>
<html lang="<?php echo $lng; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="preload" as="font" href="<?php echo $site_url; ?>assets/fonts/Montserrat-Bold/Montserrat-Bold.woff2" type="font/woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="<?php echo $site_url; ?>assets/fonts/Montserrat-Regular/Montserrat-Regular.woff2" type="font/woff2" crossorigin="anonymous">
     <?php
    $site_general = $db->prepare('select * from site_general where l_id = ?');
    $site_general->execute([$lng1]);
    $general = $site_general->fetch(PDO::FETCH_ASSOC);

    if (isset($_GET['cat'])) {

        if (isset($_GET['cname'])) {

            $url_tag = s($_GET['cname']);

        } else if (isset($_GET['cat'])) {

            $url_tag = s($_GET['cat']);

        }

        $h = $db->query("select *from menu where url_tag='" . $url_tag . "' and l_id='" . $lng1 . "'")->fetch(PDO::FETCH_ASSOC);

    } else {



    }

    if (@$h) {

        echo '<title>' . $h['title'] . '</title>';

        echo '<meta name="description" CONTENT="' . $h['description'] . '">';

        echo '<meta name="keywords" CONTENT="' . $h['keyword'] . '">';

    } elseif (@$tdkc) {

        echo '<title>' . $tdkc['title'] . ' </title>';

    } else {

        $tdk = $db->prepare('SELECT * from site_general where  l_id="' . s($lng1) . '"');

        $tdk->execute();

        $tdkc = $tdk->fetch(PDO::FETCH_ASSOC);

        echo '<title>' . $tdkc['title'] . ' </title>';
    }

    ?>
<link href="<?php echo $site_url; ?>/assets/css/app.css" rel="stylesheet"></head>
<body>


<header class="header">
    <section class="navigation">
        <div class="nav-container">
            <div class="brand">
                <a class="nav__logo" href="index.html">
                    <img src="./assets/image/logo/logo.png" alt="logo">
               </a>
            </div>
            <nav>
                <div class="nav-mobile"><a id="nav-toggle" href="#!"><span></span></a></div>
                <ul class="nav-list"> 
					<?php

                        $menu_sor = $db->prepare('SELECT * FROM menu WHERE s_id is NULL and l_id="' . $lng1 . '" and type="1" and sub_id="0" ');

                        $menu_sor->execute();

                        while ($menu_cek = $menu_sor->fetch(PDO::FETCH_ASSOC))
						{
							$menu_sor2 = $db->prepare('SELECT * FROM menu WHERE s_id is NULL and l_id="' . $lng1 . '" and type="1" and sub_id="'.$menu_cek['u_id'].'" ');
							$menu_sor2 ->execute();
							$num_rows = $menu_sor2->fetchColumn();
							if($num_rows!=0)					{	$mlnk= '#';				}
							else if ($menu_cek['link'] != '')	{	$mlnk= $menu_cek['link'];	} 
							else 								{   $mlnk= $site_url.$lng.'/menu/'.$menu_cek['url_tag'].'/';  } 
                            echo'
                            <li>
                                <a href="'.$mlnk.'">'.$menu_cek['name'].'</a>';
							if($num_rows!=0)
							{
								echo '<ul class="nav-dropdown">';
								while($menu_cek2 = $menu_sor2->fetch(PDO::FETCH_ASSOC))
								{
									if ($menu_cek2['link'] != '')	{	$mlnk2= $menu_cek2['link'];	} 
									else 							{   $mlnk2= $site_url.$lng.'/menu/'.$menu_cek2['url_tag'].'/';  } 
									echo'
									<li>
										<a href="'.$mlnk2.'">'.$menu_cek2['name'].'</a>
									</li>';
								}
								echo'</ul>';
							}
							echo '</li>';

                        }

                     ?>
                </ul>
            </nav>
        </div>
    </section>
</header>