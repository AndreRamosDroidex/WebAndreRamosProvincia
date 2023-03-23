<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package falixford
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <div id="page" class="tv-page-wrapper">
<!--            <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'falixford'); ?></a>-->
            <div class="tv-top-fix-menu">
                <ul class="inline-menu">
                    <li class="about menu-item active">About <span class="tv-menu-link-line">About</span></li>
                    <li class="portfolio menu-item">Portfolio <span class="tv-menu-link-line">Portfolio</span></li>
                    <li class="blog menu-item">Blog <span class="tv-menu-link-line">Blog</span></li>
                    <li class="contact menu-item">Contact <span class="tv-menu-link-line">Contact</span></li>
                    <li id="close" class="menu-item"><i class="ti-close"></i></li>
                </ul>
            </div>
            
