import $ from "jquery";
import 'slick-carousel'

$(document).ready(function () {

    $('.slider-header').slick({
        infinite: true,
        slidesToShow: 1,
        dots: false,
        autoplay: true,
        lazyLoad: 'ondemand',
        autoplaySpeed: 3000,
        adaptiveHeight: true,
        mobileFirst: true,
        arrows: false,
        cssEase: 'linear',
        fade: true,
    });

    $('.slider-news').slick({
        infinite: true,
        slidesToShow: 3,
        dots: true,
        // autoplay: true,
        lazyLoad: 'ondemand',
        autoplaySpeed: 3000,
        adaptiveHeight: true,
        mobileFirst: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 0,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });

    $('.slider-client').slick({
        infinite: true,
        slidesToShow: 6,
        dots: false,
        autoplay: true,
        lazyLoad: 'ondemand',
        autoplaySpeed: 3000,
        // adaptiveHeight: true,
        mobileFirst: true,
        arrows: true,

        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 6,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 0,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                }
            }
        ]
    });

    $('.slider-team').slick({
        // infinite: true,
        slidesToShow: 1,
        dots: true,
        // autoplay: true,
        // lazyLoad: 'ondemand',
        // autoplaySpeed: 3000,
        // adaptiveHeight: true,
        // mobileFirst: true,
        // arrows: false,

    });

    $('.eventPrevent').click(function (e) {
        e.preventDefault();
    });

    $('.mob-menu').click(function () {
        $('.menu').slideToggle()
    });

    /////// navbar menu


    $('nav ul li a:not(:only-child)').click(function (e) {
        $(this).siblings('.nav-dropdown').toggle();
        // Close one dropdown when selecting another
        $('.nav-dropdown').not($(this).siblings()).hide();
        e.stopPropagation();
    });
    // Clicking away from dropdown will remove the dropdown class
    $('html').click(function () {
        $('.nav-dropdown').hide();
    });
    // Toggle open and close nav styles on click
    $('#nav-toggle').click(function () {
        $('nav ul').slideToggle();
    });
    // Hamburger to X toggle
    $('#nav-toggle').on('click', function () {
        this.classList.toggle('active');
    });


    // breadcrumb

    $('.breadcrumb__link.active').click(function (e) {
        e.preventDefault();
    });


    //// news headline height

    let heightNews = document.getElementsByClassName('js-heightNews');
    let heightLink = 20;

    if (window.innerWidth > 767) {
        for (let i = 0; i < heightNews.length; i++) {
            if (heightNews[i].offsetHeight > heightLink) {
                heightLink = heightNews[i].offsetHeight;
            }
        }
    }

    $('.news .js-heightNews').height(heightLink);

    //// count animation

/*    $('.count').each(function () {

        $(this).prop('counter', 0).animate({
            counter: $(this).text()
        }, {
            duration: 3000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });*/


    /// tab


    $('ul.tabs li').click(function(){
        var tab_class = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("."+tab_class).addClass('current');
    })


});


