<?php

class partners_shortcode
{
    public function register_shortcode($shortcodeName)
    {
        function shortcode_partners($atts, $content = null)
        {
            if (!isset($compile)) {
                $compile = '';
            }

            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'cpt_ids' => '0',
                'partners_in_line' => 1,
                'url' => '',
            ), $atts));

            if ($partners_in_line < 1) {
                $partners_in_line = 1;
            }
            $item_width = (100 / $partners_in_line) - 0.5;

            #heading
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            } else {
                $custom_color = '';
            }
            if (strlen($heading_text) > 0) {
                $compile = "<div class='bg_title'><" . $heading_size . " style='" . $custom_color . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:' . $heading_alignment . ';' : '') . "' class='headInModule'>{$heading_text}</" . $heading_size . "></div>";
            }

            $wp_query = new WP_Query();

            if (strlen($cpt_ids) > 0 && $cpt_ids !== "0") {
                $cpt_ids = explode(",", $cpt_ids);
            }

            if (is_array($cpt_ids) && count($cpt_ids) > 0) {
                $args = array(
                    'post_type' => 'partners',
                    'post__in' => $cpt_ids,
                    'posts_per_page' => -1,
                    'order' => 'DESC'
                );
            } else {
                $args = array(
                    'post_type' => 'partners',
                    'posts_per_page' => -1,
                    'order' => 'DESC'
                );
            }

            $wp_query->query($args);

            $compile .= '<div class="module_content grid_elements">';
            while ($wp_query->have_posts()) : $wp_query->the_post();
                $gt3_theme_pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);
                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
                if (strlen($featured_image[0]) > 0) {
                    $featured_image_url = $featured_image[0];
                } else {
                    $featured_image_url = "";
                }

                $partners_url = (isset($gt3_theme_pagebuilder['page_settings']['partners']['partners_link']) ? $gt3_theme_pagebuilder['page_settings']['partners']['partners_link'] : "");

                $compile .= '
                <div style="width:' . $item_width . '%" class="item">
                    <div class="ip">
                        <div class="item_wrapper">
                            ' . (strlen($partners_url) > 0 ? "<a href='{$partners_url}' target='_blank'>" : "") . '<img src="' . $featured_image_url . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" />' . (strlen($partners_url) > 0 ? "</a>" : "") . '
                        </div>
					</div>
                </div>

            ';
            endwhile;

            $compile .= '</div>';

            wp_reset_query();

            return $compile;
        }

        add_shortcode($shortcodeName, 'shortcode_partners');
    }
}


#Shortcode name
$shortcodeName = "partners";
$partners = new partners_shortcode();
$partners->register_shortcode($shortcodeName);

?>