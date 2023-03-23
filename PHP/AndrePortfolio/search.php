<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
    <?php if (have_posts()) : ?>
        <div class="row content">
            <div id="primary" class="col-md-12 block-content blogpost">
                <header class="page-header tv-section-heading text-center">
                    <h1 class="page-title">
                        <?php
                        /* translators: %s: search query. */
                        printf(esc_html__('Search Results for: %s', 'falixford'), '<span>' . get_search_query() . '</span>');
                        ?>
                    </h1>
                </header><!-- .page-header -->
                <?php while (have_posts()) : the_post(); ?>
                    <div class="post blogpost">
                        <div class="post-thumbnail text-center">
                            <a class="tv-open-popup-page tv-open-blog" href="<?php echo esc_url(get_permalink()); ?>">
                                <?php falixford_post_thumbnail(); ?>
                            </a>
                        </div>
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
</main><!-- #main -->
<?php
if (!is_front_page()) {
    get_footer();
}
