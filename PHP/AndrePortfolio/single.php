<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package falixford
 */
if (!is_front_page()) {
    get_header();
}
?>
<div class="tv-top-fix-menu-2">
    <ul class="inline-menu inline-menu-2 container">
        <li class="about menu-item active"><a href="/">Home <span class="tv-menu-link-line">Home</span></a></li>
    </ul>
</div>
<main id="primary" class="site-main container">
    <?php while (have_posts()) : the_post(); ?>
        <div class="row content">
            <div id="primary" class="col-md-12 block-content blogpost">
                <main class="tv-site-main tv-single-blog tv-blog-style-one">
                    <article class="tv-post-type tv-single-blog-item tv-alt-font">
                        <header class="entry-header">
                            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                            <div class="entry-meta">
                                <span class="post-date"><?php falixford_posted_on(); ?></span>
                                <?php $categories_list = get_the_category_list(esc_html__(', ', 'falixford')); ?>
                                <?php if ($categories_list) : ?>
                                    <?php printf('<span class="post-cat">' . esc_html__('in %1$s', 'falixford') . '</span>', $categories_list); ?>
                                <?php endif; ?>
                                <span class="post-comment"><i class="fa fa-comments"></i><?php echo get_comments_number(); ?></span>
                                <span class="posted-by"><?php falixford_posted_by(); ?></span>
                            </div>
                        </header>
                        <figure class="post-thumbnail"><?php the_post_thumbnail(); ?></figure>

                        <div class="entry-content">
                            <?php
                            the_content(
                                    sprintf(
                                            wp_kses(
                                                    /* translators: %s: Name of current post. Only visible to screen readers */
                                                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'falixford'), array(
                                'span' => array(
                                    'class' => array(),
                                ),
                                                    )
                                            ), wp_kses_post(get_the_title())
                                    )
                            );

                            wp_link_pages(
                                    array(
                                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'falixford'),
                                        'after' => '</div>',
                                    )
                            );
                            ?>
                        </div>
                        <footer class="entry-footer">
                            <div class="entry-footer-container">
                                <?php falixford_entry_footer(); ?>
                                <div class="share-btns">
                                    <div class="share-btns-items">
                                        <div class="share-btn-link share-btn-facebook-item">
                                            <a class="socialShare" onclick="return tv_social_share_loadpopup_js(this);" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink()); ?>" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a>
                                        </div>
                                        <div class="share-btn-link share-btn-twitter-item">
                                            <a class="socialShare" onclick="return tv_social_share_loadpopup_js(this);" href="https://twitter.com/share?text=<?php echo the_title(); ?>&amp;url=<?php echo esc_url(get_permalink()); ?>&amp;via=themevaultnet" rel="nofollow" title="Share on Twitter"><i class="fa fa-twitter"></i></a>
                                        </div>
                                        <div class="share-btn-link share-btn-linkedin-item">
                                            <a class="socialShare" onclick="return tv_social_share_loadpopup_js(this);" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url(get_permalink()); ?>&title=<?php echo the_title(); ?>&summary=<?php echo the_title(); ?>&source=themevault" rel="nofollow" title="Share on LinkedIn"><i class="fa fa-linkedin"></i></a>
                                        </div>
                                        <div class="share-btn-link share-btns-pinterest-item">
                                            <a class="socialShare" onclick="return tv_social_share_loadpopup_js(this);" href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink()); ?>&media=<?php echo get_the_post_thumbnail_url(); ?>&description=<?php echo the_title(); ?>" rel="nofollow" title="Share on Pinterest"><i class="fa fa-pinterest"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </article>
                    <?php
                    the_post_navigation(
                            array(
                                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'falixford') . '</span> <span class="nav-title">%title</span>',
                                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'falixford') . '</span> <span class="nav-title">%title</span>',
                            )
                    );

                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                </main>
            </div>
        </div>
    <?php endwhile; ?>
</main><!-- #main -->

<?php
if (!is_front_page()) {
    get_footer();
}
