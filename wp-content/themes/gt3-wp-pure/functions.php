<?php

if (!isset($content_width)) $content_width = 940;

function gt3_get_theme_pagebuilder($postid, $args = array())
{
    $gt3_theme_pagebuilder = get_post_meta($postid, "pagebuilder", true);
    if (!is_array($gt3_theme_pagebuilder)) {
        $gt3_theme_pagebuilder = array();
    }

    if (!isset($gt3_theme_pagebuilder['settings']['show_content_area'])) {
        $gt3_theme_pagebuilder['settings']['show_content_area'] = "yes";
    }
    if (!isset($gt3_theme_pagebuilder['settings']['show_page_title'])) {
        $gt3_theme_pagebuilder['settings']['show_page_title'] = "yes";
    }
    if (isset($args['not_prepare_sidebars']) && $args['not_prepare_sidebars'] == "true") {

    } else {
        if (!isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) || $gt3_theme_pagebuilder['settings']['layout-sidebars'] == "default") {
            $gt3_theme_pagebuilder['settings']['layout-sidebars'] = gt3_get_theme_option("default_sidebar_layout");
        }
    }

    return $gt3_theme_pagebuilder;
}

function gt3_get_theme_sidebars_for_admin()
{
    $theme_sidebars = gt3_get_theme_option("theme_sidebars");
    if (!is_array($theme_sidebars)) {
        $theme_sidebars = array();
    }

    return $theme_sidebars;
}

function gt3_get_theme_option($optionname, $defaultValue = "")
{
    $returnedValue = get_option(GT3_THEMESHORT . $optionname, $defaultValue);

    if (gettype($returnedValue) == "string") {
        return stripslashes($returnedValue);
    } else {
        return $returnedValue;
    }
}

function gt3_the_theme_option($optionname, $beforeoutput = "", $afteroutput = "")
{
    $returnedValue = get_option(GT3_THEMESHORT . $optionname);

    if (strlen($returnedValue) > 0) {
        echo $beforeoutput . stripslashes($returnedValue) . $afteroutput;
    }
}

function gt3_get_if_strlen($str, $beforeoutput = "", $afteroutput = "")
{
    if (strlen($str) > 0) {
        return $beforeoutput . $str . $afteroutput;
    }
}

function gt3_delete_theme_option($optionname)
{
    return delete_option(GT3_THEMESHORT . $optionname);
}

function gt3_update_theme_option($optionname, $optionvalue)
{
    if (update_option(GT3_THEMESHORT . $optionname, $optionvalue)) {
        return true;
    }
}

function gt3_messagebox($actionmessage)
{
    $compile = "<div class='admin_message_box fadeout'>" . $actionmessage . "</div>";
    return $compile;
}

function gt3_theme_comment($comment, $args, $depth)
{
    $max_depth_comment = ($args['max_depth'] > 4 ? 4 : $args['max_depth']);

    $GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>" class="stand_comment">
        <div class="commentava">
            <?php echo get_avatar($comment->comment_author_email, 50); ?>
        </div>
        <div class="thiscommentbody">
            <div class="comment_info">
                <span class="date"><?php printf('%1$s', get_comment_date("F d, Y")) ?></span> by <span class="author_name"><?php printf('%s', get_comment_author_link()) ?> <?php edit_comment_link('(Edit)', '  ', '') ?></span>
                <?php comment_reply_link(array_merge($args, array('before' => ' <span class="comments">', 'after' => '</span>', 'depth' => $depth, 'reply_text' => __('Reply', 'theme_localization'), 'max_depth' => $max_depth_comment))) ?>
            </div>
            <?php if ($comment->comment_approved == '0') : ?>
                <p><em><?php _e('Your comment is awaiting moderation.', 'theme_localization'); ?></em></p>
            <?php endif; ?>
            <?php comment_text() ?>
        </div>
        <div class="clear"></div>
    </div>
<?php
}

#Custom paging
function gt3_get_theme_pagination($range = 10, $type = "")
{
    if ($type == "show_in_shortcodes") {
        global $paged, $wp_query_in_shortcodes;
        $wp_query = $wp_query_in_shortcodes;
    } else {
        global $paged, $wp_query;
    }

    if (empty($paged)) {
        $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    }

    $max_page = $wp_query->max_num_pages;
    if ($max_page > 1) {
        echo '<ul class="pagerblock">';
    }
    if ($max_page > 1) {
        if (!$paged) {
            $paged = 1;
        }
        $ppl = "<span class='btn_prev'></span>";
        if ($max_page > $range) {
            if ($paged < $range) {
                for ($i = 1; $i <= ($range + 1); $i++) {
                    echo "<li><a href='" . get_pagenum_link($i) . "'";
                    if ($i == $paged) echo " class='current'";
                    echo ">$i</a></li>";
                }
            } elseif ($paged >= ($max_page - ceil(($range / 2)))) {
                for ($i = $max_page - $range; $i <= $max_page; $i++) {
                    echo "<li><a href='" . get_pagenum_link($i) . "'";
                    if ($i == $paged) echo " class='current'";
                    echo ">$i</a></li>";
                }
            } elseif ($paged >= $range && $paged < ($max_page - ceil(($range / 2)))) {
                for ($i = ($paged - ceil($range / 2)); $i <= ($paged + ceil(($range / 2))); $i++) {
                    echo "<li><a href='" . get_pagenum_link($i) . "'";
                    if ($i == $paged) echo " class='current'";
                    echo ">$i</a></li>";
                }
            }
        } else {
            for ($i = 1; $i <= $max_page; $i++) {
                echo "<li><a href='" . get_pagenum_link($i) . "'";
                if ($i == $paged) echo " class='current'";
                echo ">$i</a></li>";
            }
        }
        $npl = "<span class='btn_next'></span>";
    }
    if ($max_page > 1) {
        echo '</ul>';
    }
}

function gt3_the_pb_custom_bg_and_color($gt3_theme_pagebuilder, $args = array())
{
    if (!isset($gt3_theme_pagebuilder['page_settings']['page_layout']['layout_type'])) {
        $gt3_theme_pagebuilder['page_settings']['page_layout']['layout_type'] = "default";
    }

    if ($gt3_theme_pagebuilder['page_settings']['page_layout']['layout_type'] == "default") {
        $layout_type = gt3_get_theme_option("default_layout");
        $bgimg_url = gt3_get_theme_option("bg_img");
        $bgpattern_url = gt3_get_theme_option("bg_pattern");
        $bgcolor_hash = gt3_get_theme_option("default_bg_color");
    } else {
        $layout_type = $gt3_theme_pagebuilder['page_settings']['page_layout']['layout_type'];
        $bgimg_url = wp_get_attachment_url($gt3_theme_pagebuilder['page_settings']['page_layout']['img']['attachid']);
        $bgpattern_url = wp_get_attachment_url($gt3_theme_pagebuilder['page_settings']['page_layout']['img']['attachid']);
        $bgcolor_hash = $gt3_theme_pagebuilder['page_settings']['page_layout']['color']['hash'];
    }

    if ($layout_type == "bgimage") {
        if (isset($args['classes_for_body']) && $args['classes_for_body'] == true) {
            return "gt3_boxed gt3_bg_image";
        } else {
            echo '<div class="custom_bg img_bg" style="background-image: url(\'' . $bgimg_url . '\'); background-color:#' . $bgcolor_hash . ';"></div>';
        }
        return true;
    }
    if ($layout_type == "boxed") {
        if (isset($args['classes_for_body']) && $args['classes_for_body'] == true) {
            return "gt3_boxed gt3_bg_pattern";
        } else {
            echo '<div class="custom_bg" style="background-image: url(\'' . $bgpattern_url . '\'); background-color:#' . $bgcolor_hash . ';"></div>';
        }
        return true;
    }
}

function gt3_the_check_fw_state($gt3_theme_pagebuilder)
{
    if (!isset($gt3_theme_pagebuilder['settings']['page_fullwidth']) || (isset($gt3_theme_pagebuilder['settings']['page_fullwidth']) && $gt3_theme_pagebuilder['settings']['page_fullwidth'] == "default")) {
        return gt3_get_theme_option("default_fw_state");
    } else {
        if ((isset($gt3_theme_pagebuilder['settings']['page_fullwidth']) && $gt3_theme_pagebuilder['settings']['page_fullwidth'] == "yes")) {
            return " fw";
        } else {
            return "";
        }
    }
}

if (!function_exists('gt3_get_default_pb_settings')) {
    function gt3_get_default_pb_settings()
    {

        $gt3_theme_pagebuilder['page_settings']['page_layout']['layout_type'] = gt3_get_theme_option("default_layout");
        $gt3_theme_pagebuilder['settings']['layout-sidebars'] = gt3_get_theme_option("default_sidebar_layout");
        $gt3_theme_pagebuilder['settings']['left-sidebar'] = "Default";
        $gt3_theme_pagebuilder['settings']['right-sidebar'] = "Default";
        $gt3_theme_pagebuilder['settings']['bg_image']['src'] = gt3_get_theme_option("bg_img");
        $gt3_theme_pagebuilder['settings']['custom_color']['status'] = gt3_get_theme_option("show_bg_color_by_default");
        $gt3_theme_pagebuilder['settings']['custom_color']['value'] = gt3_get_theme_option("default_bg_color");
        $gt3_theme_pagebuilder['settings']['bg_image']['type'] = gt3_get_theme_option("default_bg_img_position");

        return $gt3_theme_pagebuilder;
    }
}

if (!function_exists('gt3_get_selected_pf_images')) {
    function gt3_get_selected_pf_images($gt3_theme_pagebuilder)
    {
        if (!isset($compile)) {
            $compile = '';
        }
        if (isset($gt3_theme_pagebuilder['post-formats']['images']) && is_array($gt3_theme_pagebuilder['post-formats']['images'])) {
            if (count($gt3_theme_pagebuilder['post-formats']['images']) == 1) {
                $onlyOneImage = "oneImage";
            } else {
                $onlyOneImage = "";
            }
            $compile .= '
                <div class="slider-wrapper theme-default">
                    <div class="nivoSlider ' . $onlyOneImage . '">
            ';

            if (is_array($gt3_theme_pagebuilder['post-formats']['images'])) {
                foreach ($gt3_theme_pagebuilder['post-formats']['images'] as $imgid => $img) {
                    $compile .= '
                        <img src="' . aq_resize(wp_get_attachment_url($img['attach_id']), "1170", "563", true, true, true) . '" data-thumb="' . aq_resize(wp_get_attachment_url($img['attach_id']), "1170", "563", true, true, true) . '" alt="" />
                    ';
                }
            }

            $compile .= '
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

        wp_enqueue_script('gt3_nivo_js', get_template_directory_uri() . '/js/nivo.js', array(), false, true);
        return $compile;
    }
}

if (!function_exists('gt3_HexToRGB')) {
    function gt3_HexToRGB($hex = "ffffff")
    {
        $color = array();
        if (strlen($hex) < 1) {
            $hex = "ffffff";
        }

        if (strlen($hex) == 3) {
            $color['r'] = hexdec(substr($hex, 0, 1) . $r);
            $color['g'] = hexdec(substr($hex, 1, 1) . $g);
            $color['b'] = hexdec(substr($hex, 2, 1) . $b);
        } else if (strlen($hex) == 6) {
            $color['r'] = hexdec(substr($hex, 0, 2));
            $color['g'] = hexdec(substr($hex, 2, 2));
            $color['b'] = hexdec(substr($hex, 4, 2));
        }

        return $color['r'] . "," . $color['g'] . "," . $color['b'];
    }
}

if (!function_exists('gt3_smarty_modifier_truncate')) {
    function gt3_smarty_modifier_truncate($string, $length = 80, $etc = '... ',
                                          $break_words = false, $middle = false)
    {
        if ($length == 0)
            return '';

        if (mb_strlen($string, 'utf8') > $length) {
            $length -= mb_strlen($etc, 'utf8');
            if (!$break_words && !$middle) {
                $string = preg_replace('/\s+\S+\s*$/su', '', mb_substr($string, 0, $length + 1, 'utf8'));
            }
            if (!$middle) {
                return mb_substr($string, 0, $length, 'utf8') . $etc;
            } else {
                return mb_substr($string, 0, $length / 2, 'utf8') . $etc . mb_substr($string, -$length / 2, utf8);
            }
        } else {
            return $string;
        }
    }
}

function gt3_show_social_icons($array)
{
    $compile = "<ul class='socials_list'>";
    foreach ($array as $key => $value) {
        if (strlen(gt3_get_theme_option($value['uniqid'])) > 0) {
            $compile .= "<li><a class='" . $value['class'] . "' target='" . $value['target'] . "' href='" . gt3_get_theme_option($value['uniqid']) . "' title='" . $value['title'] . "'></a></li>";
        }
    }
    $compile .= "</ul>";
    if (is_array($array) && count($array) > 0) {
        return $compile;
    } else {
        return "";
    }
}

add_action("wp_head", "wp_head_mix_var");
function wp_head_mix_var()
{
    echo "<script>var " . GT3_THEMESHORT . "var = true;</script>";
}

function get_pf_type_output($args)
{
    $compile = "";
    extract($args);

    if (isset($pf) && ($pf == "image" || $pf == "video")) {
        $compile .= '<div class="pf_output_container">';

        /* Image */
        if ($pf == 'image') {
            $compile .= gt3_get_selected_pf_images($gt3_theme_pagebuilder);
        }

        /* Video */
        if ($pf == "video") {

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
                $compile .= "<div id='player{$uniqid}'></div>";

                array_push($allYTVideos, array("h" => $video_height, "w" => "100%", "videoid" => $videoid, "uniqid" => $uniqid));
            }

            #VIMEO
            $is_vimeo = substr_count($video_url, "vimeo");
            if ($is_vimeo > 0) {
                $videoid = substr(strstr($video_url, "m/"), 2);
                $compile .= "
            <iframe src=\"http://player.vimeo.com/video/" . $videoid . "\" width=\"100%\" height=\"" . $video_height . "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        ";
            }
        }

        $compile .= '</div>';
    }

    return $compile;
}

function init_YTvideo_in_footer()
{
    global $allYTVideos;
    $compile = "";
    $result = "";
    if (is_array($allYTVideos) && count($allYTVideos) > 0) {
        $compile .= "
        <script>
        var tag = document.createElement('script');
        tag.src = 'https://www.youtube.com/iframe_api';
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        function onPlayerReady(event) {}
        function onPlayerStateChange(event) {}
        function stopVideo() {
            player.stopVideo();
        }
        ";

        foreach ($allYTVideos as $key => $value) {
            $result .= "
            new YT.Player('player{$value['uniqid']}', {
                height: '{$value['h']}',
                width: '{$value['w']}',
                playerVars: { 'autoplay': 0, 'controls': 1 },
                videoId: '{$value['videoid']}',
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
            ";
        }
        $compile .= "function onYouTubeIframeAPIReady() {" . $result . "}</script>";
    }
    echo $compile;
}

add_action('wp_footer', 'init_YTvideo_in_footer');


function get_js_for_fw_block()
{
    return "
    <script>
        function fw_block() {
            if (jQuery('div').hasClass('right-sidebar') || jQuery('div').hasClass('left-sidebar')) {} else {
                var fw_block = jQuery('.fw_block');
                var fw_block_parent = fw_block.parent().width();
                var fw_site_width = jQuery(window).width();
                var fw_contentarea_site_width_diff = fw_site_width - fw_block_parent;

                fw_block.css('margin-left', '-'+fw_contentarea_site_width_diff/2+'px').css('width', fw_site_width+'px').children().css('padding-left', fw_contentarea_site_width_diff/2+'px').css('padding-right', fw_contentarea_site_width_diff/2+'px');
            jQuery('.module_google_map .fw_wrapinner, .module_wall .fw_wrapinner').css('padding-left', '0px').css('padding-right', '0px');
            }
        }
        jQuery(document).ready(function() {
            jQuery('.fw_block').wrapInner('<div class=\"fw_wrapinner\"></div>');
            fw_block();
        });
        jQuery(window).resize(function(){
            fw_block();
        });
    </script>
    ";
}

function showJSInFooter()
{
    if (isset($GLOBALS['showOnlyOneTimeJS']) && is_array($GLOBALS['showOnlyOneTimeJS'])) {
        foreach ($GLOBALS['showOnlyOneTimeJS'] as $id => $js) {
            echo $js;
        }
    }
}

add_action('wp_footer', 'showJSInFooter');

function gt3_the_header_type()
{
    $header_type = gt3_get_theme_option("header_type");
    if ($header_type == "type1" || $header_type == "type2") {
        $compile_header_type = "header_centered " . $header_type;
    } else {
        $compile_header_type = $header_type;
    }

    echo $compile_header_type;
}

function gt3_get_field_media_and_attach_id($name, $attach_id, $previewW = "200px", $previewH = null, $classname = "")
{
    return "<div class='select_image_root " . $classname . "'>
        <input type='hidden' name='" . $name . "' value='" . $attach_id . "' class='select_img_attachid'>
        <div class='select_img_preview'><img src='" . ($attach_id > 0 ? aq_resize(wp_get_attachment_url($attach_id), $previewW, $previewH, true, true, true) : "") . "' alt=''></div>
        <input type='button' class='button button-secondary button-large select_attach_id_from_media_library' value='Select'>
    </div>";
}

function gt3_get_logo()
{
    return '
    <a href="' . esc_url(home_url('/')) . '" class="logo" style="width:' . gt3_get_theme_option("header_logo_standart_width") . 'px;height:' . gt3_get_theme_option("header_logo_standart_height") . 'px;">
        <img src="' . gt3_get_theme_option("logo") . '" alt=""
             width="' . gt3_get_theme_option("header_logo_standart_width") . '"
             height="' . gt3_get_theme_option("header_logo_standart_height") . '" class="non_retina_image">
        <img src="' . gt3_get_theme_option("logo_retina") . '" alt=""
             width="' . gt3_get_theme_option("header_logo_standart_width") . '"
             height="' . gt3_get_theme_option("header_logo_standart_height") . '" class="retina_image">
    </a>
    ';
}

add_action( 'wp_ajax_add_like_post', 'gt3_add_like' );
add_action( 'wp_ajax_nopriv_add_like_post', 'gt3_add_like' );
function gt3_add_like() {
    $all_likes = gt3pb_get_option("likes");
    $post_id = $_POST['post_id'];
    $all_likes[$post_id] = (isset($all_likes[$post_id]) ? $all_likes[$post_id] : 0)+1;
    gt3pb_update_option("likes", $all_likes);
    echo $all_likes[$post_id];
    die();
}

require_once("core/loader.php");