<?php

class messagebox_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_messagebox($atts, $content = null) {

            if (!isset($compile)) {$compile='';}

			extract( shortcode_atts( array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'messagebox_heading' => '',
                'box_type' => '',
                'icon_type' => '',
			), $atts ) );

            #heading
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title'><".$heading_size." style='".(isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '')."' class='headInModule'>{$heading_text}</".$heading_size."></div>";
            }
			if ($icon_type == '') {
				$option_class = 'no_icon';
			} else {
				$option_class = '';
			}
			$compile .= "
			<div class='module_content clearfix ".$option_class." shortcode_messagebox ".$box_type."'>
				<div class='box_content'>
				    <div class='innerpadding'><i class=".$icon_type."></i> ".str_replace(array("<p>", "</p>"), "", $content)."</div>
				</div>
                <a class='box_close' href='javascript:void(0)'></a>
			</div>
			";

            $GLOBALS['showOnlyOneTimeJS']['messageboxes'] = "
            <script>
                jQuery(document).ready(function($) {
                    $('.module_messageboxes .box_close').click(function(){
                        $(this).parents('.module_messageboxes').fadeOut();
                    });
                });
            </script>
            ";

			return $compile;

		}
		add_shortcode($shortcodeName, 'shortcode_messagebox');
	}
}

#Shortcode name
$shortcodeName="messagebox";
$messagebox = new messagebox_shortcode();
$messagebox->register_shortcode($shortcodeName);

?>