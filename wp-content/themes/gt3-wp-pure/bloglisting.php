<?php
$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);

$all_likes = gt3pb_get_option("likes");
/* ADD 1 view for this post */
$post_views = (get_post_meta(get_the_ID(), "post_views", true) > 0 ? get_post_meta(get_the_ID(), "post_views", true) : "0");
update_post_meta(get_the_ID(), "post_views", (int)$post_views + 1);

if (get_post_type() == "port") {
    $post_categ = '';
    $new_term_list = get_the_terms(get_the_id(), "portcat");
    if (is_array($new_term_list)) {
        foreach ($new_term_list as $term) {
            $post_categ = $post_categ . '<a href="'.get_term_link($term->slug, "portcat").'">'.$term->name.'</a>' . ', ';
        }
    }
} else {
    if (get_the_category()) $categories = get_the_category();
    $post_categ = '';
    if ($categories) {
        foreach ($categories as $category) {
            $post_categ = $post_categ . '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>' . ', ';
        }
    }
}

if (get_the_tags() !== '') {
    $posttags = get_the_tags();

}
if ($posttags) {
    $post_tags = '';
    $post_tags_compile = '<span class="preview_meta_tags">';
    foreach ($posttags as $tag) {
        $post_tags = $post_tags . '<a href="?tag=' . $tag->slug . '">' . $tag->name . '</a>' . ', ';
    }
    $post_tags_compile .= ' ' . trim($post_tags, ', ') . '</span>';
} else {
    $post_tags_compile = '';
}

?>

<div <?php post_class("row stand_post"); ?>>

<?php
if (get_post_format() == "image" || get_post_format() == "video" || strlen($featured_image[0])>0) {
    echo  '<div class="span8">';

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

            echo  $compile_pf;
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
            $video_height = 700;
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

        echo  $compile_pf;
    } else {
        echo  '<img src="' . aq_resize($featured_image[0], "1270", "700", true, true, true) . '" alt="" />';
    }

    echo  '</div>';
}

if (get_post_format() == "image" || get_post_format() == "video" || strlen($featured_image[0])>0) {
    echo  '<div class="span4">';
} else {
    echo  '<div class="span12">';
}

echo  '
                    <a href="'.get_permalink().'"><h1 class="entry-title blogpost_title">' . get_the_title() . '</h1></a>
                    <div class="preview_meta">
                        <div class="block_likes">
                            <div class="post-comments"><i class="stand_icon icon-comment-alt"></i>
                                <a href="' . get_comments_link() . '"><span>' . get_comments_number(get_the_ID()) . '</span></a>
                            </div>
                            <div class="post-views"><i class="stand_icon icon-eye-open"></i>
                                <span>'.$post_views.'</span>
                            </div>
                            <div class="post_likes post_likes_add '.(isset($_COOKIE['like' . get_the_ID()]) ? "already_liked" : "") . '" data-postid="' . get_the_ID().'" data-modify="like_post">
                                <i class="stand_icon '.((isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()] > 0) ? "icon-heart" : "icon-heart-empty").'"></i>
                                <span>'.((isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()] > 0) ? $all_likes[get_the_ID()] : 0).'</span>
                            </div>
                        </div>


                        <div class="block_post_meta_stand block_cats">
                            <i class="icon-folder-open-alt"></i>
                            ' . trim($post_categ, ', ') . '
                        </div>

                        <div class="block_post_meta_stand block_author">
                            <i class="icon-user"></i>
                            <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author_meta('display_name') . '</a>
                        </div>';

if (strlen($post_tags_compile)>0) {
    echo  '
                            <div class="block_post_meta_stand block_tags">
                                <i class="icon-tags"></i>
                                ' . $post_tags_compile . '
                            </div>
                            ';
}

echo  '            </div>
                    <article>
                        ' . ((strlen(get_the_excerpt()) > 0) ? get_the_excerpt() : do_shortcode(get_the_content())) . '
                    </article>

                    <a href="'.get_permalink().'" class="post_read_more_small">'.__('Read More &rsaquo;', 'theme_localization').'</a>
                    ';

echo  '</div>';

echo  '</div>';