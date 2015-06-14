<?php

class show_gallery {

	public function register_shortcode($shortcodeName) {
		function shortcode_show_gallery($atts, $content = null) {
			
			wp_enqueue_script('gt3_prettyPhoto_js', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array(), false, true);

            $compile = "";

			extract( shortcode_atts( array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'preview_thumbs_format' => 'rectangle',
                'images_in_a_row' => '4',
                'width' => $GLOBALS["pbconfig"]['gallery_module_default_width'],
                'height' => $GLOBALS["pbconfig"]['gallery_module_default_height'],
                'galleryid' => '',
			), $atts ) );

            switch($images_in_a_row) {
                case 1:
                    $width = 1170;
                    break;
                case 2:
                    $width = 600;
                    break;
                case 3:
                    $width = 600;
                    break;
                case 4:
                    $width = 600;
                    break;
            }

            $height = $width;

            if ($preview_thumbs_format == "rectangle") {
                $height = 70*$width/100;

                /* Spike */
                if ($images_in_a_row == 1) {
                    $height = 71.6*$width/100;
                }
            }

            $width = $width."px";
            $height = $height."px";

            #heading
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title'><".$heading_size." style='".(isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '')."' class='headInModule'>{$heading_text}</".$heading_size."></div>";
            }

			$compile .= '

            <div class="featured_items clearfix">
		    	<div class="main items' . $images_in_a_row . '" data-count="' . $images_in_a_row . '">
		    	    <ul class="item_list">
			';

            $galleryPageBuilder = get_plugin_pagebuilder($galleryid);

            if (isset($galleryPageBuilder['sliders']['fullscreen']['slides']) && is_array($galleryPageBuilder['sliders']['fullscreen']['slides'])) {
                foreach ($galleryPageBuilder['sliders']['fullscreen']['slides'] as $imageid => $image) {

                    if (isset($image['title']['value']) && strlen($image['title']['value'])>0) {$photoTitleOutput = $image['title']['value'];} else {$photoTitleOutput = "";}
                    if (isset($image['caption']['value']) && strlen($image['caption']['value'])>0) {$photoCaption  = $image['caption']['value'];} else {$photoCaption = "";}

                        $compile .= '
                        <li>
                            <div class="item">
                                <a class="prettyPhoto" href="'.wp_get_attachment_url($image['attach_id']).'" rel="prettyphoto[gal]"><img src="'.aq_resize(wp_get_attachment_url($image['attach_id']), $width, $height, true, true, true).'" /></a>
                            </div>
                        </li>';

                    unset($photoTitleOutput, $photoCaption);
                }
            }

			$compile .= "
                    </ul>
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
			
			return $compile;
			
		}
		add_shortcode($shortcodeName, 'shortcode_show_gallery');
	}
}

#Shortcode name
$shortcodeName="show_gallery";
$shortcode_show_gallery = new show_gallery();
$shortcode_show_gallery->register_shortcode($shortcodeName);

?>