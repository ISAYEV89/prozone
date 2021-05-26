<?PHP
$shop_type=2; //Here we mark which e-shop we are working with (1 e-shop, 2 registration, 3 commission shop)
$prmenx='price_'.$shop_type;
$shmenx='shipping_'.$shop_type;

$smpa='(2,3,6,7)'; //shops_mainpage values
$limit=9;//limit for product count in 1 page.
// check post data.
if ($_POST['la_id'] && $_POST['la_login'] && $_POST['country_login']) {
    echo '<script>localStorage.clear();</script>';//girishde localstorage-i temizleyirik
    unset($_SESSION['signup_referer_id'], $_SESSION['signup_country_id']);//destroying all sessions/***********************************
    //if($_SERVER["HTTP_REFERER"]!=$site_url.$lng.'/sign-up/'){exit;}// check refering page
    $la_serial = $_POST['la_id'];
    $login = $_POST['la_login'];
    if ($login == '' or $la_serial == '') {
        $emailErrMsg = $signupshop['errormsg'][$lng];
        $emailErr = 1;
    } else {
        $a = $db->prepare('SELECT * from `user` where  `login` =:login and serial= :serial limit 1');
        $a->execute(ARRAY('serial' => $la_serial, 'login' => $login));
        $ab = $a->fetch(PDO::FETCH_ASSOC);
        if (!$ab['id']) {
            $emailErrMsg = $signupshop['errormsg'][$lng];
            $emailErr = 2;
        } else {
            $_SESSION['signup_referer_id'] = $ab['id'];                    // if referer data is correct write it to session
            $_SESSION['signup_country_id'] = $_POST['country_login'];
            //echo'<script>alert("aaaaa");</script>';
        }
    }
} elseif ($_SESSION['signup_referer_id'] && $_SESSION['signup_country_id']) {
} else {
    echo '<script>localStorage.clear();</script>';//girishde localstorage-i temizleyirik
    unset($_SESSION['signup_referer_id'], $_SESSION['signup_country_id']);//destroying all sessions/***********************************
    $emailErrMsg = $signupshop['errormsg'][$lng];
    $emailErr = 3;
}

$n=0;

?>
<input class="session-valuvalyut" type="hidden" value=" <?PHP echo ($_SESSION['valuvalyut'] == 0 ? '0' : $_SESSION['valuvalyut']) ; ?>">
<input class="site-url-address" type="hidden" value="<?PHP echo $site_url.$lng2; ?>">

<div class="middle">
	<div class="container">
		<div class="page_title_wrapper">
			<h1 class="page_title"><?php echo $signup['product'][$lng] ?></h1>
		</div>
		<div class="middle_content clearfix">
		<?PHP
        if ($emailErr >= 1) {
            ?>
            <div class="order_form user_settings">
                <div class="form_item" style="text-align:center;">
                    <h3 style="text-align:center;">
                        <?PHP echo $emailErrMsg; ?>
                    </h3>
                </div>
                <br>
                <div style="text-align:center;">
                    <div  class="form-style" id="backBtn"
                          onclick="location.replace('<?PHP echo $site_url . $lng . '/sign-up/'; ?>');">
                        <?PHP echo $lostpassword['backbtn2'][$lng]; ?>
                    </div>
                </div>
            </div>

            <?PHP
        } else {
            ?>

			<div class="left_sidebar catalog-bar">
				<div class="block_products_sidebar">
					<div class="block_content">
                        <div class="catalog-bar__header">
                            <h1 class="catalog-bar__title"><?PHP echo $category['productlist'][$lng]; ?></h1>
                            <i class="fa fa-caret-down caret-color" style=""></i>
                        </div>
                        <div class="catalog-bar__list">
                            <?php
                            $lng1sor = $db->prepare('SELECT * FROM kateqoriyalar where s_id="0" and l_id=:lid  order by ordering asc  ');
                            $lng1sor->execute(array('lid' => $lng1));
                            $lng1count = $lng1sor->rowCount();
                            $record = 0;
                            while ($lng1cek = $lng1sor->fetch(PDO::FETCH_ASSOC)) {
                                $record++;
                                ?>

                                <div class="col col_<?php echo $record;
                                if ($_GET['cat'] != '' and $_GET['cat'] == $lng1cek['kat_id']) {
                                    echo ' active';
                                } ?>">
                                    <div class="image">
                                        <a href="<?php echo $site_url . $lng . '/signup_shop/' . $lng1cek['kat_id'] . '/'; ?>">
                                            <img
                                                src="<?php echo $site_url; ?>cms/images/<?php echo $lng1cek['picture']; ?>"
                                                alt="<?php echo $lng1cek['name']; ?>">
                                        </a>
                                    </div>

                                    <div class="title">
                                        <div class="field_content">
                                            <a href="<?php echo $site_url . $lng . '/signup_shop/' . $lng1cek['kat_id'] . '/'; ?>">
                                                <?php echo $lng1cek['name']; ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
					</div>

				</div>

			</div>

			<div class="page_content pd-15-lg">
				<div class="block_goods good_page">
					<div class="good_header clearfix">
						<div class="label"><?php echo $home_body['sort'][$lng]; ?> : </div>
						<div class="links_wrap">
						    <?php
                            if (strlen($_GET['cat']) > 1) {
                                $cat = explode('-', $_GET['cat']);
                                $active_sort = $cat[1];
                                $value = $cat[0];
                            } elseif (!$_GET['cat']) {
                                $active_sort = 0;
                                $value = 0;
                            } else {
                                $active_sort = 0;
                                $value = $_GET['cat'];
                            }

                            ?>
                            <a href="<?php echo $site_url.$lng.'/signup_shop/'.$value.'-'.(($active_sort==1)?"4":"1").'/'; ?>" class="link
							<?php
								if($active_sort == 1) 		{	echo 'active_up'; 	}
								elseif($active_sort == 4)	{	echo 'active_down'; }
								else						{	echo 'active'; 		}
							?>">
							    <?php echo $home_body['price'][$lng]; ?><span></span>
							</a>

							<a href="<?php echo $site_url.$lng.'/signup_shop/'.$value.'-'.(($active_sort==2)?"5":"2").'/'; ?>" class="link
							<?php
								if($active_sort == 2) 		{	echo 'active_up'; 	}
								elseif($active_sort == 5)	{	echo 'active_down'; }
								else						{	echo 'active'; 		}
							?>">
							    <?php echo $home_body['popularity'][$lng]; ?>
							</a>

							<a href="<?php echo $site_url.$lng.'/signup_shop/'.$value.'-'.(($active_sort==3)?"6":"3").'/'; ?>" class="link
							<?php
								if($active_sort == 3) 		{	echo 'active_up'; 	}
								elseif($active_sort == 6)	{	echo 'active_down'; }
								else						{	echo 'active'; 		}
							?>">
							    <?php echo $home_body['novelty'][$lng]; ?>
							</a>

						</div>

					</div>
					<div class="good_content">

<?php
if (empty($_GET['cat']) or $value == '0') {
    $frm = '';
    $whr = 'and m.shops_mainpage in ' . $smpa;
} else {
    $frm = ' ,mehsul_kateqoriya  mk';
    $whr = 'and mk.kat_u_id="' . $value . '" and m.u_id=mk.m_u_id';
}

	//All country olan mehsullari secirik******************************************************************************************
	$lng01sor=$db->prepare('SELECT * FROM mehsul m '.$frm.' where m.s_id="1" and m.l_id=:lid and m.all_country="1" '.$whr.'  order by ordering asc  ');
	$lng01sor->execute(array('lid'=>$lng1));
	$products=ARRAY(); //Butun productlar bu massive yigilacaq
	$prodid_arr=ARRAY(); //produkt idlerini bir massive yigiriq

while ($b = $lng01sor->fetch(PDO::FETCH_ASSOC)) {

    $proid = $b['u_id'];
    $products[$proid] = $b;
    $prodid_arr[] = $proid;
    $products[$proid]['currid'] = 1;

}
	//*******************************************************************************************************************************

	// Secilmish olkeye aid olan mehsullar secilir***********************************************************************************
	$lng01sor=$db->prepare('SELECT m.* FROM mehsul m, mehsul_olke mo '.$frm.' where m.s_id="1" and m.l_id=:lid and m.u_id=mo.m_u_id and mo.o_u_id= :olke '.$whr.' order by m.ordering asc  ');
	$lng01sor->execute(array('lid'=>$lng1 , 'olke'=>$_SESSION['signup_country_id'] ));
while ($b = $lng01sor->fetch(PDO::FETCH_ASSOC)) {

    $proid = $b['u_id'];
    $products[$proid] = $b;
    $prodid_arr[] = $proid;
    $products[$proid]['currid'] = 1;

}

//*********************************************************************************************************************************

//Secilmish olke ucun olan xususi qiymetleri cixardiriq****************************************************************************

$lng01sor = $db->prepare('SELECT mop.*, c.short_name, c.u_id as currid FROM mehsul_olke_price mop , currency c, olkeler o where  mop.o_u_id= :olke and o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang');

$lng01sor->execute(array('olke' => $_SESSION['signup_country_id'], 'lang' => $lng1));


while ($b = $lng01sor->fetch(PDO::FETCH_ASSOC)) {
    $proid = $b['m_u_id'];
    if ($products[$proid]) {
        $products[$proid]['price_1'] = $b['price_1'];
        $products[$proid]['price_2'] = $b['price_2'];
        $products[$proid]['price_3'] = $b['price_3'];
        $products[$proid]['shipping_1'] = $b['shipping_1'];
        $products[$proid]['shipping_2'] = $b['shipping_2'];
        $products[$proid]['shipping_3'] = $b['shipping_3'];
        $products[$proid]['countryid'] = $_SESSION['signup_country_id'];
        $products[$proid]['currid'] = $b['currid'];
        $products[$proid]['short_name'] = $b['short_name'];
    }
}

//*********************************************************************************************************************************

//EGER discount varsa onu da hesablayib elave edirik*******************************************************************************
$idss = implode(',', $prodid_arr);
$lng01sor = $db->prepare('SELECT md.*, mop.o_u_id FROM mehsul_discount md, mehsul_olke_price mop where  md.m_u_id in (' . $idss . ') and md.s_id=1 and md.shop_type=:shop_type and (md.mop_id=0 or (md.mop_id=mop.id and mop.o_u_id=:country and mop.m_u_id=md.m_u_id)) group by md.id');

$lng01sor->execute(array('country' => $_SESSION['signup_country_id'], 'shop_type' => $shop_type));

while ($b = $lng01sor->fetch(PDO::FETCH_ASSOC)) {
    //print_r($b);
    $proid = $b['m_u_id'];
    if ($products[$proid] and ($products[$proid]['countryid'] == $b['o_u_id'] or (!$products[$proid]['countryid'] and $b['mop_id'] = 0))) {
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
//Butun mehsul qiymetlerini secilmish olkenin currency-sine ceviririk***************************************************************
$lng01sor = $db->prepare('SELECT c.short_name, c.u_id as currid FROM  currency c, olkeler o where  o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang');
$lng01sor->execute(array('olke' => $_SESSION['signup_country_id'], 'lang' => $lng1));
$bi = $lng01sor->fetch(PDO::FETCH_ASSOC);

//butun currency rates secilib arraya salinir******************************
$lng01sor = $db->prepare('SELECT * FROM  currency_rates');

$lng01sor->execute();
$cr = ARRAY();
while ($bcr = $lng01sor->fetch(PDO::FETCH_ASSOC)) {
    $crid = $bcr['id'];
    $cr[$crid] = $bcr;
}
	//*************************************************************************

foreach ($products as $key => $val) {
    if ($products[$key]['countryid']) // eger country id varsa problem yoxdur
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

            //echo '('.$products[$key][$prname].'/('.$cr[$t1]['Nominal'].'*'.$cr[$t1]['value'].'))/('.$cr[$t2]['Nominal'].'*'.$cr[$t2]['value'].')';
            $products[$key][$prname] = currconverter($db, $products[$key][$prname], $t1, $t2); //price hesablanir
            $products[$key][$shname] = currconverter($db, $products[$key][$shname], $t1, $t2); //shipping hesablanir

            //echo '<script>console.log("'.$products[$key]['u_id'].' - '.$t1.' - '.$t2.'")</script>';
            if ($products[$key]['disc_price'])//eger discount varsa o da hesablanir
            {
                $products[$key]['disc_price'] = currconverter($db, $products[$key]['disc_price'], $t1, $t2); //price hesablanir

            }

            $products[$key]['countryid'] = $_SESSION['signup_country_id'];
            $products[$key]['currid'] = $bi['currid'];
            $products[$key]['short_name'] = $bi['short_name'];
        }

    }
}
	//**********************************************************************************************************************************


	$decods=0;

	//sorting multi dimensional array according to user sort type ***********************************************************************
foreach ($products as $key => $row) {
    $prname = 'price_' . $shop_type;
    if ($row['disc_price']) {
        $pprice[$key] = $row['disc_price'];
    } else {
        $pprice[$key] = $row[$prname];
    }
    $porder[$key] = $row['ordering'];
    $puid[$key] = $row['u_id'];
}

	switch($active_sort)
	{
		case 1: array_multisort($pprice, 	SORT_DESC, $products); break;
		case 2: array_multisort($porder,	SORT_DESC, $products); break;
		case 3: array_multisort($puid, 		SORT_DESC, $products); break;
		case 4: array_multisort($pprice, 	SORT_ASC, $products); break;
		case 5: array_multisort($porder,	SORT_ASC, $products); break;
		case 6: array_multisort($puid, 		SORT_ASC, $products); break;
	}
	//***********************************************************************************************************************************

	//finding page number for paginator**************************************************************************************************
if ($_GET['cname']) {
    $pg = explode('=', $_GET['cname']);
    $pgnum = $pg[1];
} else {
    $pgnum = 1;
}
$dlim = ($pgnum - 1) * $limit;
$ulim = $pgnum * $limit;
//***********************************************************************************************************************************
$prnum = 0;
foreach ($products as $key => $val) {
    if ($prnum >= $dlim and $prnum < $ulim) {

        $lng01sor = $db->prepare('SELECT * FROM mehsul_kateqoriya mop where  mop.m_u_id= ' . $key . ' limit 1');

        $lng01sor->execute();


        $bb = $lng01sor->fetch(PDO::FETCH_ASSOC);


        if (@$bb['kat_u_id']) {

        } else {
            $bb['kat_u_id'] = 1;
        }
        $decods++;

        //valyutane teyin edirik
        if ($products[$key]['countryid']) {
            $short_name = $products[$key]['short_name'];
        } else {
            $short_name = 'USD';
        }
        ?>
        <div class="col col_<?php  echo $decods; ?> smcs">
            <a href="<?php echo $site_url.$lng.'/signup_shop/'.$bb['kat_u_id'].'/'.$products[$key]['u_id'].'/' ?>" class="image">
                <div class="field_content"><img class='otk' src="<?php echo $site_url.'cms/images/'.$products[$key]['image_url']; ?>" alt="<?php  echo $products[$key]['name']; ?>"></div>
            </a>
            <div class="title">
                <a href="<?php echo $site_url.$lng.'/signup_shop/'.$bb['kat_u_id'].'/'.$products[$key]['u_id'].'/' ?>"><?php  echo $products[$key]['name']; ?>	</a>
            </div>
            <div class="price_wrap">
                <span style="display: inline-block; text-align: right;float: right;font-size: 14px;">
                    <span class="pointholder">
                        <?php echo $products[$key]['point'] ;  ?>
                    </span>
                    Point (s)
                </span>

            <?PHP
            if ($products[$key]['discount']) {
                echo '<div class="old_price" style="text-decoration: none;">' . $products[$key][$prmenx] . ' ' . $short_name . ' </div><div class="price">' . $products[$key]['disc_price'] . ' ' . $short_name . '<span></span></div>';
            } else {
                echo '<div class="price">' . $products[$key][$prmenx] . ' ' . $short_name . '<span></span></div>';
            }
            ?>
        </div>

			<?PHP
			if(checkRpCount($db,$products[$key]['u_id']) > 0)
			{
				?>
				<div class="add_to_basket">
					<input type="button"
					value='<?php echo $shopdetail['buy'][$lng]; ?>'
					data-text="Add To Cart"
					class="addtocart add_to_basket"
					onclick="add2(<?php echo $products[$key]['u_id'];  ?>)"
					id="<?php echo $products[$key]['u_id'] ;  ?>"
					data-name="<?php echo $products[$key]['name'] ;  ?>"
					data-ship="<?php echo $products[$key][$shmenx] ;  ?>"
					data-price="<?php if($products[$key]['discount']){echo $products[$key]['disc_price'] ;}else{echo $products[$key][$prmenx] ;}  ?>"
					data-img="<?php echo $products[$key]['image_url'] ;  ?>"
					data-currency="<?php echo $short_name ;  ?>"
					data-shoptype="<?php echo $shop_type ;  ?>"
					data-currencyid="<?php echo $products[$key]['currid'] ;?>"/>
				</div>
				<?PHP
			}
			else
			{
				?>
				<div class="add_to_basket">
					<input type="button" value='<?php echo $shopdetail['oostock'][$lng]; ?>'	>
				</div>
			<?PHP
			}

			?>
			</div>
			<?php
			if ($decods%3==0)
			{
			?>
				<div class="line"> ---- </div>
			<?php
			}
		}
		$prnum++;
	}
	?>
						<!--paginator-->

				<section class="paginator">
					<ul>
                        <?php
						$say=count($products);
                    $pCount = ceil($say/$limit);
                    ?>
                    <li class="paginator-prev"><a <?php if($pgnum>1){ echo 'href="'.$site_url.''.$lng.'/signup_shop/'.$_GET['cat'].'/page='.intval($pgnum-1).'/"'; } ?> ></a></li>
                    <?php
                    for ($i = 1; $i <= $pCount; $i++) {

                         if ($i == $pgnum) { ?>
                            <li class="active"><a style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/signup_shop/'.$_GET['cat'].'/page='.$i.'/'; ?>"><?php echo $i; ?></a></li>
                        <?php } else if ($i <= 2) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/signup_shop/'.$_GET['cat'].'/page='.$i.'/'; ?>"><?php echo $i.''; ?></a></li>
                        <?php } else if ($pCount - 2 <= $i) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/signup_shop/'.$_GET['cat'].'/page='.$i.'/'; ?>"><?php echo $i.''; ?></a></li>
                        <?php } else if (($pgnum - 2) <= $i AND ($pgnum + 2) >= $i) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/signup_shop/'.$_GET['cat'].'/page='.$i.'/'; ?>"><?php echo $i.''; ?></a></li>
                        <?php } else if ($i < $pgnum) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/signup_shop/'.$_GET['cat'].'/page='.round(($pgnum - 2) / 2).'/';?>"><?php echo '...'; ?></a></li>
                            <?php $i = $pgnum - 2;
                        } else if ($i > $pgnum) { ?>
                            <li><a  style="cursor:pointer;" href="<?php echo $site_url.''.$lng.'/signup_shop/'.$_GET['cat'].'/page='.round(($pCount  + $pgnum) / 2).'/'; ?>"><?php echo '...'; ?></a>
                            </li>
                            <?php $i = $pCount - 2;
                        }
                    }
                    ?>

					<li class="paginator-next"><a <?php if($pgnum!=$pCount){ echo 'href="'.$site_url.''.$lng.'/signup_shop/'.$_GET['cat'].'/page='.intval($pgnum+1).'/"'; } ?>></a></li>
					</ul>
				</section>
						<!--end paginator-->
					</div>
				</div>
			</div>
			<?PHP
			}
			?>
		</div>
	</div>
</div>
<div class="foot">
    <div class="foot_container">
        <div onclick="closefoot();" class="close">Close</div>
        <div class="js-add">
            <span><img src="<?PHP echo $site_url.'/images/accept_icon.png';?>"/><?PHP echo $shopdetail['itemadd'][$lng];?></span>
            <a href="<?PHP echo $site_url.$lng.'/shop/basket/' ?>"><?PHP echo $shopdetail['basketview'][$lng];?><span id="fbcount">5</span></a>
        </div>
        <div class="js-out d-none">
            <span><?PHP echo $shopdetail['itemadddone'][$lng];?></span>
        </div>
    </div>
</div>

<style>
    .foot {
        border-top: 5px solid #43b9da;
        position: fixed;
        width: 100%;
        z-index: 10000;
        text-align: center;
        height: 100px;
        font-size: 18px;
        color: #000;
        background: #FFF;
        display: flex;
        justify-content: center; /* align horizontal */

        right: 0;
        left: 0;
        margin-right: auto;
        margin-left: auto;
        bottom: -1000px;
        font-size: 14px;
        padding-top: 40px;
    }

    .slide-up {
        bottom: 0px !important;
    }

    .slide-down {
        bottom: -1000px !important;
    }

    .foot img {
        width: 20px;
        margin-top: -3px;
        margin-right: 10px;
        float: left;
    }

    .foot a {
        border: 1px solid #43b9da;
        margin-left: 40px;
        padding: 10px 15px;
        color: white;
        text-decoration: none;
        background: #43b9da;
        font-weight: bold;
    }

    .foot .close {
        width: 20px;
        height: 20px;
        background: url(<?PHP echo $site_url?>images/close.png) no-repeat scroll 0 0 transparent;
        position: absolute;
        top: 11px;
        right: 11px;
        text-indent: -9999px;
        cursor: pointer;
        -webkit-transition: .3s;
        transition: .3s;
    }

    .pointholder {
        border: 1px solid #57cae9;
        border-radius: 6px;
        color: #57cae9;
        width: 25px;
        height: 25px;
        display: inline-block;
        text-align: center;
        line-height: 25px;
        font-weight: bold;
        background-image: linear-gradient(180deg, rgba(255, 255, 255, 0.03) 0%, rgba(0, 138, 176, 0.05) 100%);
    }

    .form-style {
        min-height: 48px;
        -webkit-box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);
        box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);
        background: #43b9da;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);
        cursor: pointer;
        font-size: 24px;
        font-weight: 300;
        border: none;
        width: 270px;
        color: #fff;
        padding: 7px;
        line-height: 30px;
        margin: 0px auto;
    }


    @media only screen and (max-width: 980px) {
        .slide-up {
            bottom: 48px !important;
        }

    }

    @media only screen and (max-width: 480px) {

        .js-add > span{
            width: 100%;
            position: relative;
            display: block;
            top: -20px;
        }

        .js-add >a {
            margin-left: 0;
        }
    }
</style>




