<?PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<div class="slider-block"> 
    <div class="slider-header">

        <div class="slider-header__item">
            <img class="slider-header__img " data-lazy="./assets/image/gallery/gall1.jpg" alt="">
        </div>

        <div class="slider-header__item">
            <img class="slider-header__img " data-lazy="./assets/image/gallery/gall2.jpg" alt="">
        </div>

        <div class="slider-header__item">
            <img class="slider-header__img " data-lazy="./assets/image/gallery/gall3.jpg" alt="">
        </div>

    </div>

    <div class="slider-content">
        <h3 class="slider-content__head">WELCOME TO</h3>
        <h1 class="slider-content__title">CORPBOOT <span>TEMPLATE</span></h1>
        <p class="slider-content__lead">a bootstrap website template for business</p>
        <a href="" download class="slider-content__link"><i class="fas fa-download"></i>DOWNLOAD</a>
    </div>
</div>

<main>

    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 home-icon">
                    <i class="fas fa-chart-line "></i>
                    <div class="home-icon__content">
                        <h3 class="home-icon__title">Blazing Fast</h3>
                        <p class="home-icon__lead">Quisque eu ante at tortor imperdiet gravida nec sed turpis
                            phasellus.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 home-icon">
                    <i class="fas fa-chart-line "></i>
                    <div class="home-icon__content">
                        <h3 class="home-icon__title">Blazing Fast</h3>
                        <p class="home-icon__lead">Quisque eu ante at tortor imperdiet gravida nec sed turpis
                            phasellus.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 home-icon">
                    <i class="fas fa-chart-line "></i>
                    <div class="home-icon__content">
                        <h3 class="home-icon__title">Blazing Fast</h3>
                        <p class="home-icon__lead">Quisque eu ante at tortor imperdiet gravida nec sed turpis
                            phasellus.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 home-icon">
                    <i class="fas fa-chart-line "></i>
                    <div class="home-icon__content">
                        <h3 class="home-icon__title">Blazing Fast</h3>
                        <p class="home-icon__lead">Quisque eu ante at tortor imperdiet gravida nec sed turpis
                            phasellus.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block block--bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="position-relative">
                        <div class="title">
                            <h2 class="title-hr ">About Us</h2>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">


                    <div class="youtube" data-embed="tgbNymZ7vqY">
                        <div class="play-button"></div>
                    </div>


                    <!--      <div class="youtube-responsive">
                              <iframe width="560" height="315" src="https://www.youtube.com/embed/tgbNymZ7vqY"
                                      title="YouTube video player" frameborder="0"
                                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                      allowfullscreen></iframe>
                          </div>-->
                </div>

                <div class="col-lg-6">
                    <a href="" class="pic pic--mb">
                        <img class="pic__img" src="./assets/image/about-home.jpg" alt="">
                        <span class="pic__read">
                            <i class="fas fa-plus"></i>
                             Read more
                        </span>
                    </a>

                    <p class="lead-about">
                        <strong>Lorem ipsum</strong> dolor sit amet, consectetur adipiscing elit. Phasellus interdum
                        erat
                        libero, pulvinar tincidunt leo consectetur eget. Curabitur lacinia pellentesque tempor. Ut
                        euismod condimentum velit en gravida. Cras nec tellus eget urna facilisis scelerisque vitae et
                        sapien. Nulla vitae adipiscing nisi leo consectetur eget <a href="about.html">vitae et
                        sapien</a>.
                    </p>

                </div>

            </div>
        </div>

    </div>

    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-12 ">

                    <div class="title title--right">
                        <h2 class="title-hr-after ">LATEST NEWS</h2>
                    </div>
                </div>


                <div class="col-12 pd-0">
                    <div class="slider-news">
					
						 
					<?php	
						$blog_sql = $db->prepare('SELECT * FROM announcement_content WHERE s_id is NULL and l_id="' . $lng1 . '" ORDER BY date ');
						$blog_sql->execute();
							while($b=$blog_sql->fetch(PDO::ASSOC_FETCH)){			
						
									echo '<div class="news">
										<a href="" class="pic pic--mb">
											<img class="pic__img height-auto" src="./assets/image/pic.jpg" alt="">
											<span class="pic__read">
										<i class="fas fa-plus"></i>
										 Read more
									</span>
										</a>
										<a href="" class="news__link">
											Template built with Twitter Bootstrap and Sass
										</a>
										<p class="news__lead">
											'.$b['text'].'
										</p>
										<div class="news__author">
											<i class="fas fa-calendar-alt"></i>
											<span>
											'.$b['date'].'
											</span>
										</div>
								</div>';
							}
					?>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="block block--bg-img">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="title-h1 title-h1--mr">A CLEAN TEMPLATE FOR CORPORATE WEBSITES</h1>
                </div>

                <div class="col-12">
                    <p class="lead lead--info">Quisque eu ante at tortor imperdiet gravida nec sed turpis phasellus
                        augue augue.</p>
                </div>

                <div class="col-12 text-center">
                    <a href="" class="btn-buy">
                        <i class="fas fa-shopping-cart"></i>
                        Buy now with PayPal!
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-12 ">

                    <div class="title ">
                        <h2 class="title-hr">OUR CLIENTS</h2>
                    </div>
                </div>


                <div class="col-12 pd-0">
                    <div class="slider-client">

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo1.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo2.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo3.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo4.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo5.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo6.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo1.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo2.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo3.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo4.png" alt="">
                        </div>

                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo5.png" alt="">
                        </div>


                        <div class="client">
                            <img class="client__img" data-lazy="./assets/image/client/logo6.png" alt="">
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>

</main>