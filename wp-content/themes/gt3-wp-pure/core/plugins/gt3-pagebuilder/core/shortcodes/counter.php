<?php

class counter_shortcode {

	public function register_shortcode($shortcodeName) {
		function shortcode_counter($atts, $content = null) {

            if (!isset($compile)) {$compile='';}

			extract( shortcode_atts( array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'stat_heading' => '',
                'count_text' => '',
                'stat_icon' => '',
			), $atts ) );

			wp_enqueue_script('gt3_waypoint_js', get_template_directory_uri() . '/js/waypoint.js', array(), false, true);

            #heading
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title'><".$heading_size." style='".(isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '')."' class='headInModule'>{$heading_text}</".$heading_size."></div>";
            }

            $compile .= "
			<div class='module_content shortcode_counter'>
				<div class='counter_wrapper'>
					<div class='counter_body'>
					    <div class='icon_cont'>
					        <i class='icon ".$stat_icon."'></i>
					    </div>
						<h3 class='stat_count' data-count='".$content."'>0</h3>
						<h6 class='counter_title'>".$stat_heading."</h6>
						<div class='stat_temp'></div>
					</div>					
				</div>
			</div>
			";

            $GLOBALS['showOnlyOneTimeJS']['counter_js'] = "
			<script>
				jQuery(document).ready(function($) {
					if (jQuery(window).width() > 760) {
						jQuery('.shortcode_counter').waypoint(function(){							
							var set_count = $(this).find('.stat_count').attr('data-count');
							$(this).find('.stat_temp').stop().animate({width: set_count}, {duration: 3000, step: function(now) {
									var data = Math.floor(now);
									$(this).parents('.counter_wrapper').find('.stat_count').html(data);
								}
							});
							$(this).find('.stat_count');
						},{offset: 'bottom-in-view', triggerOnce: true});
					} else {
						jQuery('.shortcode_counter').each(function(){							
							var set_count = $(this).find('.stat_count').attr('data-count');
							$(this).find('.stat_temp').animate({width: set_count}, {duration: 3000, step: function(now) {
									var data = Math.floor(now);
									$(this).parents('.counter_wrapper').find('.stat_count').html(data);
								}
							});
							$(this).find('.stat_count');
						});	
					}
				});
			</script>
			";
				
			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_counter');
	}
}

#Shortcode name
$shortcodeName="counter";
#Register shortcode & set parameters
$counter = new counter_shortcode();
$counter->register_shortcode($shortcodeName);

?>