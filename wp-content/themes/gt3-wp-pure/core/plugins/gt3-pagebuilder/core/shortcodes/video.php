<?php

class video_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_video($atts, $content = null) {
            if (!isset($compile)) {$compile='';}
			extract( shortcode_atts( array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'video_url' => '',
                'w' => '',
                'h' => $GLOBALS["pbconfig"]['default_video_height'],
			), $atts ) );

            $uniqid = mt_rand(0, 9999);
            global $YTApiLoaded, $allYTVideos;
            if (empty($YTApiLoaded)) {$YTApiLoaded = false;}
            if (empty($allYTVideos)) {$allYTVideos = array();}

            #heading
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title'><".$heading_size." style='".(isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '')."' class='headInModule'>{$heading_text}</".$heading_size."></div>";
            }

            $compile .= '<div class="wrapped_video">';

            #YOUTUBE
            $is_youtube = substr_count($video_url, "youtu");
            if ($is_youtube > 0) {
                $videoid = substr(strstr($video_url, "="), 1);
                $compile .= "<div id='player{$uniqid}'></div>";

                array_push($allYTVideos, array("h" => $h, "w" => $w, "videoid" => $videoid, "uniqid" => $uniqid));
            }

            #VIMEO
            $is_vimeo = substr_count($video_url, "vimeo");
            if ($is_vimeo > 0) {
                $videoid = substr(strstr($video_url, "m/"), 2);
                $compile .= "
            <iframe src=\"http://player.vimeo.com/video/" . $videoid . "\" width=\"{$w}\" height=\"{$h}\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        ";
            }

            $compile .= '</div>';

			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_video');
	}
}

#Shortcode name
$shortcodeName="video";

#Compile UI for admin panel
#Don't change this line
$compileShortcodeUI = "<div class='whatInsert whatInsert_".$shortcodeName."'>".$defaultUI."</div>";

#Your code
$compileShortcodeUI .= "
<table>
	<tr>
		<td>Container width:</td>
		<td><input value='150px' type='text' class='".$shortcodeName."_width' name='".$shortcodeName."_width'></td>
	</tr>
	<tr>
		<td>Container height:</td>
		<td><input value='150px' type='text' class='".$shortcodeName."_height' name='".$shortcodeName."_height'></td>
	</tr>
	<tr>
		<td>Video url:</td>
		<td><input value='' type='text' class='".$shortcodeName."_video' name='".$shortcodeName."_video'><br />
			<div class='shortcode_video_example'>".__('Examples:','theme_localization')."<br />
			".__('Youtube','theme_localization')." - http://www.youtube.com/watch?v=6v2L2UGZJAM<br />
			".__('Vimeo','theme_localization')." - http://vimeo.com/47989207</div>
		</td>
	</tr>
	<tr>
		<td>Float:</td>
		<td>
		    <select style='' name='".$shortcodeName."_float' class='".$shortcodeName."_float'>
                <option value='left'>Left</option>
                <option value='right'>Right</option>
                <option value='right'>None</option>
            </select>
		</td>
	</tr>
</table>

<script>
	function ".$shortcodeName."_handler() {

		/* YOUR CODE HERE */

		var video_width = jQuery('.".$shortcodeName."_width').val();
		var video_height = jQuery('.".$shortcodeName."_height').val();
		var video_url = jQuery('.".$shortcodeName."_video').val();
		var float = jQuery('.".$shortcodeName."_float').val();

		/* END YOUR CODE */

		/* COMPILE SHORTCODE LINE */
		var compileline = '[".$shortcodeName." w=\"'+video_width+'\" h=\"'+video_height+'\" video_url=\"'+video_url+'\" float=\"'+float+'\"][/".$shortcodeName."]';

		/* DO NOT CHANGE THIS LINE */
		jQuery('.whatInsert_".$shortcodeName."').html(compileline);
	}
</script>

";

$video = new video_shortcode();
$video->register_shortcode($shortcodeName);
shortcodesUI::getInstance()->add('video', array("name" => $shortcodeName, "caption" => "Video", "handler" => $compileShortcodeUI));
unset($compileShortcodeUI);

?>