<?php

class buttons_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_button($atts, $content = null) {
			extract( shortcode_atts( array(
			  'icon' => '',
			  'style' => 'btn_normal',
			  'href' => 'http://',
              'target' => '_self',
			), $atts ) );
	
			$content = strtr($content, array(
				'<p>'=>'',
				'</p>'=>'',
			));

            if ($target == "_blank") {
                $external_html = 'target="_blank"';
            } else {$external_html = '';}
			
			if ($icon == "") {
				$button_ico = '';
			} else {
				$button_ico = '<span class="ico_cont"><span class="ico_fader"></span><i class="ico_this '.$icon.'"></i></span>';
			}

			return '<a href="'.$href.'" '.$external_html.' class="shortcode_button '.$style.' '.(strlen($icon)>0 ? "with_icon" : "without_icon").'">'.$button_ico."<span class='btn_text'>".$content.'</span></a>';
		}
		add_shortcode($shortcodeName, 'shortcode_button');
	}
}

#Shortcode name
$shortcodeName="custom_button";
#Compile UI for admin panel
#Don't change this line
$compileShortcodeUI = "<div class='whatInsert whatInsert_".$shortcodeName."'>".$defaultUI."</div>";

#Your code
$compileShortcodeUI .= "

<table>
	<tr>
		<td>Address url:</td>
		<td><input style='width:160px;text-align:center;' value='' type='text' class='".$shortcodeName."_href' name='".$shortcodeName."_href'></td>
	</tr>
	<tr>
		<td>Style:</td>
		<td>
		    <select name='".$shortcodeName."_style' class='".$shortcodeName."_style'>";
if (is_array($GLOBALS["pbconfig"]['all_available_custom_buttons'])) {
    foreach ($GLOBALS["pbconfig"]['all_available_custom_buttons'] as $buttonclass => $buttonCaption) {
        $compileShortcodeUI .= "<option value='".$buttonclass."'>".$buttonCaption."</option>";
    }
}
$compileShortcodeUI .= "</select>
		</td>
	</tr>
	<tr>
		<td>Target:</td>
		<td>
		    <select name='".$shortcodeName."_target_state' class='".$shortcodeName."_target_state'>
                <option value='_self'>_self</option>
                <option value='_blank'>_blank</option>
            </select>
		</td>
	</tr>
</table>
<div class='social_icons all_available_font_icons'>
	Select icon:
	<ul class='icons_list ".$shortcodeName."_icon'>";
        foreach ($GLOBALS["pbconfig"]['all_available_font_icons'] as $icon) {
            $compileShortcodeUI .= "<li class='stand_social'><i data-icon-code='" . $icon . "' class='stand_icon " . $icon . "'></i></li>";
        }		
$compileShortcodeUI .= "
	</ul><div class='clear'></div>
</div>

<script>
	function ".$shortcodeName."_handler() {
	
		/* YOUR CODE HERE */
		
		var style = jQuery('.".$shortcodeName."_style').val();
		var href = jQuery('.".$shortcodeName."_href').val();
		var target_state = jQuery('.".$shortcodeName."_target_state').val();
		if (jQuery('.".$shortcodeName."_icon').find('li.active').size() > 0) {
			var icon = jQuery('.".$shortcodeName."_icon').find('li.active i').attr('data-icon-code');
		} else {
			var icon = '';
		}
		
		
		/* END YOUR CODE */
	
		/* COMPILE SHORTCODE LINE */
		var compileline = '[".$shortcodeName." style=\"'+style+'\" icon=\"'+icon+'\" target=\"'+target_state+'\" href=\"'+href+'\"][/".$shortcodeName."]';
				
		/* DO NOT CHANGE THIS LINE */
		jQuery('.whatInsert_".$shortcodeName."').html(compileline);
	}
</script>

";

#Register shortcode & set parameters
$button = new buttons_shortcode();
$button->register_shortcode($shortcodeName);
shortcodesUI::getInstance()->add('shortcode_button', array("name" => $shortcodeName, "caption" => "Custom Buttons", "handler" => $compileShortcodeUI));
unset($compileShortcodeUI);

?>