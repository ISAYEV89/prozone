<script defer src="<?php echo $site_url; ?>user/js/all.js"></script>

<script type="text/javascript">
    // Notice how this gets configured before we load Font Awesome
    window.FontAwesomeConfig = {autoReplaceSvg: true}
</script>


<style>
    .child3 {
        color: #3296da;
    }
</style>

<style>
    svg path {
        color: white;
    }

    .dropdown:hover svg path {
        color: #43b9da;
    }

    .dropdown:hover div {
        background-color: white;
    }

    .dropdown .active svg path {
        color: #43b9da;
    }

</style>
<div class="middle">

    <div class="container">

        <div class="page_title_wrapper">

            <h1 class="page_title">

                <?php

                $url = s($_GET['cat']);

                $lang = s($_GET['lng']);

                $menu = $db->query("select * from menu where url_tag='" . $url . "' AND l_id='" . $lng1 . "'")->fetch(PDO::FETCH_ASSOC);

                echo $menu['name'];

                ?></h1>

        </div>

        <div class="about_menu">

            <div class="block_content">

                <ul class="menu">

                    <?php

                    $url = s($_GET['cat']);

                    $lang = s($_GET['lng']);

                    $menu = $db->query("select * from menu where url_tag='" . $url . "' AND l_id='" . $lng1 . "'")->fetch(PDO::FETCH_ASSOC);

                    $sub_menu = $db->query("select *from menu where l_id='" . $lng1 . "' AND sub_id=" . $menu['u_id'], PDO::FETCH_ASSOC);
                    $second_sub_menu = $db->query("select * from menu where l_id='" . $lng1 . "' AND url_tag='" . $_GET['cname'] . "'");
                    $sec_sub_menu = $second_sub_menu->fetch(PDO::FETCH_ASSOC);
                    $new_sql = $db->prepare("SELECT * FROM menu WHERE l_id=:l_id AND sub_id=:sub_id");
                    $new_sql->execute(array('l_id' => $lng1, 'sub_id' => $sec_sub_menu['u_id']));
                    $counter = $new_sql->rowCount();
                    if ($counter > 0) {
                        $width = 74;
                    } else {
                        $width = 100;
                    }
                    foreach ($sub_menu as $menu_cek1) {

                        ?>
                        <?php
                        $sub_sql = $db->prepare("SELECT * FROM menu WHERE l_id=:l_id AND sub_id=:sub_id");
                        $sub_sql->execute(array('l_id' => $menu_cek1['l_id'], 'sub_id' => $menu_cek1['u_id']));

                        ?>
                        <li id="<?php echo $key; ?>"
                            class="dropdown <?php if ($_GET['cname'] == $menu_cek1['url_tag']) {
                                echo 'active-dropdown';
                            } ?>">
                            <div style="display:table;align-text:middle;">

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
                                        <i class="fas fa-caret-down"></i>
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

                    <?php

                    if (isset($_GET['cname'])) {

                        $tag = s($_GET['cname']);

                        $aa = true;

                    } else {

                        $tag = s($_GET['cat']);

                    }

                    $content = $db->query("select *from menu where l_id='" . $lng1 . "' AND url_tag='" . $_GET['child'] . "'")->fetch(PDO::FETCH_ASSOC);

                    ?>

                    <?php if ($aa == true) {
                        echo $content['name'];
                    } ?></div>

                <div id="wid100" class="description " style="float: left;width: 100%">

                    <?php
                    echo $content['text'];
                    //********************************************adding slider to product for customer**********************************
                    if (@$_GET['child'] == 'products_for_customer') {
                        ?>
                        <div class="block_goods goods_popular">
                            <div class="block_content">
                                <?php
                                //product slider starts here********************************************************************************************

                                //All country olan mehsullari secirik******************************************************************************************
                                $lng01sor = $db->prepare('SELECT * FROM mehsul m where s_id="1" and home="1" and l_id=:lid  order by ordering asc  ');
                                $lng01sor->execute(array('lid' => $lng1));
                                $products = array(); //Butun productlar bu massive yigilacaq
                                $prodid_arr = array(); //produkt idlerini bir massive yigiriq
                                while ($b = $lng01sor->fetch(PDO::FETCH_ASSOC)) {
                                    $proid = $b['u_id'];
                                    $products[$proid] = $b;
                                    $prodid_arr[] = $proid;
                                    $products[$proid]['currid'] = 1;
                                }
                                //*******************************************************************************************************************************

                                //If he is logged in, add products that are related to his country***********************************************************************************
                                if (@$_SESSION['id']) {
                                    $lng01sor = $db->prepare('SELECT m.* FROM mehsul m, mehsul_olke mo where m.s_id="1" and m.l_id=:lid and m.u_id=mo.m_u_id and mo.o_u_id= :olke  and home="1" order by m.ordering asc  ');
                                    $lng01sor->execute(array('lid' => $lng1, 'olke' => $_SESSION['country']));
                                    while ($b = $lng01sor->fetch(PDO::FETCH_ASSOC)) {
                                        $proid = $b['u_id'];
                                        $products[$proid] = $b;
                                        $prodid_arr[] = $proid;
                                        $products[$proid]['currid'] = 1;
                                    }
                                    //*********************************************************************************************************************************

                                    //if he is logged in , Secilmish olke ucun olan xususi qiymetleri cixardiriq****************************************************************************

                                    $lng01sor = $db->prepare('SELECT mop.*, c.short_name, c.u_id as currid FROM mehsul_olke_price mop , currency c, olkeler o where  mop.o_u_id= :olke and o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang');
                                    $lng01sor->execute(array('olke' => $_SESSION['country'], 'lang' => $lng1));
                                    while ($b = $lng01sor->fetch(PDO::FETCH_ASSOC)) {
                                        $proid = $b['m_u_id'];
                                        if ($products[$proid]) {
                                            $products[$proid]['price_1'] = $b['price_1'];
                                            $products[$proid]['price_2'] = $b['price_2'];
                                            $products[$proid]['price_3'] = $b['price_3'];
                                            $products[$proid]['shipping_1'] = $b['shipping_1'];
                                            $products[$proid]['shipping_2'] = $b['shipping_2'];
                                            $products[$proid]['shipping_3'] = $b['shipping_3'];
                                            $products[$proid]['countryid'] = $_SESSION['country'];
                                            $products[$proid]['currid'] = $b['currid'];
                                            $products[$proid]['short_name'] = $b['short_name'];
                                        }
                                    }

                                    $_SESSION['valuvalyut'] = $b['short_name'];
                                }
                                //*********************************************************************************************************************************
                                //EGER discount varsa onu da hesablayib elave edirik*******************************************************************************
                                $idss = implode(',', $prodid_arr);
                                $shop_type = 1;
                                $prmenx = 'price_' . $shop_type;
                                $shmenx = 'shipping_' . $shop_type;
                                $lng01sor = $db->prepare('SELECT md.*, mop.o_u_id FROM mehsul_discount md, mehsul_olke_price mop where  md.m_u_id in (' . $idss . ') and md.s_id=1 and md.shop_type=:shop_type and (md.mop_id=0 or (md.mop_id=mop.id and mop.o_u_id=:country and mop.m_u_id=md.m_u_id)) group by md.id');
                                $lng01sor->execute(array('country' => @(int)$_SESSION['country'], 'shop_type' => $shop_type));
                                while ($b = $lng01sor->fetch(PDO::FETCH_ASSOC)) {
                                    $proid = $b['m_u_id'];
                                    if (@$products[$proid] and (@$products[$proid]['countryid'] == $b['o_u_id'] or (@!$products[$proid]['countryid'] and $b['mop_id'] = 0))) {
                                        $prname = 'price_' . $shop_type;    //hansi qiymete endirim edeceyimizi tapiriq
                                        if ($b['type'] == 1)//endirim tipine gore hesablama edim endirimli qiymeti elave edirik
                                        {
                                            $priced = ceil($products[$proid][$prname] * (100 - $b['value']) / 100);
                                        } else {
                                            $priced = $products[$proid][$prname] - $b['value'];
                                        }
                                        //massive melumatlari elave edirik
                                        $products[$proid]['discount'] = $b['value'];
                                        $products[$proid]['disc_price'] = $priced;
                                    }
                                }
                                //*********************************************************************************************************************************

                                if (@$_SESSION['id']) {
                                    //Butun mehsul qiymetlerini secilmish olkenin currency-sine ceviririk***************************************************************
                                    $lng01sor = $db->prepare('SELECT c.short_name, c.u_id as currid FROM  currency c, olkeler o where  o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang');
                                    $lng01sor->execute(array('olke' => $_SESSION['country'], 'lang' => $lng1));
                                    $bi = $lng01sor->fetch(PDO::FETCH_ASSOC);
                                    $_SESSION['countrycurrency'] = $bi['currid'];


                                    //butun currency rates secilib arraya salinir******************************
                                    $lng01sor = $db->prepare('SELECT * FROM  currency_rates');

                                    $lng01sor->execute();
                                    $cr = array();
                                    while ($bcr = $lng01sor->fetch(PDO::FETCH_ASSOC)) {
                                        $crid = $bcr['id'];
                                        $cr[$crid] = $bcr;
                                    }
                                    //*************************************************************************

                                    foreach ($products as $key => $val) {
                                        if (@$products[$key]['countryid']) // eger country id varsa problem yoxdur
                                        {
                                        } else //yoxdursa qiymetler konvert olunmalidir
                                        {

                                            if ($products[$key]['currid'] == $bi['currid'])//eger hal hazir ki valyuta novu secilmish olke ile eynidirse hecne etmirik
                                            {

                                            } else //eger ferqlidirse qiymet hesablanir. ve valyuta novu elave olunur
                                            {

                                                $t1 = $products[$key]['currid'];
                                                $t2 = $bi['currid'];
                                                $prname = 'price_' . $shop_type;
                                                $shname = 'shipping_' . $shop_type;
                                                $products[$key][$prname] = ceil(($products[$key][$prname] * ($cr[$t1]['Nominal'] * $cr[$t1]['value'])) / ($cr[$t2]['Nominal'] * $cr[$t2]['value'])); //price hesablanir
                                                $products[$key][$shname] = ceil(($products[$key][$shname] * ($cr[$t1]['Nominal'] * $cr[$t1]['value'])) / ($cr[$t2]['Nominal'] * $cr[$t2]['value'])); //shipping hesablanir

                                                if (@$products[$key]['disc_price'])//eger discount varsa o da hesablanir
                                                {
                                                    $products[$key]['disc_price'] = ceil($products[$key]['disc_price'] * $cr[$t1]['Nominal'] * $cr[$t1]['value'] / ($cr[$t2]['Nominal'] * $cr[$t2]['value'])); //price hesablanir
                                                }
                                                $products[$key]['countryid'] = $_SESSION['country'];
                                                $products[$key]['currid'] = $bi['currid'];
                                                $products[$key]['short_name'] = $bi['short_name'];
                                            }
                                        }
                                    }
                                }
                                //**********************************************************************************************************************************
                                foreach ($products as $key => $val) {

                                    $bb['kat_u_id'] = 1;
                                    //valyutane teyin edirik
                                    if (@$products[$key]['countryid']) {
                                        $short_name = $products[$key]['short_name'];
                                    } else {
                                        $short_name = 'USD';
                                    }
                                    ?>
                                    <div class="col col_1">
                                        <?PHP
                                        ?>
                                        <div class="field_content">
                                            <img style="margin-bottom:28px;"
                                                 src="<?PHP echo $site_url . 'cms/images/' . $products[$key]['image_url']; ?>"
                                                 alt="<?PHP echo $products[$key]['name']; ?>">
                                        </div>
                                        <?PHP
                                        ?>
                                        <div class="title">
                                            <a href="<?PHP echo $site_url . $lng . '/shop/' . $bb['kat_u_id'] . '/' . $products[$key]['u_id'] . '/' ?>"><?PHP echo $products[$key]['name']; ?></a>
                                        </div>
                                        <div class="price_wrap">
                                            <?PHP
                                            if (@$_SESSION['login']) {
                                                if (@$products[$key]['discount']) {
                                                    echo '<div class="old_price" style="text-decoration: none;">' . $products[$key][$prmenx] . ' ' . $short_name . ' </div><div class="price">' . $products[$key]['disc_price'] . ' ' . $short_name . '<span></span></div>';
                                                } else {
                                                    echo '<div class="price">' . $products[$key][$prmenx] . ' ' . $short_name . '<span></span></div>';
                                                }
                                            }
                                            ?>
                                        </div>

                                        <?PHP
                                        echo '<div class="add_to_basket"><a href="' . $site_url . $lng . '/shop/' . $bb['kat_u_id'] . '/' . $products[$key]['u_id'] . '/' . '">' . $home_body['rmore'][$lng] . '</a></div>';

                                        ?>
                                    </div>

                                    <?PHP
                                }
                                //product slider ends here********************************************************************************************
                                ?>
                            </div>
                        </div>
                        <?PHP
                    }
                    ?>

                </div>

            </div>


        </div>

    </div>

<!--    <script>

        $(document).ready(function () {





        });
    </script>
-->