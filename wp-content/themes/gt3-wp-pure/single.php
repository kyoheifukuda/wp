<?php get_header();
the_post();

wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);

/* LOAD PAGE BUILDER ARRAY */
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
$gt3_current_page_sidebar = $gt3_theme_pagebuilder['settings']['layout-sidebars'];

$all_likes = gt3pb_get_option("likes");
/* ADD 1 view for this post */
$post_views = (get_post_meta(get_the_ID(), "post_views", true) > 0 ? get_post_meta(get_the_ID(), "post_views", true) : "0");
update_post_meta(get_the_ID(), "post_views", (int)$post_views + 1);
?>

    <div class="row <?php echo ((isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) && strlen($gt3_theme_pagebuilder['settings']['layout-sidebars'])>0) ? $gt3_theme_pagebuilder['settings']['layout-sidebars'] : "no-sidebar"); ?>">
        <div
            class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "span9" : "span12"); ?>">
            <div class="row">
                <div
                    class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "span9" : "span12"); ?>">
                    <div class="contentarea">

                        <div class="row">
                            <?php if (get_post_format() == "image" || get_post_format() == "video" || strlen($featured_image[0]) > 0) { ?>
                                <div class="span8">
                                    <?php

                                    if (get_post_format() == "image") {
                                        wp_enqueue_script('gt3_nivo_js', get_template_directory_uri() . '/js/nivo.js', array(), false, true);
                                        if (isset($gt3_theme_pagebuilder['post-formats']['images']) && is_array($gt3_theme_pagebuilder['post-formats']['images'])) {
                                            $compile_pf = "";
                                            if (is_array($gt3_theme_pagebuilder['post-formats']['images'])) {

                                                $compile_pf .= '
                                                <div class="slider-wrapper theme-default">
                                                    <div class="nivoSlider">
                                            ';

                                                foreach ($gt3_theme_pagebuilder['post-formats']['images'] as $imgid => $img) {
                                                    $compile_pf .= '<img class="pf_img" src="' . aq_resize(wp_get_attachment_url($img['attach_id']), "1200", "700", true, true, true) . '" alt="" />';
                                                }

                                                $compile_pf .= '
                                                    </div>
                                                </div>
                                            ';
                                            }

                                            $GLOBALS['showOnlyOneTimeJS']['nivo_slider'] = "
                                            <script>
                                                jQuery(document).ready(function($) {
                                                    $('.nivoSlider').each(function(){
                                                        $(this).nivoSlider({
                                                            directionNav: true,
                                                            controlNav: false,
                                                            effect:'sliceUpDownLeft',
                                                            animSpeed: 600,
                                                            pauseTime:3000
                                                        });
                                                    });
                                                });
                                            </script>
                                            ";

                                            echo $compile_pf;
                                        }
                                    } elseif (get_post_format() == "video") {
                                        $compile_pf = "";
                                        $uniqid = mt_rand(0, 9999);
                                        global $YTApiLoaded, $allYTVideos;
                                        if (empty($YTApiLoaded)) {
                                            $YTApiLoaded = false;
                                        }
                                        if (empty($allYTVideos)) {
                                            $allYTVideos = array();
                                        }

                                        $video_url = $gt3_theme_pagebuilder['post-formats']['videourl'];
                                        if (isset($gt3_theme_pagebuilder['post-formats']['video_height'])) {
                                            $video_height = $gt3_theme_pagebuilder['post-formats']['video_height'];
                                        } else {
                                            $video_height = $GLOBALS["pbconfig"]['default_video_height'];
                                        }

                                        #YOUTUBE
                                        $is_youtube = substr_count($video_url, "youtu");
                                        if ($is_youtube > 0) {
                                            $videoid = substr(strstr($video_url, "="), 1);
                                            $compile_pf .= "<div id='player{$uniqid}'></div>";

                                            array_push($allYTVideos, array("h" => $video_height, "w" => "100%", "videoid" => $videoid, "uniqid" => $uniqid));
                                        }

                                        #VIMEO
                                        $is_vimeo = substr_count($video_url, "vimeo");
                                        if ($is_vimeo > 0) {
                                            $videoid = substr(strstr($video_url, "m/"), 2);
                                            $compile_pf .= "
                                            <iframe src=\"http://player.vimeo.com/video/" . $videoid . "\" width=\"100%\" height=\"" . $video_height . "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                                        ";
                                        }

                                        echo $compile_pf;
                                    } else {
                                        echo '<img src="' . aq_resize($featured_image[0], "1270", null, true, true, true) . '" alt="" />';
                                    }

                                    echo do_shortcode("[feature_posts
                                        heading_color=''
                                        heading_size='h5'
                                        heading_text=''
                                        number_of_posts=".(isset($gt3_theme_pagebuilder['settings']['related_posts_number']) ? $gt3_theme_pagebuilder['settings']['related_posts_number'] : 6)."
                                        posts_per_line=".(isset($gt3_theme_pagebuilder['settings']['related_posts_in_line']) ? $gt3_theme_pagebuilder['settings']['related_posts_in_line'] : 3)."
                                        sorting_type='random'
                                        related='yes'
                                        post_type='post'][/feature_posts]");
                                    ?>
                                </div>
                            <?php } ?>
                            <div class="<?php echo((get_post_format() == "image" || get_post_format() == "video" || strlen($featured_image[0]) > 0) ? "span4" : "span12"); ?>">
                                <?php
                                if (!isset($gt3_theme_pagebuilder['settings']['show_title']) || $gt3_theme_pagebuilder['settings']['show_title'] !== "no") {
                                    echo '<h1 class="entry-title blogpost_title">' . get_the_title() . '</h1>';
                                }
                                ?>
                                <div class="preview_meta">
                                    <div class="block_likes">
                                        <div class="post-views"><i class="stand_icon icon-comment-alt"></i>
                                            <span><?php echo get_comments_number(get_the_ID()); ?></span></div>
                                        <div class="post-views"><i class="stand_icon icon-eye-open"></i>
                                            <span><?php echo $post_views; ?></span></div>
                                        <div class="post_likes post_likes_add <?php echo (isset($_COOKIE['like' . get_the_ID()]) ? "already_liked" : "") . '" data-postid="' . get_the_ID(); ?>" data-modify="like_post">
                                            <i class="stand_icon <?php echo((isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()] > 0) ? "icon-heart" : "icon-heart-empty"); ?>"></i>
                                            <span><?php echo((isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()] > 0) ? $all_likes[get_the_ID()] : 0); ?></span>
                                        </div>
                                    </div>
                                    <div class="block_post_meta_stand block_cats">
                                        <i class="icon-folder-open-alt"></i>
                                        <?php the_category(', '); ?>
                                    </div>
                                    <div class="block_post_meta_stand block_author">
                                        <i class="icon-user"></i>
                                        <?php the_author_posts_link(); ?>
                                    </div>
                                    <?php if (has_tag()) { ?>
                                    <div class="block_post_meta_stand block_tags">
                                        <i class="icon-tags"></i>
                                        <?php the_tags("<span>", ', ', '</span>'); ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <article>
                                    <?php
                                    the_content(__('Read more!', 'theme_localization'));
                                    wp_link_pages(array('before' => '<div class="page-link">' . __('Pages', 'theme_localization') . ': ', 'after' => '</div>'));
                                    ?>
                                </article>
                                <div class="socshare">
                                    <a target="_blank"
                                       href="http://www.facebook.com/share.php?u=<?php echo get_permalink(); ?>"
                                       class="ico_socialize_facebook1 ico_socialize"></a>
                                    <a target="_blank"
                                       href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&amp;url=<?php echo get_permalink(); ?>"
                                       class="ico_socialize_twitter2 ico_socialize"></a>
                                    <a target="_blank"
                                       href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&media=<?php echo (strlen($featured_image[0]) > 0) ? $featured_image[0] : gt3_get_theme_option("logo"); ?>"
                                       class="ico_socialize_pinterest ico_socialize"></a>
                                    <a target="_blank"
                                       href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>"
                                       class="ico_socialize_google2 ico_socialize"></a>
                                </div>
                                <div class="prev_next_links clearfix">
                                    <?php next_post_link('<div class="fleft">%link</div>') ?>
                                    <?php previous_post_link('<div class="fright">%link</div>') ?>
                                </div>
                                <div class="dn"><?php posts_nav_link(); ?></div>
                                <?php comments_template(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php get_sidebar('left'); ?>
            </div>
        </div>
        <?php get_sidebar('right'); ?>
    </div>

<?php get_footer(); ?>