<?php

class map {
	public function register_shortcode($shortcodeName) {
		function shortcode_map($atts, $content = null) {

			extract( shortcode_atts( array(
              'heading_alignment' => 'left',
			  'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
			  'heading_color' => '',
			  'heading_text' => '',
			), $atts ) );

            #heading
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
			    $compile .= "<div class='bg_title'><".$heading_size." style='".(isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '')."' class='headInModule'>{$heading_text}</".$heading_size."></div>";
            }

			$compile .= "
			<div class='module_content'>
			    ".do_shortcode($content)."
			</div>";

            return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_map');
	}
}

#Shortcode name
$shortcodeName="map";
$shortcode_map = new map();
$shortcode_map->register_shortcode($shortcodeName);

?>