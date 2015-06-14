<?php

class iconbox_shortcode
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_iconbox($atts, $content = null)
        {

            if (!isset($compile)) {
                $compile = '';
            }

            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'iconbox_heading' => '',
                'button_link' => '',
                'button_text' => '',
                'icon_type' => '',
                'target' => '_blank',
                'link' => '',
            ), $atts));

            #heading
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            }
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title'><" . $heading_size . " style='" . (isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:' . $heading_alignment . ';' : '') . "' class='headInModule'>{$heading_text}</" . $heading_size . "></div>";
            }

            $compile .= "
			<div class='module_content shortcode_iconbox'>
				" . ((strlen($link) > 0) ? "<a target='" . $target . "' href='" . $link . "'>" : "") . "
				<div class='iconbox_wrapper'>
					<div class='iconbox_header'>
						<span class='ico'><i class=" . $icon_type . "></i></span>
						<h5 class='iconbox_title'>" . $iconbox_heading . "</h5>
					</div>
					<div class='iconbox_body'>						
						" . $content . "
					</div>					
				</div>
				" . ((strlen($link) > 0) ? "</a>" : "") . "
			</div>
			";
            return $compile;
        }

        add_shortcode($shortcodeName, 'shortcode_iconbox');
    }
}

#Shortcode name
$shortcodeName = "iconbox";
#Register shortcode & set parameters
$iconbox = new iconbox_shortcode();
$iconbox->register_shortcode($shortcodeName);

?>