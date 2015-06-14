<?php

class blog_shortcode
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_blog($atts, $content = null)
        {
            wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);

            $compile = '';
            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'posts_per_page' => '10',
                'posts_per_line' => '3',
                'masonry' => 'no',
                'view_type' => '',
                'cat_ids' => 'all',
            ), $atts));

            #heading
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            } else {
                $custom_color = '';
            }
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title'><" . $heading_size . " style='" . $custom_color . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:' . $heading_alignment . ';' : '') . "' class='headInModule'>{$heading_text}</" . $heading_size . "></div>";
            }

            global $wp_query_in_shortcodes, $paged;

            if (empty($paged)) {
                $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            }

            $wp_query_in_shortcodes = new WP_Query();
            $args = array(
                'post_type' => 'post',
                'paged' => $paged,
                'posts_per_page' => $posts_per_page,
            );

            if ($cat_ids !== "all" && $cat_ids !== "") {
                $args['cat'] = $cat_ids;
            }

            $wp_query_in_shortcodes->query($args);

            $compile .= '<div class="'.(($view_type == "masonry" || $view_type == "grid") ? 'isotope_here isotope_preloader' : '').' '.$view_type.'">';

            while ($wp_query_in_shortcodes->have_posts()) : $wp_query_in_shortcodes->the_post();

                $gt3_theme_pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);
                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'single-post-thumbnail');

                if (get_the_category()) $categories = get_the_category();
                $post_categ = '';
                $separator = ', ';
                if ($categories) {
                    foreach ($categories as $category) {
                        $post_categ = $post_categ . '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>' . $separator;
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

                $all_likes = gt3pb_get_option("likes");
                /* ADD 1 view for this post */
                $post_views = (get_post_meta(get_the_ID(), "post_views", true) > 0 ? get_post_meta(get_the_ID(), "post_views", true) : "0");
                update_post_meta(get_the_ID(), "post_views", (int)$post_views + 1);

                if ($view_type == "masonry" || $view_type == "grid") {
                    $compile .= '
                    <div class="isotope_item">
                        <div class="innerpadding">
                            <div class="module_fader">
                                <img src="' . aq_resize($featured_image[0], "1170", (($view_type == "masonry") ? null : "1170"), true, true, true) . '" alt="">
                            </div>
                            <a class="blogpost_title" href="' . get_permalink() . '"><h1>' . get_the_title() . '</h1></a>
                            <span class="preview_meta_date">' . get_the_time("M") . ' ' . get_the_time("d") . ', </span>
                            <span class="preview_meta_comments"><a href="' . get_comments_link() . '">Сomments: ' . get_comments_number(get_the_ID()) . '</a></span>
                        </div>
                    </div>';

                    wp_enqueue_script('gt3_isotope_js', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array(), false, true);

                    $GLOBALS['showOnlyOneTimeJS']['isotope2'] = '
                    <script>
                        function isotope_padding() {
                            if (jQuery("body").hasClass("fw")) {
                                var wrapper_width = jQuery(".wrapper").width();
                                var body_fw_width = jQuery("body.fw").width();
                                var dif_padding = (body_fw_width - wrapper_width) / 2;
                                jQuery(".isotope_here").css("margin-left", "-"+dif_padding+"px");
                                jQuery(".isotope_here .innerpadding").css("padding-left", dif_padding+"px");
                            }
                        }

                        function isotope_init() {
                            isotope_padding();
                            var $container = jQuery(".isotope_here");
                            $container.isotope({
                                itemSelector: ".isotope_item"'.($view_type == "grid" ? ',
                                layoutMode: "fitRows"': '').'
                            });

                            $container.isotope( "on", "layoutComplete", function(){ jQuery(".isotope_preloader").removeClass("isotope_preloader")} );
                        }

                        jQuery(document).ready(function(){
                            isotope_init();
                        });

                        jQuery(window).load(function () {
                            isotope_init();
                        });
                    </script>
                    ';
                }

                if ($view_type == "fullwidth") {
                    $compile .= '<div class="row stand_post">';

                    if (get_post_format() == "image" || get_post_format() == "video" || strlen($featured_image[0])>0) {
                        $compile .= '<div class="span8">';

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

                                $compile .= $compile_pf;
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

                            $compile .= $compile_pf;
                        } else {
                            $compile .= '<img src="' . aq_resize($featured_image[0], "1270", "700", true, true, true) . '" alt="" />';
                        }

                        $compile .= '</div>';
                    }

                    if (get_post_format() == "image" || get_post_format() == "video" || strlen($featured_image[0])>0) {
                        $compile .= '<div class="span4">';
                    } else {
                        $compile .= '<div class="span12">';
                    }

                    $compile .= '
                    <h1 class="entry-title blogpost_title">' . get_the_title() . '</h1>
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
                            $compile .= '
                            <div class="block_post_meta_stand block_tags">
                                <i class="icon-tags"></i>
                                ' . $post_tags_compile . '
                            </div>
                            ';
                        }

                        $compile .= '
                    </div>
                    <article>
                        ' . ((strlen(get_the_excerpt()) > 0) ? get_the_excerpt() : get_the_content()) . '
                    </article>

                    <a href="'.get_permalink().'" class="post_read_more_small">'.__('Read More &rsaquo;', 'theme_localization').'</a>
                    ';

                    $compile .= '</div>';

                    $compile .= '</div>';
                }

            endwhile;


            $compile .= '</div>';

            $compile .= get_plugin_pagination("10", "show_in_shortcodes");

            wp_reset_query();

            return $compile;
        }

        add_shortcode($shortcodeName, 'shortcode_blog');
    }
}

#Shortcode name
$shortcodeName = "blog";
$blog = new blog_shortcode();
$blog->register_shortcode($shortcodeName);

?>