<section class="tv-home tv-bg-img" style="background: transparent url(<?php echo (get_value('background_image', $type) != '') ? get_the_value('background_image', $type) : get_stylesheet_directory_uri() . '/images/bg1.jpg'; ?>) repeat 0 0 / cover">
    <div class="overlay opacity5"></div>
    <div class="container">
        <div class="intro-block">
            <div class="intro-block-container">
                <span class="tv-sl-text">Hello</span>
                <h1 class="text-white"><?php echo (get_value('your_full_name', $type) != '') ? "I'm " . get_the_value('your_full_name', $type) . "." : "I'm Falix Ford."; ?></h1>
                <div id="typer">
                    <?php
                    $typerText = array();
                    while (have_groups('typer_texts', $type)): the_group();
                        if ('typer_text' == get_group_type()):
                            $typerValue = explode(" ", get_sub_value('text', $type));
                            $restValue = ltrim(get_sub_value('text', $type), $typerValue[0] . ' ');
                            $typerText[] = '<h2><span class="text-color-1">' . $typerValue[0] . '</span> ' . $restValue . '</h2>';
                        endif;
                    endwhile;
                    ?>
                </div>
                <div class="tv-social">
                    <ul class="tv-social-box">
                        <?php if (get_value('socialfacebook', $type) != '') : ?>
                            <li class="tv-social-link"><a href="<?php the_value('socialfacebook', $type); ?>"><i class="fa fa-facebook"></i></a></li>
                        <?php endif; ?>    
                        <?php if (get_value('socialtwitter', $type) != '') : ?>    
                            <li class="tv-social-link"><a href="<?php the_value('socialtwitter', $type); ?>"><i class="fa fa-twitter"></i></a></li>
                        <?php endif; ?>    
                        <?php if (get_value('sociallinkedin', $type) != '') : ?>    
                            <li class="tv-social-link"><a href="<?php the_value('sociallinkedin', $type); ?>"><i class="fa fa-linkedin"></i></a></li>
                        <?php endif; ?>    
                        <?php if (get_value('socialdribble', $type) != '') : ?>    
                            <li class="tv-social-link"><a href="<?php the_value('socialdribble', $type); ?>"><i class="fa fa-dribbble"></i></a></li>
                        <?php endif; ?>    
                    </ul>
                </div>
            </div>
        </div>
        <div class="tv-menu-blocks">
            <div class="about-block tv-menu-block">
                <div class="about-block-container">
                    <h2 class="about menu-item"><?php the_value('about_page_title', $type); ?></h2>
                </div>
            </div>
            <div class="portfolio-block  tv-menu-block">
                <div class="portfolio-block-container">
                    <h2 class="portfolio menu-item"><?php the_value('portfolio_page_title', $type); ?></h2>
                </div>
            </div>
            <div class="blog-block  tv-menu-block">
                <div class="blog-block-container">
                    <h2 class="blog menu-item"><?php the_value('blog_page_title', $type); ?></h2>
                </div>
            </div>
            <div class="contact-block  tv-menu-block">
                <div class="contact-block-container">
                    <h2 class="contact menu-item"><?php the_value('contact_page_title', $type); ?></h2>
                </div>
            </div>
        </div>
        <div class="content-blocks about">
            <section id="about" class="content">
                <div class="block-content">
                    <div class="tv-section-heading">
                        <h2><?php the_value('about_page_title', $type); ?></h2>
                        <p><?php the_value('about_sub_title', $type); ?></p>
                    </div>
                    <div class="tv-about-details">
                        <?php the_value('about_text', $type); ?>
                        <div class="tv-about-details-info-list row">
                            <?php if (get_value('personal_info_full_name', $type) != '') : ?>
                                <div class="col-sm-6"><span>Name : <?php the_value('personal_info_full_name', $type); ?></span> </div>
                            <?php endif; ?>
                            <?php if (get_value('personal_info_date_of_birth', $type) != '') : ?>
                                <div class="col-sm-6"><span>Date of birth : </span> <?php echo date('F j, Y', strtotime(get_the_value('personal_info_date_of_birth', $type))); ?> </div>
                            <?php endif; ?>
                            <?php if (get_value('personal_info_address', $type) != '') : ?>
                                <div class="col-sm-6"><span>Address : </span> <?php the_value('personal_info_address', $type); ?></div>
                            <?php endif; ?>
                            <?php if (get_value('personal_info_email', $type) != '') : ?>
                                <div class="col-sm-6"><span>Email : </span> <?php the_value('personal_info_email', $type); ?></div>
                            <?php endif; ?>
                            <?php if (get_value('personal_info_phone', $type) != '') : ?>
                                <div class="col-sm-6"><span>Phone : </span> <?php the_value('personal_info_phone', $type); ?></div>
                            <?php endif; ?>
                            <?php if (get_value('personal_info_skype', $type) != '') : ?>
                                <div class="col-sm-6"><span>Skype : </span> <?php the_value('personal_info_skype', $type); ?></div>
                            <?php endif; ?>
                            <?php if (get_value('personal_info_interest', $type) != '') : ?>
                                <div class="col-sm-6"><span>Interest : </span> <?php the_value('personal_info_interest', $type); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php $file = get_value('resume_file', $type); ?>
                        <?php if ($file) : ?>
                            <a href="<?php wp_get_attachment_url($file); ?>" class="btn btn-download">Download Resume</a> 
                        <?php endif; ?>
                        <?php if (get_value('hire_me_link', $type) != '') : ?>    
                            <a href="<?php the_value('hire_me_link', $type) ?>" target="<?php the_value('hire_me_link_target', $type) ?>" class="btn btn-hire">Hire Me</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="block-content">
                    <div class="tv-section-heading">
                        <h2><?php the_value('expertise_title', $type); ?></h2>
                        <p><?php the_value('expertise_sub_title', $type); ?></p>
                    </div>
                    <div class="row">
                        <?php while (have_groups('expertise_items', $type)): the_group(); ?>
                            <?php if ('expertise_item' == get_group_type()): ?>
                                <div class="col-md-6 media tv-expertise-media">
                                    <div class="media-left">
                                        <span class="<?php the_sub_value('expertise_icon', $type); ?>"></span>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="title"><?php the_sub_value('expertise_title', $type); ?></h4>
                                        <p class="sec-p"><?php the_sub_value('expertise_description', $type); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="block-content">
                    <div class="tv-section-heading">
                        <h2><?php the_value('experience_title', $type); ?></h2>
                        <p><?php the_value('experience_sub_title', $type); ?></p>
                    </div>
                    <div class="tv-timeline-section">
                        <ul>
                            <?php while (have_groups('experiences_items', $type)): the_group(); ?>
                                <?php if ('experience_item' == get_group_type()): ?>
                                    <li>
                                        <div class="tv-year"><?php the_sub_value('experience_year', $type); ?></div>
                                        <div class="tv-sep-line"></div>
                                        <div class="tv-history-content">
                                            <h4><?php the_sub_value('experience_title', $type); ?></h4>
                                            <p><?php the_sub_value('experience_description', $type); ?></p>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
                <div class="block-content">
                    <div class="tv-section-heading">
                        <h2><?php the_value('testionials_title', $type); ?></h2>
                        <p><?php the_value('testimonials_sub_title', $type); ?></p>
                    </div>
                    <div id="testimonial" class="owl-carousel owl-theme owl-loaded owl-drag">
                        <?php while (have_groups('testimonials_items', $type)): the_group(); ?>
                            <?php if ('testimonai_item' == get_group_type()): ?>
                                <div class="item testimonials">
                                    <blockquote><?php the_sub_value('testimonial_text', $type); ?>
                                        <p class="quote"><span><?php the_sub_value('client_name', $type); ?></span> - <?php the_sub_value('client_post', $type); ?></p>
                                    </blockquote>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
        </div>
        <!----------------------Portfolio------------------------------------>
        <div class="content-blocks portfolio">
            <section class="content">
                <div class="block-content">
                    <div class="tv-section-heading">
                        <h2><?php the_value('portfolio_page_title', $type); ?></h2>
                        <p><?php the_value('portfolio_sub_title', $type); ?></p>
                    </div>
                    <div class="row">
                        <div class="tv-filter-wrapper col-md-12">
                            <div class="portfolio-filter filter-options">
                                <label>Filters:</label>
                                <button class="active" data-group="all">all</button>
                                <?php $project_category = array(); ?>
                                <?php while (have_groups('portfolio_items', $type)): the_group(); ?>
                                    <?php if ('portfolio_item' == get_group_type()): ?>
                                        <?php $categories = explode(',', get_the_sub_value('portfolio_category', $type)); ?>
                                        <?php foreach ($categories as $category) : ?>
                                            <?php if (!in_array(strtolower($category), $project_category)): ?>
                                                <?php $project_category[] = strtolower($category); ?>
                                                <button data-group="<?php echo str_replace(" ", "_", strtolower($category)); ?>"><?php echo strtolower($category); ?></button>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <div id="grid" class="portfolio-grid  my-shuffle-container my-shuffle">
                            <?php $i = 1; ?>
                            <?php while (have_groups('portfolio_items', $type)): the_group(); ?>
                                <?php if ('portfolio_item' == get_group_type()): ?>
                                    <?php $project_category = array(); ?>
                                    <?php $categories = explode(',', str_replace(" ", "_", strtolower(get_the_sub_value('portfolio_category', $type)))); ?>
                                    <?php foreach ($categories as $category) : ?>
                                        <?php if (!in_array(strtolower($category), $project_category)): ?>
                                            <?php $project_category[] = '"' . strtolower($category) . '"'; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <div class="item web picture-item col-lg-4 col-md-6 col-sm-12 tv-grid-gutter-10 " data-groups='[<?php echo implode(',', $project_category); ?>]'>
                                        <a href="single-project.html" class="tv-single-portfolio tv-open-popup-page" data-id="<?php echo $i; ?>">
                                            <img alt="<?php the_sub_value('portfolio_image', $type) ?>" src="<?php the_sub_value('portfolio_image', $type) ?>" class="img-responsive">
                                            <div class="content">
                                                <h4 class="title"><?php the_sub_value('portfolio_name', $type) ?></h4>
                                                <span class="cat"><?php the_sub_value('portfolio_category', $type); ?></span>
                                            </div>
                                        </a>
                                    </div>
                                    <?php $i++; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                        <div id="single-portfolio" style="display:none;">
                            <?php $i = 1; ?>
                            <?php while (have_groups('portfolio_items', $type)): the_group(); ?>
                                <?php if ('portfolio_item' == get_group_type()): ?>
                                    <div class="tv-single-port-block" id="portfolio-<?php echo $i; ?>">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="tv-info-wrap tv-black-text tv-alt-font">
                                                    <div>
                                                        <span class="tv-para tv-light-blackgray-text">Data Created:</span>
                                                        <span class="tv-para"><?php echo date('D, F j, Y', strtotime(get_the_sub_value('portfolio_date', $type))); ?></span>
                                                    </div>
                                                    <div>
                                                        <span class="tv-para tv-light-blackgray-text">Client:</span>
                                                        <span class="tv-para"><?php the_sub_value('portfolio_client', $type) ?></span>
                                                    </div>
                                                    <div>
                                                        <span class="tv-para tv-light-blackgray-text">Skills:</span>
                                                        <span class="tv-para"><?php the_sub_value('portfolio_skills', $type) ?></span>
                                                    </div>
                                                    <div>
                                                        <span class="tv-para tv-light-blackgray-text">Category:</span>
                                                        <span class="tv-para"><?php the_sub_value('portfolio_category', $type) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <p class="tv-text-high tv-alt-text tv-offspace-botttom-3per"><?php the_sub_value('portfolio_title', $type) ?></p>
                                            </div>
                                        </div>
                                        <?php $images = get_sub_value('portfolio_gallary', $type) ?>
                                        <?php if ($images) : ?>
                                            <div>
                                                <ul id="items-grid" class="row tv-offspace-top-40 tv-port-image-grid  masonry clearfix">
                                                    <?php foreach ($images as $image_id) : ?>
                                                        <li class="tv-port-item grid-item  col-lg-4 col-md-3 col-sm-6 col-xs-12 tv-grid-gutter-00">
                                                            <a href="<?php echo wp_get_attachment_url($image_id, 'thumbnail'); ?>" data-image-popup-<?php echo $i; ?>="">
                                                                <div class="tv-port-img-overlay"><img src="<?php echo wp_get_attachment_url($image_id, 'thumbnail'); ?>" alt="portfolio-image"></div>
                                                                <div class="tv-port-overlay-icon">
                                                                    <div class="tv-port-icon"><div aria-hidden="true" class="ti-search"></div></div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                        <script>
                                            jQuery(document).ready(function ($) {
                                                $masonry = $('.masonry');
                                                $masonry.imagesLoaded(function () {
                                                    $('.masonry').masonry({
                                                        // options
                                                        itemSelector: '.grid-item',
                                                        percentPosition: true
                                                    });
                                                });
                                                var $imagePopup = $('[data-image-popup-<?php echo $i; ?>]');
                                                /*Image*/
                                                $imagePopup.magnificPopup({
                                                    type: 'image',
                                                    gallery: {
                                                        enabled: true
                                                    },
                                                });
                                            });
                                        </script>
                                        <div class="row tv-offspace-top-50">
                                            <div class="col-md-12 col-md-offset-3">
                                                <p><?php the_sub_value('portfolio_description', $type) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!----------------------End------------------------------------------->
        <!----------------------Blog------------------------------------------>
        <div class="content-blocks blog">
            <section class="content">
                <div class="block-content">
                    <div class="tv-section-heading">
                        <h2><?php the_value('blog_page_title', $type); ?></h2>
                        <p><?php the_value('blog_page_sub_title', $type); ?></p>
                    </div>
                    <?php
                    $query = new WP_Query(array(
                        'post_status' => 'publish',
                        'post_type' => 'post', // or 'any'
                    ));
                    ?>
                    <?php if ($query->have_posts()) : ?>
                        <div class="row">
                            <div class="col-md-10 mx-auto">
                                <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <div class="post blogpost">
                                        <?php falixford_post_thumbnail(); ?>
                                        <div class="post-title text-center">
                                            <?php the_title('<a class="tv-open-popup-page tv-open-blog" href="' . esc_url(get_permalink()) . '" rel="bookmark"><h2>', '</h2></a>'); ?>
                                            <p class="post-info">
                                                <span class="post-author">Posted <?php falixford_posted_by(); ?></span>
                                                <span class="slash"></span>
                                                <span class="post-date"><?php falixford_posted_on(); ?></span>
                                                <span class="slash"></span>
                                                <?php $categories_list = get_the_category_list(esc_html__(', ', 'falixford')); ?>
                                                <?php if ($categories_list) : ?>
                                                    <?php printf('<span class="post-catetory">' . esc_html__('in %1$s', 'falixford') . '</span>', $categories_list); ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="post-body">
                                            <?php the_content(); ?>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn tv-open-popup-page tv-open-blog" href="<?php echo esc_url(get_permalink()); ?>">Read More</a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <!----------------------End------------------------------------------>
        <!----------------------Contact------------------------------------------>
        <div class="content-blocks contact">
            <section class="content">
                <div class="block-content">
                    <div class="tv-section-heading">
                        <h2><?php the_value('contact_page_title', $type); ?></h2>
                        <p><?php the_value('contact_sub_title', $type); ?></p>
                    </div>
                    <div class="row tv-offspace-top-50">
                        <div class="col-md-5 col-sm-12 contact-left-block tv-offspace-small-bottom-20">
                            <?php the_value('contact_page_content', $type); ?>
                            <p class="tv-contact-line text-right tv-light-black-text tv-alt-font"><?php the_value('contact_address', $type); ?> <i class="ti-location-pin"></i></p>
                            <p class="tv-contact-line text-right tv-light-black-text tv-alt-font"><a href="tel:<?php the_value('contact_phone', $type); ?>"> <?php the_value('contact_phone', $type); ?> <i class="ti-mobile"></i></a></p>
                            <p class="tv-contact-line text-right tv-light-black-text tv-alt-font"><a href="mailto:<?php the_value('contact_email', $type); ?>"> <?php the_value('contact_email', $type); ?> <i class="ti-email"></i></a></p>
                        </div>
                        <div class="col-md-6 offset-md-1 col-sm-12">
                            <div class="contact-wrapper">
                                <div class="contact-form">
                                    <?php echo do_shortcode(get_the_value('contact_form_shortcode', $type)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!----------------------End------------------------------------------>
        <!----------------------Popup------------------------------------------>
        <div class="content-blocks popup">
            <div id="close-pop" class="close-popup"><i class="ti-close"></i></div>
            <section class="content removepadding" id="ajaxcontent">
                <div class="block-content"></div>
            </section>
        </div>
        <!----------------------End------------------------------------------>
    </div>
</section>
<script>
    jQuery(document).ready(function ($) {
        typer();
        
        $masonry = $('.masonry');
        $masonry.imagesLoaded(function () {
            $('.masonry').masonry({
                // options
                itemSelector: '.grid-item',
                percentPosition: true
            });
        });

        var $imagePopup = $('[data-image-popup]');
        /*Image*/
        $imagePopup.magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            },
        });

        $('#testimonial').owlCarousel({
            nav: true,
            navText: [
                '<i class="ti-arrow-left"></i>',
                '<i class="ti-arrow-right"></i>'
            ],
            items: 1,
            navSpeed: 400,
            loop: true,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
        });
    });
    function typer() {
        var win = jQuery(window),
                foo = jQuery('#typer');
        foo.typer([<?php echo "'" . implode("','", $typerText) . "'" ?>]);
    }
</script>