<?php

class promo_text
{
    public function register_shortcode($shortcodeName)
    {
        function shortcode_promo_text($atts, $content = null)
        {
            $compile = '';
            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'main_text' => '',
                'main_text_color' => '',
                'additional_text' => '',
                'additional_text_color' => '',
                'button_text' => '',
                'button_link' => '',
				'button_type' => '',
            ), $atts));

            #heading
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            }
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title'><" . $heading_size . " style='" . (isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '') . "' class='headInModule'>{$heading_text}</" . $heading_size . "></div>";
            }

            /* ADD CLASS IF SOME FIELDS ARE EMPTY */
            $someClass = '';
            if ($additional_text=='') {$someClass .= " no_additional_text ";}
            if ($main_text=='') {$someClass .= " no_main_text ";}
            if ($button_text=='') {$someClass .= " no_button_text ";}
            if ($button_link=='') {$someClass .= " no_button_link ";}
            if ($main_text=='' && $additional_text=='') {$someClass .= " no_text ";}

            $compile .= '
			<div class="shortcode_promoblock '.$someClass.'">
				<div class="promoblock_wrapper">
					<div class="promo_text_block">
						<div class="promo_text_block_wrapper">
							' . (isset($main_text) ? "<h1 ".(strlen($main_text_color)>0 ? "style='color:#".$main_text_color." !important;'" : "")." class='promo_text_main_title'>" . $main_text . "</h1>" : '') . '
							' . (isset($additional_text) ? "<h6 ".(strlen($additional_text_color)>0 ? "style='color:#".$additional_text_color." !important;'" : "")." class='promo_text_additional_title'>" . $additional_text . "</h6>" : '') . '
						</div>
					</div>
                    ' . ((strlen($button_link) > 0 && strlen($button_text) > 0) ? '<div class="promo_button_block">'.do_shortcode('[custom_button style="btn_normal btn_type5" target="_self" href="'.$button_link.'"]'.$button_text.'[/custom_button]').'</div>' : '') . '
                    <div class="clear"></div>
				</div>
			</div>
            ';

            $compile .= '<div class="clear"></div>
			';

            return $compile;

        }

        add_shortcode($shortcodeName, 'shortcode_promo_text');
    }
}

$shortcodeName = "promo_text";
$shortcode_promo_text = new promo_text();
$shortcode_promo_text->register_shortcode($shortcodeName);
?>