<?php
if (post_password_required()) {
    ?>
    <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'theme_localization'); ?></p>
    <?php return;
}
?>


<div id="comments">
    <?php

    #Required for nested reply function that moves reply inline with JS
    if (is_singular()) wp_enqueue_script('comment-reply');

    $GLOBALS['showOnlyOneTimeJS']['comment_button'] = "
    <script>
        jQuery(document).ready(function($) {
            var this_submit_button = $('.comment-respond .form-submit input#submit');
            this_submit_button.wrap('<div class=\"temp_submit_comment\"></div>');
            $('.temp_submit_comment').html('<div class=\"send_this_comment shortcode_button btn_small btn_type5\"><span class=\"ico_cont\"><span class=\"ico_fader\"></span><i class=\"ico_this icon-share-alt\"></i></span><span class=\"btn_text\">" . __('SEND COMMENT!', 'theme_localization') . "</span></div>');
            $('.send_this_comment').live( 'click', function() {
                $('#commentform').submit();
            });
        });
    </script>
    ";

    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');

    if (have_comments()) : ?>
        <h6 class="headInModule postcomment"><?php echo __('COMMENTS', 'theme_localization') . ": ";
            echo comments_number('0', '1', '%') . ' '; ?></h6>
        <ol class="commentlist">
            <?php wp_list_comments('type=comment&callback=gt3_theme_comment'); ?>
        </ol>

        <div class="dn"><?php paginate_comments_links(); ?></div>

        <?php if ('open' == $post->comment_status) : ?>

        <?php else : // comments are closed ?>
            <p><?php echo __('Sorry, the comment form is closed at this time.', 'theme_localization'); ?></p>

        <?php endif; ?>
    <?php endif; ?>

    <?php if ('open' == $post->comment_status) :

        $comment_form = array(
            'fields' => apply_filters('comment_form_default_fields', array(
                'author' => '<label class="label-name"></label><input type="text" placeholder="' . __('Name *', 'theme_localization') . '" title="' . __('Name *', 'theme_localization') . '" id="author" name="author" class="form_field">',
                'email' => '<label class="label-email"></label><input type="text" placeholder="' . __('Email *', 'theme_localization') . '" title="' . __('Email *', 'theme_localization') . '" id="email" name="email" class="form_field">',
                'url' => '<label class="label-web"></label><input type="text" placeholder="' . __('URL', 'theme_localization') . '" title="' . __('URL', 'theme_localization') . '" id="web" name="url" class="form_field">'
            )),
            'comment_field' => '<label class="label-message"></label><textarea name="comment" cols="45" rows="5" placeholder="' . __('Message...', 'theme_localization') . '" id="comment-message" class="form_field"></textarea>',
            'comment_form_before' => '',
            'comment_form_after' => '',
            'must_log_in' => __('You must be logged in to post a comment.', 'theme_localization'),
            'title_reply' => __('Leave a Comment!', 'theme_localization'),
            'label_submit' => __('Post Comment', 'theme_localization'),
            'logged_in_as' => '<p class="logged-in-as">' . __('Logged in as', 'theme_localization') . ' <a href="' . admin_url('profile.php') . '">' . $user_identity . '</a>. <a href="' . wp_logout_url(apply_filters('the_permalink', get_permalink())) . '">' . __('Log out?', 'theme_localization') . '</a></p>',
        );
        comment_form($comment_form, $post->ID);

    else : // Comments are closed
        ?>
        <p><?php _e('Sorry, the comment form is closed at this time.', 'theme_localization') ?></p>
    <?php endif; ?>
</div>