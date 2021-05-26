

<input class="session-valuvalyut" type="hidden" value=" <?PHP echo ($_SESSION['valuvalyut'] == 0 ? '0' : $_SESSION['valuvalyut']) ; ?>">
<input style="width: 300px" class="site-url-address" type="hidden" value="<?PHP echo $site_url.$lng2; ?>">



<?PHP
$shop_type=1;
$prmenx='price_'.$shop_type;
$shmenx='shipping_'.$shop_type;
$prodid=$_GET['cname'];
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$userPr = $db->prepare('select * from user where id = ?');
@$userPr->execute([$_SESSION['id']]);
$user = $userPr->fetch(PDO::FETCH_ASSOC);
?>
<div class="middle">
    <div class="container">
        <?PHP echo @$_GET['page'] ?>
        <div class="page_title_wrapper">
            <div class="page_title"><?PHP echo $signup['product'][$lng] ?></div>
        </div>
        <div class="middle_content clearfix">
            <input type="hidden" class="js-limit" value="<?php echo checkRpCount($db,$prodid) ?>">
            <?PHP
            if(@$emailErr>=1)
            {
                echo $emailErr;
                ?>
                <div class="order_form user_settings">
                    <div class="form_item" style="text-align:center;">
                        <h3 style="text-align:center;">
                            <?PHP echo $emailErrMsg; ?>
                        </h3>
                    </div>
                    <br>
                    <div style="text-align:center;">
                        <Div style="min-height: 48px;    -webkit-box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);    background: #43b9da;
	text-shadow: 0 1px 1px rgba(0, 0, 0, 0.15);  cursor:pointer;  font-size: 24px;    font-weight: 300;    border: none;    width: 270px;    color: #fff; padding:7px;  line-height: 30px; margin:0px auto;" id="backBtn">
                            <?PHP echo $lostpassword['backbtn2'][$lng]; ?>
                        </div>
                    </div>
                </div>
                <?PHP
            }
            else
            {
                ?>
                <div class="left_sidebar">
                    <div class="block_products_sidebar">
                        <div class="block_content">
                            <?PHP
                            $lng1sor=$db->prepare('SELECT * FROM kateqoriyalar where s_id="0" and l_id=:lid  order by ordering asc  ');
                            $lng1sor->execute(array('lid'=>$lng1));
                            $lng1count=$lng1sor->rowCount();
                            $record=0;
                            while ($lng1cek=$lng1sor->fetch(PDO::FETCH_ASSOC))
                            {
                                $record++;
                                ?>
                                <div class="col col_<?PHP echo $record; ?>">
                                    <div class="image"><a href="<?PHP echo $site_url.$lng.'/shop/'.$lng1cek['kat_id'].'/'; ?>"><img src="<?PHP echo $site_url; ?>cms/images/<?PHP echo  $lng1cek['picture']; ?>" alt="<?PHP echo  $lng1cek['name']; ?>"></a></div>
                                    <div class="title"><div  class="field_content" ><a href="<?PHP echo $site_url.$lng.'/shop/'.$lng1cek['kat_id'].'/'; ?>"><?PHP echo  $lng1cek['name']; ?></a></div></div>
                                </div>
                                <?PHP
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?PHP



                // mehsulu secirik******************************************************************************************
                $lng01sor=$db->prepare('SELECT * FROM mehsul where s_id="1" and l_id=:lid and u_id=:uid  limit 1  ');
                $lng01sor->execute(array('lid'=>$lng1 , 'uid'=>s($_GET['cname'])));
                $products=ARRAY(); //Butun productlar bu massive yigilacaq
                $prodid_arr=ARRAY(); //produkt idlerini bir massive yigiriq
                while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC))
                {
                    $proid=$b['u_id'];
                    $products[$proid]=$b;
                    $prodid_arr[]=$proid;
                    $products[$proid]['currid']=1;
                }
                //*******************************************************************************************************************************

                if(@$_SESSION['id'])
                {
                    //Secilmish olke ucun olan xususi qiymetleri cixardiriq****************************************************************************
                    $lng01sor=$db->prepare('SELECT mop.*, c.short_name, c.u_id as currid FROM mehsul_olke_price mop , currency c, olkeler o where  mop.o_u_id= :olke and mop.m_u_id=:uid and o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang');
                    $lng01sor->execute(array( 'olke'=>$_SESSION['country'], 'lang'=>$lng1, 'uid'=>s($_GET['cname']) ));
                    while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC))
                    {
                        $proid=$b['m_u_id'];
                        if($products[$proid])
                        {
                            $products[$proid]['price_1']=$b['price_1'];
                            $products[$proid]['price_2']=$b['price_2'];
                            $products[$proid]['price_3']=$b['price_3'];
                            $products[$proid]['shipping_1']=$b['shipping_1'];
                            $products[$proid]['shipping_2']=$b['shipping_2'];
                            $products[$proid]['shipping_3']=$b['shipping_3'];
                            $products[$proid]['countryid']=$_SESSION['country'];
                            $products[$proid]['currid']=$b['currid'];
                            $products[$proid]['short_name']=$b['short_name'];
                        }
                    }
                    $_SESSION['valuvalyut']=$b['short_name'];
                    //*********************************************************************************************************************************
                }

                //EGER discount varsa onu da hesablayib elave edirik*******************************************************************************
                $lng01sor=$db->prepare('SELECT md.*, mop.o_u_id FROM mehsul_discount md, mehsul_olke_price mop where  md.m_u_id="'.s($_GET['cname']).'" and md.s_id=1 and md.shop_type=:shop_type and (md.mop_id=0 or (md.mop_id=mop.id and mop.o_u_id=:country and mop.m_u_id=md.m_u_id)) group by md.id');
                $lng01sor->execute(array( 'country'=>@(int)$_SESSION['country'], 'shop_type'=>$shop_type ));
                while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC))
                {
                    $proid=$b['m_u_id'];
                    if(@$products[$proid] and (@$products[$proid]['countryid']==$b['o_u_id'] or (@!$products[$proid]['countryid'] and $b['mop_id']=0)))
                    {
                        $prname='price_'.$shop_type;	//hansi qiymete endirim edeceyimizi tapiriq
                        if($b['type']==1)//endirim tipine gore hesablama edim endirimli qiymeti elave edirik
                        {
                            $priced=ceil($products[$proid][$prname]*(100-$b['value'])/100);
                        }
                        else
                        {
                            $priced=$products[$proid][$prname]-$b['value'];
                        }
                        //massive melumatlari elave edirik
                        $products[$proid]['discount']=$b['value'];
                        $products[$proid]['disc_price']=$priced;
                    }
                }
                //*********************************************************************************************************************************
                if(@$_SESSION['id'])
                {
                    //Butun mehsul qiymetlerini secilmish olkenin currency-sine ceviririk***************************************************************
                    $lng01sor=$db->prepare('SELECT c.short_name, c.u_id as currid FROM  currency c, olkeler o where  o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang');
                    $lng01sor->execute(array( 'olke'=>$_SESSION['country'], 'lang'=>$lng1 ));
                    $bi=$lng01sor->fetch(PDO::FETCH_ASSOC);


                    $_SESSION['countrycurrency']=$bi['currid'];
                    //butun currency rates secilib arraya salinir******************************
                    $lng01sor=$db->prepare('SELECT * FROM  currency_rates');
                    $lng01sor->execute();
                    $cr=ARRAY();
                    while($bcr=$lng01sor->fetch(PDO::FETCH_ASSOC))
                    {
                        $crid=$bcr['id'];
                        $cr[$crid]=$bcr;
                    }
                    //*************************************************************************

                    foreach ($products as $key => $val)
                    {
                        if(@$products[$key]['countryid']) // eger country id varsa problem yoxdur
                        {
                        }
                        else //yoxdursa qiymetler konvert olunmalidir
                        {

                            if($products[$key]['currid']==$bi['currid'])//eger hal hazir ki valyuta novu secilmish olke ile eynidirse hecne etmirik
                            {
                            }
                            else //eger ferqlidirse qiymet hesablanir. ve valyuta novu elave olunur
                            {
                                $t1=$products[$key]['currid'];
                                $t2=$bi['currid'];
                                $prname='price_'.$shop_type;
                                $shname='shipping_'.$shop_type;
                                $products[$key][$prname]=currconverter($db,$products[$key][$prname],$t1,$t2);//price hesablanir
                                $products[$key][$shname]=currconverter($db,$products[$key][$shname],$t1,$t2);//shipping hesablanir
                                if(@$products[$key]['disc_price'])//eger discount varsa o da hesablanir
                                {
                                    $products[$key]['disc_price']=currconverter($db,$products[$key]['disc_price'],$t1,$t2); //price hesablanir
                                }
                                $products[$key]['countryid']=$_SESSION['country'];
                                $products[$key]['currid']=$bi['currid'];
                                $products[$key]['short_name']=$bi['short_name'];
                            }
                        }
                    }
                    //**********************************************************************************************************************************
                }
                $decods=0;
                ?>
                <div class="page_content node_goods">
                    <h1 class="node_title"><?PHP echo $products[$prodid]['name']; ?></h1>
                    <div class="node_top clearfix">
                        <div class="node_field article">
						<span class="label"><img src="<?PHP echo $site_url?>user/images/barcode.png" style="width: 15px;
						margin-right: 5px; vertical-align: middle;"><?php echo $shopdetail['artikul'][$lng] ?></span>
                            <span class="field_content"><?php echo $products[$prodid]['track_code']; ?></span>
                        </div>
                        <?PHP
						 
                        if(checkRpCount($db,$prodid)>0)
                        {
                            ?>
                            <div class="node_field available">
                                <span class="field_content"><?PHP echo $shopdetail['available'][$lng] ?></span>
                            </div>
                            <?PHP
                        }
                        else
                        {
                            ?>
                            <div class="node_field notavailable">
                                <?PHP echo $shopdetail['notavailable'][$lng] ?></span>
                            </div>
                            <?PHP
                        }
                        if(@$_SESSION['id'])
                        {
                            ?>

                            <div class="node_field article">
                                <span class="label"><?PHP echo $shopdetail['regtype'][$lng] ?>:</span>
                                <span class="field_content"><?PHP echo $products[$prodid]['point']; ?> <?PHP echo $shopdetail['point'][$lng] ?></span>
                            </div>
                            <?PHP
                        }
                        $comments_number=$db->prepare('select * from comment where product_id = ? order by date desc');
                        $comments_number->execute([$prodid]);
                        $count = $comments_number->rowCount();
                        ?>
                        <div class="node_field reviews_count">
                            <span class="label"><?PHP echo $shopdetail['review'][$lng] ?>:</span>
                            <span class="field_content"><?PHP echo $count; ?></span>
                        </div>
                    </div>
                    <div class="node_main_wrap clearfix smcs" >
                        <div class="image_wrapper">
                            <div class="main_images">
                                <?PHP
                                $lng10sor=$db->prepare('SELECT * FROM product_gallery where product_id = ? order by ordering asc limit 1');
                                $lng10sor->execute([$_GET['cname']]);
                                $lng10count=$lng10sor->rowCount();
                                $record=0;
                                while ($lng10cek=$lng10sor->fetch(PDO::FETCH_ASSOC))
                                {
                                    ?>
                                    <div class="image">
                                        <a href="#">
                                            <img class="otk" style="max-width:570px; max-height:375px;" src="<?PHP echo $site_url; ?>cms/images/<?PHP echo  $lng10cek['image']; ?>" alt="<?PHP echo $lng10cek['alt'] ?>" >
                                        </a>
                                    </div>
                                    <?PHP
                                }
                                ?>
                            </div>
                            <div class="thumb_images">
                                <?PHP
                               
                                $query = $db->prepare('SELECT * FROM product_gallery where product_id = ? order by ordering asc');
                                $query->execute([$_GET['cname']]);
                                while ($image=$query->fetch(PDO::FETCH_ASSOC))
                                {
                                    ?>
                                    <div class="image">
                                        <div class="field_content">
                                            <img class="alt_img" src="<?PHP echo $site_url; ?>cms/images/<?PHP echo  $image['image']; ?>" alt="<?PHP echo $image['image']; ?>">
                                        </div>
                                    </div>
                                    <?PHP
                                }
                                ?>
                            </div>
                        </div>
                        <div class="price_wrapper">

                            <?PHP
                            if(@$_SESSION['id'])
                            {
                                if(@$products[$prodid]['countryid'])
                                {
                                    $short_name=$products[$prodid]['short_name'];
                                }
                                else
                                {
                                    $short_name='USD';
                                }
                                $tt='price_'.$shop_type;
                                if(@$products[$prodid]['discount'])
                                {
                                    $price_real=$products[$prodid]['disc_price'];
                                    echo'<div class="old_price" ">'.$products[$prodid][$prmenx].' '.$short_name.' </div><div class="price">'.$products[$prodid]['disc_price'].' '.$short_name.'<span></span></div>';
                                }
                                else
                                {
                                    $price_real=$products[$prodid][$tt];
                                    echo'<div class="price">'.$products[$prodid][$prmenx].' '.$short_name.'<span></span></div>';
                                }
                                ?>
                                <div class="good_basket clearfix">
                                    <div class="good_basket_btns clearfix">
                                        <div class="good_basket_min">Минус</div>
                                        <input type="text" class="good_basket_input form_text" id="tnt" disabled value="1" />
                                        <div class="good_basket_plus">Плюс</div>
                                    </div>


								<?PHP
								 if(checkRpCount($db,$prodid)>0)
									{
										?>
										<div class="good_basket_add">
                                        <input style="border: none;" type="button"
                                               value='<?PHP echo $shopdetail['buy'][$lng] ?>'
                                               data-text="Add To Cart"
                                               class="addtocart add_to_basket"
                                               onclick="add1(<?PHP echo $products[$prodid]['u_id'];  ?>)"
                                               id="<?PHP echo $products[$prodid]['u_id'] ;  ?>"
                                               data-name="<?PHP echo $products[$prodid]['name'] ;  ?>"
                                               data-ship="<?PHP echo $products[$prodid]['shipping_1'] ;?>"
                                               data-price="<?PHP echo $price_real ;  ?>"
                                               data-img="<?PHP echo $products[$prodid]['image_url'] ;  ?>"
                                               data-currency="<?PHP echo $short_name ;  ?>"
                                               data-shoptype="<?PHP echo $shop_type ;  ?>"
                                               data-currencyid="<?PHP echo $products[$prodid]['currid'] ;?>" />
										</div>
										<?PHP
									}
									else
									{
										?>
										<div class="good_basket_add">
											<input style="border: none;" type="button" value='<?PHP echo $shopdetail['oostock'][$lng] ?>' />
										</div>
										<?PHP
									}
								?>
                                    
                                </div>
                                <div class="one_click"><!-- Buy in one click --></div>
                                <?PHP
                            }
                            else
                            {
                                ?>
                                <div class="good_basket clearfix">
                                    <div class="good_basket_btns clearfix">
                                        <div class="good_basket_min">Минус</div>
                                        <input type="text" class="good_basket_input form_text" id="tnt" disabled value="1" />
                                        <div class="good_basket_plus">Плюс</div>
                                    </div>
                                    <div class="good_basket_add">
                                        <input style="border: none;" type="button"
                                               value='<?PHP echo $shopdetail['buy'][$lng] ?>'
                                               data-text="Add To Cart"
                                               class="addtocart add_to_basket"
                                               onclick="location.replace('<?PHP echo $site_url.$lng.'/sign-up/'?>')"
                                               id="<?PHP echo $products[$prodid]['u_id'] ;  ?>"
                                        />
                                    </div>
                                </div>


                                <div class="one_click"><!-- Купить в один клик --></div>
                                <?PHP
                            }
                            ?>
                            <div class="short_desc">
                                <?PHP echo $products[$prodid]['description2']; ?>
                            </div>
                            <?PHP
                            if(@$_SESSION['id'])
                            {
                                if(@$products[$prodid]['ferq'])
                                {
                                    ?>
                                    <div class="countdown_block">
                                        <div class="block_content">
                                            <div class="time_wrap">
                                                <div class="time_title"><?PHP echo $shopdetail['discountend'][$lng];?></div>
                                                <?PHP
                                                //zaman milli saniye ile hesablanir.
                                                //aksiyanin bitmesine nece gun qaldigini hesablayib onu milli saniyeye cevirib bura yazmaliyiq
                                                ?>
                                                <div class="countdown_origin" data-time="<?PHP echo $products[$prodid]['ferq']; ?>">
                                                    <div class="countdown_layout">
											<span class="tim">
												<span class="digit_group digit_group_1">
													<span class="digit count{d10}">{d10}</span>
													<span class="digit count{d1}">{d1}</span>
												</span>
											    <span class="digit_Sep"></span>
												<span class="digit_group">
													<span class="digit count{h10}">{h10}</span>
													<span class="digit count{h1}">{h1}</span>
												</span>
											    <span class="digit_Sep"></span>
												<span class="digit_group">
													<span class="digit count{m10}">{m10}</span>
													<span class="digit count{m1}">{m1}</span>
												</span>
											    <span class="digit_Sep"></span>
												<span class="digit_group last">
													<span class="digit count{s10}">{s10}</span>
													<span class="digit count{s1}">{s1}</span>
												</span>
											</span>
                                                        <span class="text">
											    <span class="day_text time_text">{dl}</span>
											    <span class="hour_text time_text">{hl}</span>
											    <span class="min_text time_text">{ml}</span>
											    <span class="sec_text time_text">{sl}</span>
											</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?PHP
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="description_wrap clearfix node_item">
                        <div class="label">
                            <div class="text"><?PHP echo $shopdetail['descriptionprod'][$lng];?></div>
                        </div>
                        <div class="field_content">
                            <h2><?PHP echo $products[$prodid]['youtube_title']?></h2>
                            <div class="video"><iframe src="<?PHP echo $products[$prodid]['youtube']?>" allowfullscreen></iframe></div>
                            <div class="main_text">
                                <?PHP echo $products[$prodid]['description3']?>
                            </div>
                        </div>
                    </div>
                    <?PHP
                    $product_details = $db->prepare('select * from product_details where product_id = ? and l_id = ?');
                    $product_details->execute([$_GET['cname'],$lng1]);
                    if($product_details->rowCount() > 0)
                    {
                        ?>
                        <div class="chars_wrap clearfix node_item">
                            <div class="label"><?PHP echo $shopdetail['proddetails'][$lng];?></div>
                            <div class="field_content">
                                <?PHP
                                while($detail = $product_details->fetch(PDO::FETCH_ASSOC))
                                {
                                    ?>
                                    <div class="char_content clearfix">
                                        <div class="char_1"><span><?PHP echo $detail['title'] ?></span></div>
                                        <div class="char_2"><?PHP echo $detail['description'] ?></div>
                                    </div>
                                    <?PHP
                                }
                                ?>
                            </div>
                        </div>
                        <?PHP
                    }
                    ?>
                    <div class="reviews_wrap clearfix node_item">
                        <div class="label">
                            <div class="text"><?PHP echo $shopdetail['reviews'][$lng];?></div>
                            <?PHP
                            if(@$_SESSION['login']!='' and @$_SESSION['x_ps']!='' )
                            {
                                ?>
                                <div class="add_reviews"><?PHP echo $shopdetail['addreview'][$lng];?></div>
                                <?PHP
                            }
                            ?>
                        </div>
                        <div class="comment_field" style="margin-top:100px;margin-bottom:35px; display:none;">
                            <form method="post">
                                <textarea class="form-control" name="comment_text" required></textarea>
                                <input id="comment_btn" name="comment_btn"  type="submit" value="Publish">
                            </form>
                        </div>
                        <div class="field_content comment_field_content">
                            <?PHP
                            $comments=$db->prepare('select * from comment where product_id = ? order by date desc limit 4');
                            $comments->execute([$_GET['cname']]);
                            if($comments->rowCount() > 0)
                            {
                                $n=0;
                                while($comment = $comments->fetch(PDO::FETCH_ASSOC))
                                {
                                    $n++;
                                    $comment_user = $db->prepare('select * from user where id = ?');
                                    $comment_user->execute([$comment['user_id']]);
                                    $cmmnt_user = $comment_user->fetch(PDO::FETCH_ASSOC);
                                    if($n<=3)
                                    {
                                        ?>
                                        <div class="review">
                                            <div class="name"><?PHP echo $cmmnt_user['ad'].' '.$cmmnt_user['soyad']  ?></div>
                                            <div class="date">
                                                <?PHP
                                                $dekar=substr($comment['date'], 5,2);
                                                echo substr($comment['date'], 8,2).' '.mounth($dekar,$lng1).' '.substr($comment['date'], 0,4).', '.substr($comment['date'], 10,6);
                                                ?>
                                            </div>
                                            <div class="review_body">
                                                <?PHP echo $comment['text'] ?>
                                            </div>
                                        </div>
                                        <?PHP
                                    }
                                }
                                if($comments->rowCount() > 3)
                                {
                                    ?>
                                    <div class="more_reviews"><?PHP echo $shopdetail['loadmore'][$lng];?></div>
                                    <?PHP
                                }
                            }
                            ?>
                        </div>
                    </div>

                  <!--  <script>
                        var limit = 6;
                        $('body').on('click','.more_reviews',function(){
                            var u_id = <?PHP /*echo $_GET['cname'] */?>;

                            $.post("<?PHP /*echo $site_url */?>include/shop/comment.php", {suggest: u_id,limit: limit}, function(result){
                                //  alert(result);
                                $('.comment_field_content').html(result);
                                limit+=3;
                            });
                        });
                    </script>-->

                    <div class="block_goods similar_goods">
                        <div class="block_title"><?PHP echo $shopdetail['similarprod'][$lng];?></div>
                        <div class="block_content">
                            <?PHP
                            $lng011sor=$db->prepare('SELECT * FROM mehsul where s_id="1" and l_id=:lid  and all_country="1" and u_id!="'.$prodid.'" order by rand() limit 3  ');
                            $lng011sor->execute(array('lid'=>$lng1));
                            $products=ARRAY(); //Butun productlar bu massive yigilacaq
                            $prodid_arr=ARRAY(); //produkt idlerini bir massive yigiriq
                            while ($b=$lng011sor->fetch(PDO::FETCH_ASSOC))
                            {
                                $proid=$b['u_id'];
                                $products[$proid]=$b;
                                $prodid_arr[]=$proid;
                                $products[$proid]['currid']=1;
                                $products[$proid]['short_name']='USD';

                            }
                            //*******************************************************************************************************************************

                            $muidstr=implode(',',$prodid_arr);
                            // Secilmish olkeye aid olan mehsullar secilir***********************************************************************************
                            $lng01sor=$db->prepare('SELECT m.* FROM mehsul m, mehsul_olke mo where m.s_id="1" and m.l_id=:lid and m.u_id=mo.m_u_id and mo.o_u_id= :olke and m.u_id in ('.$muidstr.') order by m.ordering asc  ');
                            $lng01sor->execute(array('lid'=>$lng1 , 'olke'=>$_SESSION['country'] ));
                            while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC))
                            {
                                $proid=$b['u_id'];
                                $products[$proid]=$b;
                                $prodid_arr[]=$proid;
                                $products[$proid]['currid']=1;
                            }

                            //*********************************************************************************************************************************

                            //Secilmish olke ucun olan xususi qiymetleri cixardiriq****************************************************************************

                            $lng01sor=$db->prepare('SELECT mop.*, c.short_name, c.u_id as currid FROM mehsul_olke_price mop , currency c, olkeler o where  mop.o_u_id= :olke and o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang and mop.m_u_id in ('.$muidstr.')');
                            $lng01sor->execute(array( 'olke'=>$_SESSION['country'], 'lang'=>$lng1 ));
                            while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC))
                            {
                                $proid=$b['m_u_id'];
                                if($products[$proid])
                                {
                                    $products[$proid]['price_1']=$b['price_1'];
                                    $products[$proid]['price_2']=$b['price_2'];
                                    $products[$proid]['price_3']=$b['price_3'];
                                    $products[$proid]['shipping_1']=$b['shipping_1'];
                                    $products[$proid]['shipping_2']=$b['shipping_2'];
                                    $products[$proid]['shipping_3']=$b['shipping_3'];
                                    $products[$proid]['countryid']=$_SESSION['country'];
                                    $products[$proid]['currid']=$b['currid'];
                                    $products[$proid]['short_name']=$b['short_name'];
                                }
                            }
                            //*********************************************************************************************************************************

                            //EGER discount varsa onu da hesablayib elave edirik*******************************************************************************
                            $lng01sor=$db->prepare('SELECT md.*, mop.o_u_id FROM mehsul_discount md, mehsul_olke_price mop where  md.m_u_id in ('.$muidstr.') and md.s_id=1 and md.shop_type=:shop_type and (md.mop_id=0 or (md.mop_id=mop.id and mop.o_u_id=:country and mop.m_u_id=md.m_u_id)) group by md.id');
                            $lng01sor->execute(array( 'country'=>$_SESSION['country'], 'shop_type'=>$shop_type ));
                            while ($b=$lng01sor->fetch(PDO::FETCH_ASSOC))
                            {
                                $proid=$b['m_u_id'];
                                if(@$products[$proid] and (@$products[$proid]['countryid']==$b['o_u_id'] or (@!$products[$proid]['countryid'] and @$b['mop_id']=0)))
                                {
                                    $prname='price_'.$shop_type;	//hansi qiymete endirim edeceyimizi tapiriq
                                    if($b['type']==1)//endirim tipine gore hesablama edim endirimli qiymeti elave edirik
                                    {
                                        $priced=ceil($products[$proid][$prname]*(100-$b['value'])/100);
                                    }
                                    else
                                    {
                                        $priced=$products[$proid][$prname]-$b['value'];
                                    }
                                    //massive melumatlari elave edirik

                                    $products[$proid]['discount']=$b['value'];
                                    $products[$proid]['disc_price']=$priced;
                                }
                            }
                            //*********************************************************************************************************************************


                            //Butun mehsul qiymetlerini secilmish olkenin currency-sine ceviririk***************************************************************
                            $lng01sor=$db->prepare('SELECT c.short_name, c.u_id as currid FROM  currency c, olkeler o where  o.kat_id=:olke and o.currency_id=c.u_id and o.l_id=:lang and c.l_id=:lang');
                            $lng01sor->execute(array( 'olke'=>$_SESSION['country'], 'lang'=>$lng1 ));
                            $bi=$lng01sor->fetch(PDO::FETCH_ASSOC);


                            //butun currency rates secilib arraya salinir******************************
                            $lng01sor=$db->prepare('SELECT * FROM  currency_rates');

                            $lng01sor->execute();
                            $cr=ARRAY();
                            while($bcr=$lng01sor->fetch(PDO::FETCH_ASSOC))
                            {
                                $crid=$bcr['id'];
                                $cr[$crid]=$bcr;
                            }
                            //*************************************************************************



                            foreach ($products as $key => $val)
                            {
                                if(@$products[$key]['countryid']) // eger country id varsa problem yoxdur
                                {
                                }
                                else //yoxdursa qiymetler konvert olunmalidir
                                {
                                    if($products[$key]['currid']==$bi['currid'])//eger hal hazir ki valyuta novu secilmish olke ile eynidirse hecne etmirik
                                    {
                                    }
                                    else //eger ferqlidirse qiymet hesablanir. ve valyuta novu elave olunur
                                    {

                                        $t1=$products[$key]['currid'];
                                        $t2=$bi['currid'];
                                        $prname='price_'.$shop_type;
                                        $shname='shipping_'.$shop_type;
                                        $products[$key][$prname]=currconverter($db,$products[$key][$prname],$t1,$t2);//price hesablanir
                                        $products[$key][$shname]=currconverter($db,$products[$key][$shname],$t1,$t2);//shipping hesablanir

                                        if(@$products[$key]['disc_price'])//eger discount varsa o da hesablanir
                                        {
                                            $products[$key]['disc_price']=currconverter($db,$products[$key]['disc_price'],$t1,$t2); //price hesablanir
                                        }
                                        $products[$key]['countryid']=$_SESSION['country'];
                                        $products[$key]['currid']=$bi['currid'];
                                        $products[$key]['short_name']=$bi['short_name'];
                                    }
                                }
                            }
                            //**********************************************************************************************************************************
                            $disad=0;
                            foreach($products as $keyp=>$valuep)
                            {
                                $disad++;
                                echo'<div class="col col_'.$disad.'">
							<div class="image">';
                                if(@$_SESSION['id'])
                                {
                                    echo '<a href="'.$site_url.$lng.'/shop/1/'.$products[$keyp]['u_id'].'/">';
                                }
                                echo'	<div class="field_content"><img src="'.$site_url.'cms/images/'.$products[$keyp]['image_url'].'" alt="'.$products[$keyp]['name'].'"></div>';
                                if(@$_SESSION['id'])
                                {
                                    echo '</a>';
                                }
                                echo'</div>
							<div class="title"><a href="'.$site_url.$lng.'/shop/1/'.$products[$keyp]['u_id'].'/">'.$products[$keyp]['name'].'</a></div>
							<div class="price_wrap">';
                                if(@$_SESSION['id'])
                                {
                                    if(@$products[$keyp]['discount'])
                                    {
                                        echo'
									<div class="old_price" style="text-decoration: none;">
										'.$products[$keyp][$prname].' '.$products[$keyp]['short_name'].'
									</div>
									<div class="price">									
										'.$products[$keyp]['disc_price'].' '.$products[$keyp]['short_name'].'
										<span></span>
									</div></div>';

                                    }
                                    else
                                    {
                                        echo'
									<div class="price">									
										'.$products[$keyp][$prmenx].' '.$products[$keyp]['short_name'].' 
										<span></span>
									</div></div>';
                                    }
                                    ?>
                                    <div class="add_to_basket">
									<?PHP
									if(checkRpCount($db,$products[$keyp]['u_id'])>0)
									{
									?>
                                        <input type="button"
                                               value='<?PHP echo $shopdetail['buy'][$lng]; ?>'
                                               data-text="Add To Cart"
                                               class="addtocart add_to_basket"
                                               onclick="add1(<?PHP echo $products[$keyp]['u_id'];  ?>)"
                                               id="<?PHP echo $products[$keyp]['u_id'] ;  ?>"
                                               data-name="<?PHP echo $products[$keyp]['name'] ;  ?>"
                                               data-ship="<?PHP echo $products[$keyp][$shmenx] ;  ?>"
                                               data-price="<?PHP if(@$products[$keyp]['discount']){echo $products[$keyp]['disc_price'] ;}else{echo $products[$keyp][$prmenx] ;}  ?>"
                                               data-img="<?PHP echo $products[$keyp]['image_url'] ;  ?>"
                                               data-currency="<?PHP echo $short_name ;  ?>"
                                               data-shoptype="<?PHP echo $shop_type ;  ?>"
                                               data-currencyid="<?PHP echo $products[$keyp]['currid'] ;?>"/>
									<?PHP
									}
									else
									{
									?>
										 <input type="button" value='<?PHP echo $shopdetail['oostock'][$lng]; ?>'/>
									<?PHP
									}
									?>
                                    </div>
                                    <?PHP
                                }
                                else
                                {
                                    echo'<div class="add_to_basket"><a href="'.$site_url.$lng.'/shop/1/'.$products[$keyp]['u_id'].'/'.'">'.$home_body['rmore'][$lng].'</a></div></div>';
                                }
                                echo'
					</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?PHP
            }
            ?>
        </div>
    </div>
</div>

<?php

if($_SESSION ['login'] ) {

    ?>
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
<?php
}
?>

<style>
    .foot {
        border-top: 5px solid #43b9da;
        position:fixed;
        width: 100%;
        z-index: 10000;
        text-align:center;
        height: 100px;
        font-size:18px;
        color: #000;
        background: #FFF;
        display: flex;
        justify-content: center; /* align horizontal */

        right: 0;
        left: 0;
        margin-right: auto;
        margin-left: auto;
        bottom: -1000px;
        font-size:14px;
        padding-top: 40px;
    }
    .slide-up {
        bottom: 0px !important;
    }

    .slide-down{
        bottom: -1000px !important;
    }

    .foot img{
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


<style>
    #comment_btn{
        border: 1px solid #43B9DA;
        color: #43B9DA;
        background-color:#fff;
        padding: 10px;
        box-shadow: 0 2px 2px rgba(15, 55, 66, 0.1);
    }
    #comment_btn:hover{
        background-color: #43B9DA;
        color:#fff;
    }
</style>
<?PHP
if(isset($_POST['comment_btn'])){
    $add_comment = $db->prepare('insert into comment set user_id = ?, product_id = ?, text = ?');
    $add_comment->execute([$user['id'],$_GET['cname'],$_POST['comment_text']]);
    header('Location: .');
}
?>
