<?php

class ourteam
{
    public function register_shortcode($shortcodeName)
    {
        function shortcode_ourteam($atts, $content = null)
        {
            $compile = '';
            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'order' => 'ASC',
                'cpt_ids' => '0',
                'items_per_line' => '1',
            ), $atts));

            if ($items_per_line < 1) {
                $items_per_line = 1;
            }
            $item_width = (100 / $items_per_line) - 0.5;

            #heading
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            }
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title'><" . $heading_size . " style='" . (isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:' . $heading_alignment . ';' : '') . "' class='headInModule'>{$heading_text}</" . $heading_size . "></div>";
            }

            $wp_query = new WP_Query();

            if (strlen($cpt_ids) > 0 && $cpt_ids !== "0") {
                $cpt_ids = explode(",", $cpt_ids);
            }

            if (is_array($cpt_ids) && count($cpt_ids) > 0) {
                $args = array(
                    'post_type' => 'team',
                    'post__in' => $cpt_ids,
                    'order' => $order
                );
            } else {
                $args = array(
                    'post_type' => 'team',
                    'order' => $order
                );
            }

            $compile .= "<div class='grid_elements'>";

            $wp_query->query($args);
            while ($wp_query->have_posts()) : $wp_query->the_post();
                $gt3_theme_pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);
                $position = $gt3_theme_pagebuilder['page_settings']['team']['position'];

                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');

                $compile .= '
					<div style="width:' . $item_width . '%" class="item">
					    <div class="ip">
                            <div class="img_block">';
            if (has_post_thumbnail()) {
                $compile .= '<img src="' . aq_resize($featured_image[0], "840", "622", true, true, true) . '" alt="' . get_the_title() . '" />';
            }

            $compile .= '
                            </div>
                            <div class="meta_body">
                                <h6>' . get_the_title() . '</h6>
                                <div class="op">' . $position . '</div>
                                <div class="team_desc">' . get_the_content() . '</div>
                                <div class="team_icons_wrapper">';
            if (isset($gt3_theme_pagebuilder['page_settings']['icons']) ? $socicons = $gt3_theme_pagebuilder['page_settings']['icons'] : $socicons = false) ;
            if (is_array($socicons)) {
                foreach ($socicons as $key => $value) {
                    if ($value['link'] == '') $value['link'] = '#';
                    $compile .= '<a href="' . $value['link'] . '" class="teamlink" title="' . $value['name'] . '" data-fcolor="' . $value['fcolor'] . '"><span><i class="' . $value['data-icon-code'] . '"></i></span></a>';
                }
            }
            $compile .= '   		</div>
                            </div>
                        </div>
                    </div>
				';

                $GLOBALS['showOnlyOneTimeJS']['team'] = '
                <script>
                    jQuery(document).ready(function(){
                        jQuery( ".teamlink" ).hover(
                            function() {
                                var team_hover_color = jQuery(this).attr("data-fcolor");
                                jQuery(this).addClass("hover").find("i").css("color", "#"+team_hover_color);
                            }, function() {
                                jQuery(this).removeClass("hover").find("i").css("color", "#313131");
                            }
                        );
                    });
                </script>
                ';

            endwhile;
            wp_reset_query();

            $compile .= '
        <div class="clear"></div></div>';
            return $compile;
        }

        add_shortcode($shortcodeName, 'shortcode_ourteam');
    }
}

#Shortcode name
$shortcodeName = "ourteam";
$shortcode_ourteam = new ourteam();
$shortcode_ourteam->register_shortcode($shortcodeName);

?>