<?php

class contacts_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_contacts($atts, $content = null) {
            if (!isset($compile)) {$compile='';}
			extract( shortcode_atts( array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'module_id' => ''
			), $atts ) );

            $gt3_theme_pagebuilder = get_plugin_pagebuilder(get_the_ID());

            #heading
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title'><".$heading_size." style='".(isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '')."' class='headInModule'>{$heading_text}</".$heading_size."></div>";
            }

            if (is_array($gt3_theme_pagebuilder['modules'][$module_id]['contact_info_icons'])) {
                $compile .= "<ul class='contact_info_list'>";
                foreach ($gt3_theme_pagebuilder['modules'][$module_id]['contact_info_icons'] as $key => $value) {
                    if ($value['link'] != '') {
                        $contact_content = '<div class="contact_info_text '.(strlen($value['bcolor']) > 0 ? "with_bg" : "").'"><a href="'.$value['link'].'">'.$value['name'].'</a></div>';
                    } else {
                        $contact_content = '<div class="contact_info_text '.(strlen($value['bcolor']) > 0 ? "with_bg" : "").'">'.$value['name'].'</div>';
                    }
                    $compile .= "<li class='contact_info_item ".(strlen($value['bcolor']) > 0 ? "with_bg" : "")."'><div class='contact_info_wrapper'><span class='contact_info_icon' style='background:#".$value['bcolor'].";'><i style='color:#".$value['fcolor']."' class='".$value['data-icon-code']."'></i></span>".$contact_content."</div></li>";
                }
                $compile .= "</ul>";
            }
			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_contacts');  
	}
}

#Shortcode name
$shortcodeName="contacts";
#Register shortcode & set parameters
$contacts = new contacts_shortcode();
$contacts->register_shortcode($shortcodeName);

?>