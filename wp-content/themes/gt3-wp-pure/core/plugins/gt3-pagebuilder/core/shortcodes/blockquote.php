<?php

class blockquote_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_blockquote($atts, $content = null) {

            if (!isset($compile)) {$compile='';}

			extract( shortcode_atts( array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'quote_type' => 'type1',
                'author_name' => 'author_name',
                'float' => 'none',
                'width' => '100%',
			), $atts ) );

            #heading
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title'><".$heading_size." style='".(isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '')."' class='headInModule'>{$heading_text}</".$heading_size."></div>";
            }

			if (strlen($author_name)>0) {$auth = "<span class='author'>".$author_name."</span>";}

			$compile .= "<span class='shortcode_blockquote ".$float." ".$quote_type."' style='width:".$width.";'><span class='bquote_content'>".do_shortcode($content)."</span><span class='author'>".$author_name."</span></span>";

			return $compile;

		}
		add_shortcode($shortcodeName, 'shortcode_blockquote');
	}
}

#Shortcode name
$shortcodeName="blockquote";


#Compile UI for admin panel
#Don't change this line
$compileShortcodeUI = "<div class='whatInsert whatInsert_".$shortcodeName."'>".$defaultUI."</div>";

#Your code
$compileShortcodeUI .= "
<table>
	<tr>
		<td>Container width:</td>
		<td><input value='50%' type='text' class='".$shortcodeName."_width' name='".$shortcodeName."_width'></td>
	</tr>
	<tr>
		<td>Float:</td>
		<td>
		    <select style='' name='".$shortcodeName."_float' class='".$shortcodeName."_float'>
                <option value='left'>Left</option>
                <option value='right'>Right</option>
            </select>
		</td>
	</tr>
	<tr>
		<td>Author:</td>
		<td>
		    <input value='' type='text' class='".$shortcodeName."_author' name='".$shortcodeName."_author'>
		</td>
	</tr>
	<tr>
		<td>Type:</td>
		<td>
		    <select style='' name='".$shortcodeName."_quote_type' class='".$shortcodeName."_quote_type'>";
if (is_array($GLOBALS["pbconfig"]['all_available_quote_types'])) {
    foreach ($GLOBALS["pbconfig"]['all_available_quote_types'] as $quotetype => $quoteCaption) {
        $compileShortcodeUI .= "<option value='".$quotetype."'>".$quoteCaption."</option>";
    }
}
$compileShortcodeUI .= "
            </select>
		</td>
	</tr>
</table>

<script>
	function ".$shortcodeName."_handler() {

		/* YOUR CODE HERE */

		var author_name = jQuery('.".$shortcodeName."_author').val();
		var width = jQuery('.".$shortcodeName."_width').val();
		var float = jQuery('.".$shortcodeName."_float').val();
		var quote_type = jQuery('.".$shortcodeName."_quote_type').val();

		/* END YOUR CODE */

		/* COMPILE SHORTCODE LINE */
		var compileline = '[".$shortcodeName." quote_type=\"'+quote_type+'\" author_name=\"'+author_name+'\" width=\"'+width+'\" float=\"'+float+'\"][/".$shortcodeName."]';

		/* DO NOT CHANGE THIS LINE */
		jQuery('.whatInsert_".$shortcodeName."').html(compileline);
	}
</script>

";

#Register shortcode & set parameters
$blockquote = new blockquote_shortcode();
$blockquote->register_shortcode($shortcodeName);
shortcodesUI::getInstance()->add('blockquote', array("name" => $shortcodeName, "caption" => "Blockquote", "handler" => $compileShortcodeUI));
unset($compileShortcodeUI);

?>