<?php

class portfolio_shortcode
{
    public function register_shortcode($shortcodeName)
    {
        function shortcode_portfolio($atts, $content = null)
        {
			$compile='';

            wp_enqueue_script('gt3_prettyPhoto_js', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array(), false, true);
            wp_enqueue_script('gt3_isotope_js', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array(), false, true);

            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'posts_per_page' => '4',
                'view_type' => '1 column',
                'filter' => 'on',
                'selected_categories' => '',
                'default_state' => '',
            ), $atts));

            #heading
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            }
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title'><" . $heading_size . " style='" . $custom_color . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:' . $heading_alignment . ';' : '') . "' class='headInModule'>{$heading_text}</" . $heading_size . "></div>";
            }

            switch ($view_type) {
                case "1 column":
                    $view_type_class = "columns1";
                    BREAK;
                case "2 columns":
                    $view_type_class = "columns2";
                    BREAK;
                case "3 columns":
                    $view_type_class = "columns3";
                    BREAK;
                case "4 columns":
                    $view_type_class = "columns4";
                    BREAK;
                case "Grid":
                    $view_type_class = "grid";
                    BREAK;
                case "Masonry":
                    $view_type_class = "masonry";
                    BREAK;
            }

            $post_type_terms = array();
            if (strlen($selected_categories) > 0) {
                $post_type_terms = explode(",", $selected_categories);
            }

            #Filter
            #if ($filter == "on") {
            $compile .= showPortCats($post_type_terms);
            #}

            $compile .= '<div class="portfolio_block ' . $view_type_class . '"><div class="portwrap '.($default_state == "Masonry/Grid" ? "now_grid_masonry_view" : "now_inline_view").' '.(($view_type == "Masonry" || $view_type == "Grid") ? "isotope_init isotope_preloader" : "").'">';
            global $wp_query_in_shortcodes;
            $wp_query_in_shortcodes = new WP_Query();
            global $paged;
            $args = array(
                'post_type' => 'port',
                'order' => 'DESC',
                'paged' => $paged,
                'posts_per_page' => $posts_per_page,
            );

            if (isset($_GET['slug']) && strlen($_GET['slug']) > 0) {
                $post_type_terms = $_GET['slug'];
            }
            if (count($post_type_terms) > 0) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'portcat',
                        'field' => 'id',
                        'terms' => $post_type_terms
                    )
                );
            }

            $wp_query_in_shortcodes->query($args);

            $i = 1;

            while ($wp_query_in_shortcodes->have_posts()) : $wp_query_in_shortcodes->the_post();

                $pf = get_post_format();
                if (empty($pf)) $pf = "text";
                $gt3_theme_pagebuilder = get_plugin_pagebuilder(get_the_ID());

                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'single-post-thumbnail');
                if (strlen($featured_image[0]) < 1) {
                    $featured_image[0] = "";
                }

                if (isset($gt3_theme_pagebuilder['page_settings']['portfolio']['work_link']) && strlen($gt3_theme_pagebuilder['page_settings']['portfolio']['work_link']) > 0) {
                    $linkToTheWork = $gt3_theme_pagebuilder['page_settings']['portfolio']['work_link'];
                    $target = "target='_blank'";
                } else {
                    $linkToTheWork = get_permalink();
                    $target = "";
                }

                if (!isset($echoallterm)) {
                    $echoallterm = '';
                }
                $new_term_list = get_the_terms(get_the_id(), "portcat");
                if (is_array($new_term_list)) {
                    foreach ($new_term_list as $term) {
                        $tempname = strtr($term->name, array(
                            ' ' => ', ',
                        ));
                        $echoallterm .= strtolower($tempname) . " ";
                        $echoterm = $term->name;
                    }
                } else {
                    $tempname = 'Uncategorized';
                }


                #Portfolio 1
                if ($view_type == "1 column") {
					$port_content_show = ((strlen(get_the_excerpt()) > 0) ? get_the_excerpt() : smarty_modifier_truncate(get_the_content(), 300));

                    $compile .= '
                    <div class="portfolio_item">';
                    if (strlen($featured_image[0])>0) {
                        $compile .= '
                        <div class="portfolio_item_img featured_item_fadder">
                            <a ' . $target . ' href="' . $linkToTheWork . '">
                                <img src="' . aq_resize($featured_image[0], "712", "380", true, true, true) . '" alt="">
                                <span></span>
                            </a>
                        </div>
                        ';
                    }
                    $compile .= '
                        <div class="portfolio_dscr blog_post_preview">
                            <div class="preview_wrapper">
                                <div class="preview_topblock">
                                    <a class="blogpost_title" href="' . $linkToTheWork . '"><h1>' . get_the_title() . '</h1></a>
                                    <div class="preview_meta">
                                        <span class="preview_meta_author">
                                            by <a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">' . get_the_author_meta('display_name') . '</a>
                                        </span>
                                        <span class="preview_categ">in ' . trim($tempname, ', ') . '</span>';
                                        if (isset($gt3_theme_pagebuilder['page_settings']['portfolio']['skills']) && is_array($gt3_theme_pagebuilder['page_settings']['portfolio']['skills'])) {
                                            foreach ($gt3_theme_pagebuilder['page_settings']['portfolio']['skills'] as $skillkey => $skillvalue) {
                                                $compile .= '<span class="preview_skills">' . $skillvalue['name'] . ': ';
                                                $compile .= $skillvalue['value'] . '</span>';
                                            }
                                        }

                    $compile .= '
                                    </div>
                                </div>
                                <article class="contentarea">
                                    ' . $port_content_show . ' <a href="'.get_permalink(get_the_id()).'">'. __('Read more!', 'gt3_builder') .'</a>
                                </article>
                            </div>
                        </div>
                    </div>';
                }
                #END Portfolio 1


                #Portfolio 2
                if ($view_type == "2 columns") {
                    $compile .= '
                        <div class="portfolio_item">
                            <div class="portfolio_item_img featured_item_fadder">
                                <a ' . $target . ' href="' . $linkToTheWork . '">
                                    <img src="' . aq_resize($featured_image[0], "600", "450", true, true, true) . '" alt="">
                                    <span></span>
                                </a>
                            </div>
                            <a class="portfolio_item_title" href="'.get_permalink().'"><h4>'.get_the_title().'</h4></a>
                        </div>
                    ';
                }
                #END Portfolio 2


                #Portfolio 3
                if ($view_type == "3 columns") {
                    $compile .= '
                        <div class="portfolio_item">
                            <div class="portfolio_item_img featured_item_fadder">
                                <a ' . $target . ' href="' . $linkToTheWork . '">
                                    <img src="' . aq_resize($featured_image[0], "600", "450", true, true, true) . '" alt="">
                                    <span></span>
                                </a>
                            </div>
                            <a class="portfolio_item_title" href="'.get_permalink().'"><h4>'.get_the_title().'</h4></a>
                        </div>
                    ';
                }
                #END Portfolio 3


                #Portfolio 4
                if ($view_type == "4 columns") {
                    $compile .= '
                        <div class="portfolio_item">
                            <div class="portfolio_item_img featured_item_fadder">
                                <a ' . $target . ' href="' . $linkToTheWork . '">
                                    <img src="' . aq_resize($featured_image[0], "600", "450", true, true, true) . '" alt="">
                                    <span></span>
                                </a>
                            </div>
                            <a class="portfolio_item_title" href="'.get_permalink().'"><h4>'.get_the_title().'</h4></a>
                        </div>
                    ';
                }
                #END Portfolio 4


                #Masonry
                if ($view_type == "Masonry" || $view_type == "Grid") {

                    $draught_links = array();
                    $new_term_list = get_the_terms(get_the_id(), "portcat");
                    if (is_array($new_term_list)) {
                        foreach ($new_term_list as $term) {
                            $draught_links[] = '<a href="'.get_term_link($term->slug, "portcat").'">'.$term->name.'</a>';
                        }
                    }
                    $draught_links = implode($draught_links, ",");

                    $compile .= '
                        <div data-category="' . $echoallterm . '" class="' . $echoallterm . ' element portfolio_item item">
                            <div class="innerpadding">
                                <div class="portfolio_item_img featured_item_fadder">
                                    <a ' . $target . ' href="' . $linkToTheWork . '">
                                        <img src="' . aq_resize($featured_image[0], "1170", ($view_type == "Masonry" ? null : "1170"), true, true, true) . '" alt="">
                                    </a>
                                </div>
                                <a class="portfolio_item_title" href="'.get_permalink().'"><h4>'.get_the_title().'</h4></a>
                                <div class="preview_categ">' . trim($draught_links, ', ') . '</div>
                            </div>
                        </div>
                    ';

                    $GLOBALS['showOnlyOneTimeJS']['isotope'] = '
                    <script>
                        function portfolio_isotope_padding() {
                            if (jQuery("body").hasClass("fw")) {
                                var wrapper_width = jQuery(".wrapper").width();
                                var body_fw_width = jQuery("body.fw").width();
                                var dif_padding = (body_fw_width - wrapper_width) / 2;
                                jQuery(".portwrap").css("margin-left", "-"+dif_padding+"px");
                                jQuery(".portwrap .innerpadding").css("padding-left", dif_padding+"px");
                            }
                        }

                        function portfolio_isotope_init() {
                            portfolio_isotope_padding();
                            var $container = jQuery(".isotope_init");
                            $container.isotope({
                                itemSelector: ".portfolio_item",
                                filter: ".optionset"'.($view_type == "Grid" ? ', layoutMode: "fitRows"' : '').'
                            });

                            jQuery(".optionset").on( "click", "li a", function() {
                                var filterValue = jQuery(this).attr("data-option-value");
                                jQuery(".optionset li").removeClass("selected");
                                jQuery(this).parent().addClass("selected");
                                $container.isotope({ filter: filterValue });
                            });

                            jQuery(".optionset li").eq(2).find("a").click();
                            $container.isotope( "once", "layoutComplete", function(){ jQuery(".isotope_preloader").removeClass("isotope_preloader")} );
                        }

                        jQuery(document).ready(function(){
                            '.($default_state == "Masonry/Grid" ? "jQuery('.grid_masonry_view').addClass('active');" : "jQuery('.inline_view').addClass('active');").'
                            jQuery(".grid_masonry_view").click(function(){
                                jQuery(".inline_view").removeClass("active");
                                jQuery(this).addClass("active");
                                jQuery(".portwrap").removeClass("now_inline_view").addClass("now_grid_masonry_view");
                                portfolio_isotope_init();
                            });
                            jQuery(".inline_view").click(function(){
                                jQuery(".grid_masonry_view").removeClass("active");
                                jQuery(this).addClass("active");
                                jQuery(".portwrap").removeClass("now_grid_masonry_view").addClass("now_inline_view");
                                portfolio_isotope_init();
                            });
                            portfolio_isotope_init();
                        });

                        jQuery(window).load(function () {
                            portfolio_isotope_init();
                        });
                    </script>
                    ';
                }
                #END Masonry

                $i++;
                unset($echoallterm, $pf);
            endwhile;
            $compile .= '<div class="clear"></div></div></div>';

            $compile .= get_plugin_pagination(10, "show_in_shortcodes");

            wp_reset_query();
            return $compile;
        }

        add_shortcode($shortcodeName, 'shortcode_portfolio');
    }
}

#Shortcode name
$shortcodeName = "portfolio";
$portfolio = new portfolio_shortcode();
$portfolio->register_shortcode($shortcodeName);
?>