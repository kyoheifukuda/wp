<?php

class show_wall {

    public function register_shortcode($shortcodeName) {
        function shortcode_show_wall($atts, $content = null) {

            wp_enqueue_script('gt3_prettyPhoto_js', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array(), false, true);
            wp_enqueue_script('gt3_masonry_js', get_template_directory_uri() . '/core/plugins/gt3-pagebuilder/js/masonry.min.js', array(), false, true);

            $compile = "";

            extract( shortcode_atts( array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'preview_thumbs_format' => 'rectangle',
                'images_in_a_row' => '4',
                'galleryid' => '',
            ), $atts ) );

            switch($images_in_a_row) {
                case 3:
                    $width = 800;
                    break;
                case 4:
                    $width = 600;
                    break;
                case 5:
                    $width = 500;
                    break;
                case 6:
                    $width = 400;
                    break;
                case 7:
                    $width = 300;
                    break;
            }

            $height = $width;

            $div_width = 100/$images_in_a_row-0.01;

            #heading
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title'><".$heading_size." style='".(isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '')."' class='headInModule'>{$heading_text}</".$heading_size."></div>";
            }

            $GLOBALS['showOnlyOneTimeJS']['fw_block'] = "
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

            $compile .= '
			<div class="fw_block">
			    <div class="items' . $images_in_a_row . ' featured_wall" data-count="' . $images_in_a_row . '">
			';

            $wallPageBuilder = get_plugin_pagebuilder($galleryid);

            if (isset($wallPageBuilder['sliders']['fullscreen']['slides']) && is_array($wallPageBuilder['sliders']['fullscreen']['slides'])) {
                foreach ($wallPageBuilder['sliders']['fullscreen']['slides'] as $imageid => $image) {

                    if (isset($image['title']['value']) && strlen($image['title']['value'])>0) {$photoTitleOutput = $image['title']['value'];} else {$photoTitleOutput = "";}
                    if (isset($image['caption']['value']) && strlen($image['caption']['value'])>0) {$photoCaption  = $image['caption']['value'];} else {$photoCaption = "";}

                    $compile .= '
                            <div class="item" style="width:'.$div_width.'%;">
                                <div class="img_block wrapped_img">
                                    <div class="featured_item_fadder">
                                        <img src="'.aq_resize((($image['slide_type'] == "image") ? $image['src'] : $image['thumbnail']['value']), $width, $height, true, true, true).'" />
                                        <a class="featured_ico_link prettyPhoto" rel="wall[]" href="'.$image['src'].'"><span></span></a>
                                    </div>
                                </div>

                            </div>
                        ';

                    unset($photoTitleOutput, $photoCaption);
                }
            }

            $compile .= "
                    <div class='clear'></div>
                </div>
            </div>
            ";
            $GLOBALS['showOnlyOneTimeJS']['prettyPhoto'] = "
			<script>
				jQuery(document).ready(function($) {
					$('.prettyPhoto').prettyPhoto();
				});
			</script>
			";

            $GLOBALS['showOnlyOneTimeJS']['masonry'] = "
			<script>
                jQuery(window).load(function() {
                    jQuery('.featured_wall').masonry({
                      itemSelector: '.item'
                    });
                    jQuery('.featured_wall .item').each(function( index ) {
                        jQuery(this).css( 'opacity', '1' );
                    });
                });
			</script>
			";

            return $compile;

        }
        add_shortcode($shortcodeName, 'shortcode_show_wall');
    }
}

#Shortcode name
$shortcodeName="show_wall";
$shortcode_show_wall = new show_wall();
$shortcode_show_wall->register_shortcode($shortcodeName);

?>