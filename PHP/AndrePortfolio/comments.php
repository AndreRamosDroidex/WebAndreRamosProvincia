<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package falixford
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area tv-offspace-top-50">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
        ?>
        <h2 class="comments-title">
            <?php
            $falixford_comment_count = get_comments_number();
            if ('1' === $falixford_comment_count) {
                printf(
                        /* translators: 1: title. */
                        esc_html__('One thought on &ldquo;%1$s&rdquo;', 'falixford'), '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                        /* translators: 1: comment count number, 2: title. */
                        esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $falixford_comment_count, 'comments title', 'falixford')), number_format_i18n($falixford_comment_count), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2><!-- .comments-title -->

        <div class="tv-comment-list comment-list tv-comments">
            <?php
            wp_list_comments(
                    array(
                        'style' => 'div',
                        'short_ping' => true,
                        'callback' => 'falix_comment'
                    )
            );
            ?>
        </div><!-- .comment-list -->

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'falixford'); ?></p>
            <?php
        endif;

    endif; // Check for have_comments().
    
    $fields = array(
        'author' => sprintf(
                '<p class="comment-form-author col-sm-4">%s %s</p>', '', sprintf(
                        '<input id="author" class="form-control" placeholder="Your name *" name="author" type="text" value="%s" size="30" maxlength="245"%s />', esc_attr($commenter['comment_author']), $html_req
                )
        ),
        'email' => sprintf(
                '<p class="comment-form-email col-sm-4">%s %s</p>', '', sprintf(
                        '<input id="email" class="form-control" placeholder="Your email *" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s />', ( $html5 ? 'type="email"' : 'type="text"'), esc_attr($commenter['comment_author_email']), $html_req
                )
        ),
        'url' => sprintf(
                '<p class="comment-form-url col-sm-4">%s %s</p>', '', sprintf(
                        '<input id="url" class="form-control" placeholder="Your website *" name="url" %s value="%s" size="30" maxlength="200" />', ( $html5 ? 'type="url"' : 'type="text"'), esc_attr($commenter['comment_author_url'])
                )
        ),
        'cookies' => sprintf(
                '<p class="comment-form-cookies-consent col-sm-12">%s %s</p>', sprintf(
                        '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />', $consent
                ), sprintf(
                        '<label for="wp-comment-cookies-consent">%s</label>', __('Save my name, email, and website in this browser for the next time I comment.')
                )
        ),
    );
    $commentArgs = array(
        'fields' => $fields,
        'comment_notes_before' => sprintf(
                '<div class="row"><p class="comment-notes col-sm-12">%s%s</p>', sprintf(
                        '<span id="email-notes">%s</span>', __('Your email address will not be published.')
                ), ( $req ? $required_text : '')
        ),
        'submit_field' => '<div class="form-submit col-md-12">%1$s %2$s</div></div>',
        'label_submit' => __('Leave A Reply'),
        'class_submit' => 'submit btn btn-mod  btn-large btn-round',
        'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
        'comment_field' => sprintf(
                '<p class="comment-form-comment col-sm-12">%s %s</p>', '', '<textarea id="comment" class="form-control" name="comment" placeholder="Your comment *" cols="45" rows="8" maxlength="65525" required="required"></textarea>'
        ),
    );

    comment_form($commentArgs);
    ?>

</div><!-- #comments -->
