<!--script defer src="<?php echo $site_url; ?>user/js/all.js" ></script>
<script type="text/javascript">
      // Notice how this gets configured before we load Font Awesome
      window.FontAwesomeConfig = { autoReplaceSvg: true }
    </script -->

<?php
if (isset($_GET['child'])) {
    $tag = s($_GET['child']);

    $aa = true;
} else if (isset($_GET['cname'])) {

    $tag = s($_GET['cname']);

    $aa = true;

} else {

    $tag = s($_GET['cat']);

}
$sql = "select *from menu where l_id='" . $lng1 . "' AND url_tag='" . $tag . "' and s_id is NULL";

$content = $db->query($sql)->fetch(PDO::FETCH_ASSOC);

?>
<div class="middle">

    <div <?php if ($content['url_tag'] == 'opportunity') {
        echo 'class="container-fluid" style="padding-left:0;padding-right:0;"';
    } else {
        echo 'class="container"';
    } ?> >

        <div class="page_title_wrapper">

            <h1 class="page_title">

                <?php

                $url = s($_GET['cat']);

                $lang = s($_GET['lng']);

                $menu = $db->query("select * from menu where url_tag='" . $url . "' AND l_id='" . $lng1 . "' and s_id is NULL")->fetch(PDO::FETCH_ASSOC);

                echo $menu['name'];

                ?></h1>

        </div>
        <style>/*
			 svg path{
 color:white;
}
			 .dropdown:hover svg path{
 color:#43b9da;
}
			 .dropdown:hover div{
 background-color:white;
}
*/

            .caret-color {
                color: white;
            }

            .block_content ul li:hover .caret-color {
                color: #43b9da;
            }
        </style>
        <div class="about_menu">

            <div class="block_content">

                <ul class="menu ">

                    <?php

                    $url = s($_GET['cat']);

                    $lang = s($_GET['lng']);

                    $menu = $db->query("select * from menu where url_tag='" . $url . "' AND l_id='" . $lng1 . "' and s_id is NULL")->fetch(PDO::FETCH_ASSOC);

                    $sub_menu = $db->query("select *from menu where  s_id is NULL and l_id='" . $lng1 . "' AND sub_id=" . $menu['u_id'], PDO::FETCH_ASSOC);
                    if (isset($_GET['cname'])) {
                        $second_sub_menu = $db->query("select *from menu where l_id='" . $lng1 . "' AND url_tag='" . $_GET['cname'] . "'  and s_id is NULL");
                        $sec_sub_menu = $second_sub_menu->fetch(PDO::FETCH_ASSOC);
                    }


                    $new_sql = $db->prepare("SELECT * FROM menu WHERE l_id=:l_id AND sub_id=:sub_id  and s_id is NULL");
                    $new_sql->execute(array('l_id' => $lng1, 'sub_id' => $sec_sub_menu['u_id']));
                    $counter = $new_sql->rowCount();
                    if ($counter > 0) {
                        $width = 74;
                    } else {
                        $width = 100;
                    }
                    foreach ($sub_menu as $key => $menu_cek1) {

                        ?>
                        <?php
                        $sub_sql = $db->prepare("SELECT * FROM menu WHERE l_id=:l_id AND sub_id=:sub_id  and s_id is NULL");
                        $sub_sql->execute(array('l_id' => $menu_cek1['l_id'], 'sub_id' => $menu_cek1['u_id']));

                        ?>
                        <li id="<?php echo $key; ?>"
                            class="dropdown <?php if ($_GET['cname'] == $menu_cek1['url_tag']) {
                                echo 'active-dropdown';
                            } ?>" style="position:relative;z-index:1000; ">
                            <div style="display:table;text-align: middle;">

                                <a class="main-link <?php if ($_GET['cname'] == $menu_cek1['url_tag']) {
                                    echo 'active';
                                } ?>" style="display:table-cell"
                                   href="<?php if ($menu_cek1['link']) {
                                       echo $menu_cek1['link'];
                                   } else {
                                       echo $site_url . $lang . "/menu/" . $url . "/" . $menu_cek1['url_tag'] . "/";
                                   } ?>">
                                    <?php echo $menu_cek1['name']; ?><?php if ($sub_sql->rowCount() > 0) { ?><?php } ?>
                                </a>
                                <?PHP if ($sub_sql->rowCount() > 0) { ?>

                                    <div id="<?php echo $key; ?>"
                                         class="<?php if ($_GET['cname'] == $menu_cek1['url_tag']) {
                                             echo 'active';
                                         } ?> click-button-container">
                                        <i class="fa fa-caret-down caret-color" style=""></i>
                                    </div>
                                <?php } ?>
                            </div>

                            <?PHP if ($sub_sql->rowCount() > 0) { ?>
                                <div class="dropdown-content" id="<?php echo $key ?>">
                                    <?php while ($get = $sub_sql->fetch(PDO::FETCH_ASSOC)) {
                                        ?>

                                        <a style="color:#43B9DA; font-size:14px;line-height:25px;"
                                           href="<?php echo $site_url . $lang . "/menu/" . $url . "/" . $menu_cek1['url_tag'] . "/" . $get['url_tag'] . '/'; ?>"><?php echo $get['name']; ?></a>

                                    <?php } ?>
                                </div>
                            <?PHP } ?>
                        </li>

                        <?php

                    }

                    ?>

                </ul>

            </div>

        </div>


        <div class="middle_content about_page clearfix">

            <div class="short_desc clearfix">

                <div class="main_desc">

                    <?php if ($aa == true) {
                        echo $content['name'];
                    } ?></div>

                <?php
                if ($_GET['cname'] == 'supportemail') {
                    $overflow = "overflow: unset;";
                } else {
                    $overflow = '';
                }
                if ($_GET['cname'] == 'faq') {
                    $overflow = "overflow:unset;";
                }
                ?>
                <div id="wid100" class="description" style="<?php echo $overflow; ?> float: left;width: 100%">
                    <?php
                    if ($content['url_tag'] == 'faq') {
                        ?>
                        <div class="block_faq">
                            <span style="font-size:18px;"><?php echo $support['faq'][$lang]; ?></span>
                            <br><br>
                            <?php
                            $lng01sor = $db->prepare('SELECT * FROM  faq where  l_id=:lid order by ordering asc   ');
                            $lng01sor->execute(array('lid' => $lng1));
                            $lng01count = $lng01sor->rowCount();
                            $dkd = 0;
                            while ($lng01cek = $lng01sor->fetch(PDO::FETCH_ASSOC)) {
                                $dkd++;
                                ?>
                                <div class="col <?php if ($dkd == 1) {
                                    echo 'active';
                                } ?>">
                                    <div class="title"><?php echo $lng01cek['sual']; ?></div>
                                    <div class="description" style="<?php if ($dkd == 1) {
                                        echo 'display:block';
                                    } ?>"><?php echo $lng01cek['cavab']; ?></div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>

                    <?php
                    }else if ($content['url_tag'] == 'opportunity'){
                    ?>
                        <style>
                            body {
                                line-height: 1.3125 !important;
                                font-size: 14px !important;
                            }
                        </style>
                    <?php

                    $opportunity_banners = $db->prepare('select * from opportunity_banner where l_id = ? order by ordering asc');
                    $opportunity_banners->execute([$lng1]);
                    ?>

                        <link rel="stylesheet"
                          href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
                          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
                          crossorigin="anonymous">

                        <!--     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
                              integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
                              crossorigin="anonymous"></script>
                      -->
                        <style>
                            body {
                                font: 500 14px 'museosanscyr', Arial, sans-serif !important;
                            }
                        </style>

                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <?php while ($banner = $opportunity_banners->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <div class="<?php if ($banner['is_main'] == 1) {
                                        echo 'col-md-10 col-sm-12 col-xs-12';
                                    } else {
                                        echo 'col-md-5 col-sm-12 col-xs-12';
                                    } ?>">
                                        <div id="banner<?php echo $banner['u_id'] ?>" class="banner banner-style">
                                            <div class="opportunity_h1<?php if ($banner['is_main'] == 0) {
                                                echo '_alt';
                                            } ?>">
                                                <h1 class="h1-title">
                                                    <?php echo $banner['title']; ?>
                                                </h1>
                                            </div>

                                            <a class="opportunity_button<?php if ($banner['is_main'] == 0) {
                                                echo '_alt';
                                            } ?>"
                                               href="<?php echo $banner['button_link'] ?>"><?php echo $banner['button_text'] ?></a>
                                            <p class="opportunity_p<?php if ($banner['is_main'] == 0) {
                                                echo '_alt text-left';
                                            } ?> ">
                                                <?php echo $banner['description'] ?>
                                            </p>

                                        </div>
                                    </div>

                                    <style>
                                        #banner<?php echo $banner['u_id'] ?> {
                                            background-image: url(<?php echo $site_url.'cms/images/'.$banner['image'] ?>);
                                            background-color: #cccccc;
                                            height: <?php if($banner['is_main']==1){ echo '18vw';}else{ echo '13vw';} ?>;
                                            background-position: top;
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            padding-top: 200px;
                                        }

                                        #banner<?php echo $banner['u_id'] ?>:hover {
                                            /*  background-image:  url(


                                        <?php echo $site_url.'cms/images/'.$banner['image'] ?>      );*/
                                            /*  background-position: center;*/
                                        }

                                        .banner-style {
                                            position: relative;
                                            transition: all 0.5s ease;
                                        }

                                        .banner-style:before {
                                            content: '';
                                            position: absolute;
                                            top: 0;
                                            left: 0;
                                            right: 0;
                                            bottom: 0;
                                            background: linear-gradient(rgba(0, 3, 0, 0.2), rgba(0, 3, 0, 0.2));
                                            opacity: 0;
                                            transition: opacity 0.5s ease;
                                        }

                                        .banner-style:hover:before {
                                            opacity: 1;
                                        }

                                        #banner<?php echo $banner['u_id'] ?>:hover .opportunity_h1, #banner<?php echo $banner['u_id'] ?>:hover .opportunity_h1_alt,
                                        #banner<?php echo $banner['u_id'] ?>:hover .opportunity_p, #banner<?php echo $banner['u_id'] ?>:hover .opportunity_p_alt {
                                            transition: color 0.5s ease;
                                            color: white !important;
                                        }

                                        @media (min-width: 718px) and (max-width: 992px) {
                                            #banner<?php echo $banner['u_id'] ?> {
                                                height: <?php if($banner['is_main']==1){ echo '30vw';}else{ echo '38vw';} ?> !important;
                                            }
                                        }
                                    </style>
                                <?php } ?>

                            </div>

                        </div>

                    <br><br>

                        <style>

                            #menu {
                                margin-bottom: 0;
                            }

                            .opportunity_h1 {
                                color: #43B9DA;
                                position: absolute;
                                font-size: 40px;
                                top: 18%;
                                left: 4%;
                            }

                            .opportunity_h1_alt .h1-title {
                                margin-bottom: 0;
                                font-size: 25px;
                            }

                            @media (max-width: 991px) {
                                .opportunity_p, .opportunity_p_alt {
                                    font-size: 10px;
                                }
                            }

                            @media (max-width: 768px) {
                                .opportunity_h1 .h1-title {
                                    font-size: 20px ;
                                }
                            }

                            @media (max-width: 576px) {
                                .opportunity_p, .opportunity_p_alt {
                                    width: 90% !important;
                                }
                            }

                            @media (min-width: 576px) and (max-width: 768px) {
                                .opportunity_p, .opportunity_p_alt {
                                    width: 90% !important;
                                }
                            }

                            @media (min-width: 768px) and (max-width: 992px) {
                                .opportunity_p {
                                    width: 60% !important;
                                }

                                .opportunity_p_alt {
                                    width: 90% !important;
                                }
                            }

                            .opportunity_p {
                                position: absolute;
                                bottom: 3%;
                                left: 4%;
                                width: 70%;
                                line-height: 1.1;
                            }

                            .opportunity_p_alt {
                                position: absolute;
                                bottom: 2%;
                                left: 6%;
                                width: 89%;
                                line-height: 1.1;
                                font-size: 12px;

                            }

                            .opportunity_h1_alt {
                                color: #43B9DA;
                                position: absolute;
                                font-size: 25px;
                                top: 18%;
                                left: 6%;
                            }

                            .banner {
                                margin: 10px 0 10px 0;
                                -moz-box-shadow: 0 0 10px #ccc;
                                -webkit-box-shadow: 0 0 10px #ccc;
                                box-shadow: 0 0 10px #ccc;
                            }

                            .opportunity_button {
                                position: absolute;
                                color: #43B9DA;
                                font-weight: bold;
                                left: 4%;
                                bottom: 35%;
                            }

                            .opportunity_button_alt {
                                position: absolute;
                                left: 6%;
                                font-weight: bold;
                                color: #43B9DA;
                                bottom: 35%;
                                transition: color 0.5s ease;
                            }

                            .opportunity_button_alt:hover, .opportunity_button:hover {
                                color: white;
                                text-decoration: none;
                            }

                            .banner-style .opportunity_p_alt, .banner-style .opportunity_p {
                                margin-bottom: 0;
                                opacity: 1;
                                transition: all 0.5s ease;
                            }

                            .banner-style:hover .opportunity_p_alt, .banner-style:hover .opportunity_p {
                                opacity: 1;
                                transition: all 0.5s ease;
                            }

                            @media (max-width: 1200px) {
                                .banner-style .opportunity_p_alt, .banner-style .opportunity_p {
                                    margin-bottom: 0;
                                    opacity: 1;
                                    color: #fff;
                                }

                                .banner-style:before {
                                    opacity: 1;
                                }

                                .opportunity_button_alt, .opportunity_button, .opportunity_h1_alt, .opportunity_h1 {
                                    color: white;
                                    text-decoration: none;
                                }
                            }

                        </style>

                        <?php
                    } else {
                        echo $content['text'];
                    }

                    ?>

                </div>
            </div>


        </div>

    </div>



