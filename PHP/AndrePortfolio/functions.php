<?php
/**
 * falixford functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package falixford
 */
if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

if (!function_exists('falixford_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function falixford_setup() {

        define('ULTIMATE_FIELDS_PRO_PLUGIN_FILE', 'ultimate-fields-pro.php'); // temp fix
        require __DIR__ . '/inc/vendor/autoload.php';
        // Ultimate call
        Ultimate_Fields\Pro\Composer::boot(false);

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on falixford, use a find and replace
         * to change 'falixford' to the name of your theme in all the template files.
         */
        load_theme_textdomain('falixford', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');


        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
                'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
                )
        );
    }

endif;
add_action('after_setup_theme', 'falixford_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function falixford_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('falixford_content_width', 640);
}

add_action('after_setup_theme', 'falixford_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function falixford_scripts() {
    $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
    wp_enqueue_style('carousel', get_template_directory_uri() . '/css/owl.carousel' . $min . '.css');
    wp_enqueue_style('falixford-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_enqueue_style('responsive', get_template_directory_uri() . '/css/responsive.css');
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css');


    wp_enqueue_script('jquery-bootstrap', get_template_directory_uri() . '/js/bootstrap' . $min . '.js', array('jquery'), '', false);
    wp_enqueue_script('jquery-carousel', get_template_directory_uri() . '/js/owl.carousel' . $min . '.js', array('jquery'), '', false);
    wp_enqueue_script('jquery.nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll' . $min . '.js', array('jquery'), '', false);
    wp_enqueue_script('jquery.typer', get_template_directory_uri() . '/js/jquery.typer.js', array('jquery'), '', false);
//    if (is_front_page()) {
        wp_enqueue_script('shuffle', get_template_directory_uri() . '/js/shuffle' . $min . '.js', array('jquery'), '', false);
        wp_enqueue_script('shuffle.custom', get_template_directory_uri() . '/js/shuffle.custom.js', array('jquery'), '', false);
        wp_enqueue_script('jquery-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '', false);
//    }
    wp_enqueue_script('jquery.imagesloaded', get_template_directory_uri() . '/js/jquery.imagesloaded.js', array('jquery'), '', false);
    wp_enqueue_script('masonry.pkgd', get_template_directory_uri() . '/js/masonry.pkgd' . $min . '.js', array('jquery'), '', false);
    wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/js/magnific-popup.js', array('jquery'), '', false);
    


    wp_enqueue_script('falixford-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

    wp_enqueue_script('falixford-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'falixford_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}


// mandatory plugin notice
add_action('admin_init', 'check_for_required_plugins');

function check_for_required_plugins() {
    if (is_admin() && current_user_can('activate_plugins') && !is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
        add_action('admin_notices', 'required_plugin_notice');

        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }
    }
}

function generatePluginActivationLinkUrl($plugin) {
    // the plugin might be located in the plugin folder directly

    if (strpos($plugin, '/')) {
        $plugin = str_replace('/', '%2F', $plugin);
    }

    $activateUrl = sprintf(admin_url('plugins.php?action=activate&plugin=%s&plugin_status=all'), $plugin);

    // change the plugin request to the plugin to pass the nonce check
    $_REQUEST['plugin'] = $plugin;
    $activateUrl = wp_nonce_url($activateUrl, 'activate-plugin_' . $plugin);

    return $activateUrl;
}

function required_plugin_notice() {
    $pathpluginurl = WP_PLUGIN_DIR . '/contact-form-7/wp-contact-form-7.php';
    $isinstalled = file_exists($pathpluginurl);
    if ($isinstalled) {

        $path = 'contact-form-7/wp-contact-form-7.php';
        $link = wp_nonce_url(admin_url('plugins.php?action=activate&plugin=' . $path), 'activate-plugin_' . $path);
        ?><div class="error"><p>Sorry, but this theme requires that the <a href="<?php echo $link; ?>">Contact Form 7</a> to be installed and active.</p></div><?php
    } else {
        $action = 'install-plugin';
        $slug = 'contact-form-7';
        $link = wp_nonce_url(
                add_query_arg(
                        array(
            'action' => $action,
            'plugin' => $slug
                        ), admin_url('update.php')
                ), $action . '_' . $slug
        );
        ?><div class="error"><p>Sorry, but this theme requires the <a href="<?php echo $link; ?>">Contact Form 7</a> to be installed and active.</p></div><?php
    }
}

// Load new Icons for admin


add_filter('uf.ui.icon_sets', 'tv_falix_add_themify_icon_set');

function tv_falix_add_themify_icon_set() {
    $sets = array(
        'font-awesome' => __('Font Awesome', 'ultimate-fields-pro'),
        'dashicons' => __('Dashicons', 'ultimate-fields-pro'),
        'themify' => __('Themify', 'ultimate-fields-pro')
    );
    return $sets;
}

add_filter('uf.icon.themify', 'tv_falix_icon_set');

function tv_falix_icon_set() {
    return array(
        'name' => 'Themify Icons',
        'stylesheet' => get_stylesheet_directory_uri() . '/fonts/themify-icons/themify-icons.css',
        'version' => '4.7.1',
        'prefix' => 'ti',
        'groups' => array(
            array(
                'groupName' => 'Themify Icons',
                'icons' => array('ti-wand', 'ti-volume', 'ti-user', 'ti-unlock', 'ti-unlink', 'ti-trash', 'ti-thought', 'ti-target', 'ti-tag', 'ti-tablet', 'ti-star', 'ti-spray', 'ti-signal', 'ti-shopping-cart', 'ti-shopping-cart-full', 'ti-settings', 'ti-search', 'ti-zoom-in', 'ti-zoom-out', 'ti-cut', 'ti-ruler', 'ti-ruler-pencil', 'ti-ruler-alt', 'ti-bookmark', 'ti-bookmark-alt', 'ti-reload', 'ti-plus', 'ti-pin', 'ti-pencil', 'ti-pencil-alt', 'ti-paint-roller', 'ti-paint-bucket', 'ti-na', 'ti-mobile', 'ti-minus', 'ti-medall', 'ti-medall-alt', 'ti-marker', 'ti-marker-alt', 'ti-arrow-up', 'ti-arrow-right', 'ti-arrow-left', 'ti-arrow-down', 'ti-lock', 'ti-location-arrow', 'ti-link', 'ti-layout', 'ti-layers', 'ti-layers-alt', 'ti-key', 'ti-import', 'ti-image', 'ti-heart', 'ti-heart-broken', 'ti-hand-stop', 'ti-hand-open', 'ti-hand-drag', 'ti-folder', 'ti-flag', 'ti-flag-alt', 'ti-flag-alt-2', 'ti-eye', 'ti-export', 'ti-exchange-vertical', 'ti-desktop', 'ti-cup', 'ti-crown', 'ti-comments', 'ti-comment', 'ti-comment-alt', 'ti-close', 'ti-clip', 'ti-angle-up', 'ti-angle-right', 'ti-angle-left', 'ti-angle-down', 'ti-check', 'ti-check-box', 'ti-camera', 'ti-announcement', 'ti-brush', 'ti-briefcase', 'ti-bolt', 'ti-bolt-alt', 'ti-blackboard', 'ti-bag', 'ti-move', 'ti-arrows-vertical', 'ti-arrows-horizontal', 'ti-fullscreen', 'ti-arrow-top-right', 'ti-arrow-top-left', 'ti-arrow-circle-up', 'ti-arrow-circle-right', 'ti-arrow-circle-left', 'ti-arrow-circle-down', 'ti-angle-double-up', 'ti-angle-double-right', 'ti-angle-double-left', 'ti-angle-double-down', 'ti-zip', 'ti-world', 'ti-wheelchair', 'ti-view-list', 'ti-view-list-alt', 'ti-view-grid', 'ti-uppercase', 'ti-upload', 'ti-underline', 'ti-truck', 'ti-timer', 'ti-ticket', 'ti-thumb-up', 'ti-thumb-down', 'ti-text', 'ti-stats-up', 'ti-stats-down', 'ti-split-v', 'ti-split-h', 'ti-smallcap', 'ti-shine', 'ti-shift-right', 'ti-shift-left', 'ti-shield', 'ti-notepad', 'ti-server', 'ti-quote-right', 'ti-quote-left', 'ti-pulse', 'ti-printer', 'ti-power-off', 'ti-plug', 'ti-pie-chart', 'ti-paragraph', 'ti-panel', 'ti-package', 'ti-music', 'ti-music-alt', 'ti-mouse', 'ti-mouse-alt', 'ti-money', 'ti-microphone', 'ti-menu', 'ti-menu-alt', 'ti-map', 'ti-map-alt', 'ti-loop', 'ti-location-pin', 'ti-list', 'ti-light-bulb', 'ti-Italic', 'ti-info', 'ti-infinite', 'ti-id-badge', 'ti-hummer', 'ti-home', 'ti-help', 'ti-headphone', 'ti-harddrives', 'ti-harddrive', 'ti-gift', 'ti-game', 'ti-filter', 'ti-files', 'ti-file', 'ti-eraser', 'ti-envelope', 'ti-download', 'ti-direction', 'ti-direction-alt', 'ti-dashboard', 'ti-control-stop', 'ti-control-shuffle', 'ti-control-play', 'ti-control-pause', 'ti-control-forward', 'ti-control-backward', 'ti-cloud', 'ti-cloud-up', 'ti-cloud-down', 'ti-clipboard', 'ti-car', 'ti-calendar', 'ti-book', 'ti-bell', 'ti-basketball', 'ti-bar-chart', 'ti-bar-chart-alt', 'ti-back-right', 'ti-back-left', 'ti-arrows-corner', 'ti-archive', 'ti-anchor', 'ti-align-right', 'ti-align-left', 'ti-align-justify', 'ti-align-center', 'ti-alert', 'ti-alarm-clock', 'ti-agenda', 'ti-write', 'ti-window', 'ti-widgetized', 'ti-widget', 'ti-widget-alt', 'ti-wallet', 'ti-video-clapper', 'ti-video-camera', 'ti-vector', 'ti-themify-logo', 'ti-themify-favicon', 'ti-themify-favicon-alt', 'ti-support', 'ti-stamp', 'ti-split-v-alt', 'ti-slice', 'ti-shortcode', 'ti-shift-right-alt', 'ti-shift-left-alt', 'ti-ruler-alt-2', 'ti-receipt', 'ti-pin2', 'ti-pin-alt', 'ti-pencil-alt2', 'ti-palette', 'ti-more', 'ti-more-alt', 'ti-microphone-alt', 'ti-magnet', 'ti-line-double', 'ti-line-dotted', 'ti-line-dashed', 'ti-layout-width-full', 'ti-layout-width-default', 'ti-layout-width-default-alt', 'ti-layout-tab', 'ti-layout-tab-window', 'ti-layout-tab-v', 'ti-layout-tab-min', 'ti-layout-slider', 'ti-layout-slider-alt', 'ti-layout-sidebar-right', 'ti-layout-sidebar-none', 'ti-layout-sidebar-left', 'ti-layout-placeholder', 'ti-layout-menu', 'ti-layout-menu-v', 'ti-layout-menu-separated', 'ti-layout-menu-full', 'ti-layout-media-right-alt', 'ti-layout-media-right', 'ti-layout-media-overlay', 'ti-layout-media-overlay-alt', 'ti-layout-media-overlay-alt-2', 'ti-layout-media-left-alt', 'ti-layout-media-left', 'ti-layout-media-center-alt', 'ti-layout-media-center', 'ti-layout-list-thumb', 'ti-layout-list-thumb-alt', 'ti-layout-list-post', 'ti-layout-list-large-image', 'ti-layout-line-solid', 'ti-layout-grid4', 'ti-layout-grid3', 'ti-layout-grid2', 'ti-layout-grid2-thumb', 'ti-layout-cta-right', 'ti-layout-cta-left', 'ti-layout-cta-center', 'ti-layout-cta-btn-right', 'ti-layout-cta-btn-left', 'ti-layout-column4', 'ti-layout-column3', 'ti-layout-column2', 'ti-layout-accordion-separated', 'ti-layout-accordion-merged', 'ti-layout-accordion-list', 'ti-ink-pen', 'ti-info-alt', 'ti-help-alt', 'ti-headphone-alt', 'ti-hand-point-up', 'ti-hand-point-right', 'ti-hand-point-left', 'ti-hand-point-down', 'ti-gallery', 'ti-face-smile', 'ti-face-sad', 'ti-credit-card', 'ti-control-skip-forward', 'ti-control-skip-backward', 'ti-control-record', 'ti-control-eject', 'ti-comments-smiley', 'ti-brush-alt', 'ti-youtube', 'ti-vimeo', 'ti-twitter', 'ti-time', 'ti-tumblr', 'ti-skype', 'ti-share', 'ti-share-alt', 'ti-rocket', 'ti-pinterest', 'ti-new-window', 'ti-microsoft', 'ti-list-ol', 'ti-linkedin', 'ti-layout-sidebar-2', 'ti-layout-grid4-alt', 'ti-layout-grid3-alt', 'ti-layout-grid2-alt', 'ti-layout-column4-alt', 'ti-layout-column3-alt', 'ti-layout-column2-alt', 'ti-instagram', 'ti-google', 'ti-github', 'ti-flickr', 'ti-facebook', 'ti-dropbox', 'ti-dribbble', 'ti-apple', 'ti-android', 'ti-save', 'ti-save-alt', 'ti-yahoo', 'ti-wordpress', 'ti-vimeo-alt', 'ti-twitter-alt', 'ti-tumblr-alt', 'ti-trello', 'ti-stack-overflow', 'ti-soundcloud', 'ti-sharethis', 'ti-sharethis-alt', 'ti-reddit', 'ti-pinterest-alt', 'ti-microsoft-alt', 'ti-linux', 'ti-jsfiddle', 'ti-joomla', 'ti-html5', 'ti-flickr-alt', 'ti-email', 'ti-drupal', 'ti-dropbox-alt', 'ti-css3', 'ti-rss', 'ti-rss-alt'),
            )
        )
    );
}

function falix_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <div <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="tv-review-box clearfix">
            <div class="tv-review-thumb">
                <?php echo get_avatar($comment, $size = '80.5', $default = '<path_to_url>'); ?>
            </div>
            <div class="tv-review-content">
                <?php if ($comment->comment_approved == '0') : ?>
                    <strong><em><?php _e('Your comment is awaiting moderation.') ?></em></strong>
                    <br />
                    <br />
                <?php endif; ?>
                <div class="comment-meta commentmetadata tv-review-info">
                    <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>">
                        <strong><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></strong>
                    </a>
                    <?php edit_comment_link(__('(Edit)'), '  ', '') ?>
                </div>
                <div class="comment-meta commentmetadata tv-review-text">
                    <?php comment_text() ?>
                </div>
                <div class="tv-review-reply">
                    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                </div> 
            </div>
        </div>
        <?php
    }

    add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3);

    function remove_thumbnail_dimensions($html, $post_id, $post_image_id) {
        $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
        return $html;
    }
    ?>
