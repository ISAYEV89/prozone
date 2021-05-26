<?php 
$contq=$db->prepare('SELECT * from blog_content where l_id=:lis and url_tag=:ut ');
$contq->execute(array('lis'=>$lng1 , 'ut'=>s($_GET['cat']) ));
$contf=$contq->fetch(PDO::FETCH_ASSOC);

?>
<main class="site-main">
    <div class="header-bg"></div>
    <div class="news-item-grid middle-container">
        <div class="news-item__header">
            <span class="news-item__heading"> <?php echo $contf['name'];  ?></span>
            <span class="news-item__subheading"> <?php echo $contf['stitle'];  ?></span>
        </div>            
        <div class="news-item__text">
            <?php echo $contf['text'];  ?>
<!--             <span class="news-item__date">10.07.2018</span> -->
        </div>
    </div>     
    <section class="call-to-share">
       <div class="call-to-share-wrapper middle-container">
          <span class="call-to-share__heading">Понравилось качество этого сервиса?  Ставь лайк</span>
          <script type="text/javascript" async="" src="./Команда «Автотранс» победила на третьем этапе национальных автогонок «LTAVA ATTACK SERIES&#39;18»._files/watch.js.download"></script>
          <script async="" src="./Команда «Автотранс» победила на третьем этапе национальных автогонок «LTAVA ATTACK SERIES&#39;18»._files/loader_4_59fkps.js.download"></script>
          <script id="facebook-jssdk" src="./Команда «Автотранс» победила на третьем этапе национальных автогонок «LTAVA ATTACK SERIES&#39;18»._files/sdk.js.download"></script>
          <script type="text/javascript">
            (function() {
                if (window.pluso)if (typeof window.pluso.start == "function") return;
                if (window.ifpluso==undefined) { window.ifpluso = 1;
                    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                    var h=d[g]('body')[0];
                    h.appendChild(s);
                }})();
            </script>
            <div class="pluso__wrapper">
                <div data-background="transparent" data-options="medium,square,line,horizontal,counter,theme=04" data-services="facebook,twitter,google" class="pluso"><div class="pluso-010010011001-04"><span class="pluso-wrap" style="background:transparent"><a href="https://gboukraine.com/ru/news/komanda-avtotrans-pobedila-na-tretem-etape-natsionalnykh-avtogonok-ltava-attack-series18" title="Facebook" class="pluso-facebook"></a><a href="https://gboukraine.com/ru/news/komanda-avtotrans-pobedila-na-tretem-etape-natsionalnykh-avtogonok-ltava-attack-series18" title="Twitter" class="pluso-twitter"></a><a href="https://gboukraine.com/ru/news/komanda-avtotrans-pobedila-na-tretem-etape-natsionalnykh-avtogonok-ltava-attack-series18" title="Google+" class="pluso-google"></a><a href="https://pluso.ru/" class="pluso-more"></a></span><span class="pluso-counter"><b title="0">0</b></span></div></div>
            </div>
        </div>
    </section>
    <div class="news-related-news">
        <div class="news-grid-wrapper middle-container">
            <?php 
            $xamseq=$db->prepare('SELECT * FROM blog_content where l_id=? and s_id is NULL order by u_id desc limit 2 ');
            $xamseq->execute([$lng1]);
            while($xamsef=$xamseq->fetch(PDO::FETCH_ASSOC))
            {
            ?>  

                <div class="news-card">
                    <a class="news-card__img" href="<?php echo $site_url.$lng.'/news/'.$xamsef['url_tag'].'/' ?>">
                       <img src="<?php echo $site_url.'cms/images/'.$xamsef['picture']; ?>" srcset="<?php echo $site_url.'cms/images/'.$xamsef['picture']; ?> 1x, <?php echo $site_url.'cms/images/'.$xamsef['picture']; ?> 2x" width="290" height="250">
                    </a>
                    <div class="news-card__text">
                        <a class="news-card__heading" href="<?php echo $site_url.$lng.'/news/'.$xamsef['url_tag'].'/' ?>">
                            <span class="news-card__heading-text"><?php echo $xamsef['name'] ?></span>
                        </a>
                        <span class="news-card__excerpt">​
                            <?php echo $xamsef['stitle'] ?>
                        </span>
                        <div class="news-card__bottom">
                            <span class="news-card__date">
                                <i></i>
                                <b><?php echo $xamsef['date'] ?></b>
                            </span>
                            <a class="news-card__link arrow-right-link" href="<?php echo $site_url.$lng.'/news/'.$xamsef['url_tag'].'/' ?>">
                                <span>подробнее</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="26" viewBox="0 0 15 26">
                                    <path fill="#fff" d="M14.46 14.29L3.15 25.47a1.87 1.87 0 0 1-2.61 0 1.81 1.81 0 0 1 0-2.58l10-9.89-10-9.89a1.81 1.81 0 0 1 0-2.58 1.87 1.87 0 0 1 2.61 0l11.31 11.18a1.81 1.81 0 0 1 0 2.58z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
            }
            ?>
        </div>
    </div>
</main>