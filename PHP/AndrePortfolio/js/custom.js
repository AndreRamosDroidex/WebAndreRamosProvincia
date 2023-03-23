/*
 Template Name: Falix Ford
 File Name: custom.js
 Author Name: ThemeVault
 Author URI: http://www.themevault.net/
 License URI: http://www.themevault.net/license/
 */

jQuery(document).ready(function ($) {
    //typer();
    //Portfolio Modal
    $('.tv-open-popup-page').on('click', function () {
        if($('.content-blocks.popup').length == 0) {
            return;
        }
        var projectUrl = $(this).data("id");
        var portfolioDiv = $('#portfolio-' + projectUrl);
        $('.tv-top-fix-menu').removeClass('showx');
        $('.sidebar-menu').addClass('hidex');
        $('.content-blocks.popup').addClass('showx');
        $('.content-blocks.popup section').html(portfolioDiv.html())
        return false;
    });
    // Blog Model
    $('.tv-open-blog, .blogpost a').on('click', function () {
        var projectUrl = $(this).attr("href");
        if($('.content-blocks.popup').length == 0) {
            return;
        }
        if ($(this).hasClass('socialShare')) {
            return;
        }
        if (projectUrl.indexOf('replytocom') != -1) {
            return;
        }
        $('.tv-top-fix-menu').removeClass('showx');
        $('.sidebar-menu').addClass('hidex');
        $('.content-blocks.popup').addClass('showx');
        $('.content-blocks.popup section').load(projectUrl)
        return false;
    });
    //On Click Open Menu Items
    $('.tv-menu-block, .menu-item').on('click', function () {
        $('.intro-block').addClass('reverse');
        $('.intro-block-container').addClass('reverse');
        $('.tv-menu-blocks').addClass('hidex');
        $('.tv-top-fix-menu').addClass('showx');
    });
    //On Click Open About/Resume Block
    $('.about-block, .menu-item.about').on('click', function () {
        $('.content-blocks').removeClass('showx');
        $('.content-blocks.about').addClass('showx');
        $('.menu-item').removeClass('active');
        $('.menu-item.about').addClass('active');
    });
    //On Click Open Portfolio Block
    $('.portfolio-block, .menu-item.portfolio').on('click', function () {
        $('.content-blocks').removeClass('showx');
        $('.content-blocks.portfolio').addClass('showx');
        $('.menu-item').removeClass('active');
        $('.menu-item.portfolio').addClass('active');
    });
    //On Click Open Blog Block
    $('.blog-block, .menu-item.blog').on('click', function () {
        $('.content-blocks').removeClass('showx');
        $('.content-blocks.blog').addClass('showx');
        $('.menu-item').removeClass('active');
        $('.menu-item.blog').addClass('active');
    });
    //On Click Open Contact Block
    $('.contact-block, .menu-item.contact').on('click', function () {
        $('.content-blocks').removeClass('showx');
        $('.content-blocks.contact').addClass('showx');
        $('.menu-item').removeClass('active');
        $('.menu-item.contact').addClass('active');
    });

    //On Click Close Blocks
    $('#close').on('click', function () {
        $('.intro-block').removeClass('reverse');
        $('.intro-block-container').removeClass('reverse');
        $('.content-blocks').removeClass('showx');
        $('.tv-menu-blocks').removeClass('hidex');
        $('.tv-top-fix-menu').removeClass('showx');
        $('.menu-item').removeClass('active');
    });
    //On Click Close Blog Post And Project Details
    $('#close-pop').on('click', function () {
        $('.content-blocks.popup').removeClass('showx');
        $('.sidebar-menu').removeClass('hidex');
        $('.tv-top-fix-menu').addClass('showx');
        $('.content-blocks.popup section').empty();
    });

    $('.tv-menu-block, .menu-item, #close').on('click', function () {
        $('.content-blocks').animate({scrollTop: 0}, 800);
    });

    //Function for 'Index-Menu2.html'
    $('#home').on('click', function () {
        $('.content-blocks').removeClass('showx');
        $('.menu-item').removeClass('active');
        $(this).addClass('active');

    });

    
});
function share_fb(url) {
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, 'facebook-share-dialog', "width=626, height=436")
}
function tv_social_share_loadpopup_js(em) {
    var shareurl = em.href;
    var top = (screen.availHeight - 500) / 2;
    var left = (screen.availWidth - 500) / 2;
    var popup = window.open(
            shareurl,
            'social sharing',
            'width=550,height=420,left=' + left + ',top=' + top + ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1'
            );
    return false;
}
/*==========================End====================================*/