<?php

class feature_portfolio
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_feature_portfolio($atts, $content = null)
        {
			wp_enqueue_script('gt3_prettyPhoto_js', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array(), false, true);
	
            $compile = '';
            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'number_of_posts' => $GLOBALS["pbconfig"]['featured_portfolio_default_number_of_posts'],
                'posts_per_line' => '2',
                'selected_categories' => '',
                'sorting_type' => "new",
            ), $atts));

            #heading
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            }
            if (strlen($heading_text) > 0) {
                $compile = "<div class='bg_title'><" . $heading_size . " style='" . (isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:' . $heading_alignment . ';' : '') . "' class='headInModule'>{$heading_text}</" . $heading_size . "></div>";
            }

            #sort converter
            switch ($sorting_type) {
                case "new":
                    $sort_type = "post_date";
                    break;
                case "random":
                    $sort_type = "rand";
                    break;
            }

            $compile .= '
        <div class="featured_items clearfix">
            <div class="items' . $posts_per_line . ' featured_portfolio" data-count="' . $posts_per_line . '">
                <ul class="item_list">
        ';

            if (strlen($selected_categories) > 0) {
                $post_type_terms = explode(",", $selected_categories);
            } else {
                $post_type_terms = array();
            }
            $wp_query = new WP_Query();
            $args = array(
                'post_type' => 'port',
                'posts_per_page' => $number_of_posts,
                'ignore_sticky_posts' => 1,
                'orderby' => $sort_type,
            );

            if (count($post_type_terms) > 0) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'portcat',
                        'field' => 'id',
                        'terms' => $post_type_terms
                    )
                );
            }

            $wp_query->query($args);

            while ($wp_query->have_posts()) : $wp_query->the_post();

                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');

                if (strlen($featured_image[0]) > 0) {
                    $featured_image_url = aq_resize($featured_image[0], "570", "400", true, true, true);
                    $full_image_url = $featured_image[0];
                    $featured_image_full = '<div class="img_block wrapped_img"><div class="featured_item_fadder"><img width="570" height="400" src="' . $featured_image_url . '" /><a class="featured_ico_link" href="' . get_permalink(get_the_ID()) . '"><span></span></a></div></div>';
                } else {
                    $featured_image_full = '';
                }

                $post = get_post();
                $post_excerpt = ((strlen($post->post_excerpt) > 0) ? $post->post_excerpt : smarty_modifier_truncate(get_the_content(), 100));

                $new_term_list = get_the_terms(get_the_id(), "portcat");
                $echoallterm = "";
                if (is_array($new_term_list)) {
                    foreach ($new_term_list as $term) {
                        $echoallterm .= "<a href='".get_term_link($term->slug, "portcat")."'>". $term->name. "</a>, ";
                    }
                } else {
                    $tempname = 'Uncategorized';
                }

                $compile .= '
                    <li>
                        <div class="item">
                            ' . $featured_image_full . '
                            <div class="featured_items_body">
                                <div class="featured_items_title">
                                    <h6><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h6>
                                </div>
                                <div class="fp_cat">
                                    ' . trim($echoallterm, ', ') . '
                                </div>';
                                /*<div class="featured_item_content">
                                   ' . smarty_modifier_truncate($post_excerpt, 100) . '
                                    <a href="' . get_permalink(get_the_ID()) . '">' . __('Read more!', 'gt3_builder') . '</a>
                                </div>*/
                $compile .= '</div>
                        </div>
                    </li>
                    ';

            endwhile;

            $compile .= '
                </ul>
            </div>
        </div>
        ';

        $GLOBALS['showOnlyOneTimeJS']['prettyPhoto'] = "
		<script>
			jQuery(document).ready(function($) {
				$('.prettyPhoto').prettyPhoto();
			});
		</script>
		";

            wp_reset_query();

            return $compile;

        }

        add_shortcode($shortcodeName, 'shortcode_feature_portfolio');
    }
}

#Shortcode name
$shortcodeName = "feature_portfolio";
$shortcode_feature_portfolio = new feature_portfolio();
$shortcode_feature_portfolio->register_shortcode($shortcodeName);
?>