<?php

class before_after
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_before_after($atts, $content = null)
        {
	
            $compile = '';
            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'image_before' => '',
                'image_after' => ''
            ), $atts));

            #heading
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            }
            if (strlen($heading_text) > 0) {
                $compile = "<div class='bg_title'><" . $heading_size . " style='" . (isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:' . $heading_alignment . ';' : '') . "' class='headInModule'>{$heading_text}</" . $heading_size . "></div>";
            }

            $compile .= '
			<div class="before-after">
				<div class="beforeAfter_wrapper" style="background:url('. $image_after .')">
					<img src="'.$image_before.'" class="img_before" alt="">
					<div class="after_wrapper" style="background:url('. $image_before .')"></div>
					<div class="result_line"></div>
				</div>
			</div>
			';
	
			$GLOBALS['showOnlyOneTimeJS']['beforeAfter'] = "
			<script>
				jQuery(document).ready(function($) {
					jQuery('.beforeAfter_wrapper').each(function(){
						after_wrapper  = jQuery(this).find('.after_wrapper');
						before_wrapper  = jQuery(this);
						result_line = jQuery(this).find('.result_line');
						after_wrapper.width(before_wrapper.width()/2);
						result_line.css('left', (before_wrapper.width()/2)+'px');
					});
					jQuery('.beforeAfter_wrapper').mousemove(function(e){
						var correction = jQuery(this).offset().left,
							page_x = e.pageX-correction,
							after_wrapper  = jQuery(this).find('.after_wrapper'),
							result_line = jQuery(this).find('.result_line');
						after_wrapper.width(page_x);
						result_line.css('left', page_x+'px');
					});	
								
					// Init touch on iPad, iPhone, iPod, Android
					jQuery('.beforeAfter_wrapper').FingerScroll();
				});
	
				jQuery(window).load(function() {
					jQuery('.beforeAfter_wrapper').each(function(){
						after_wrapper  = jQuery(this).find('.after_wrapper');
						before_wrapper  = jQuery(this);
						result_line = jQuery(this).find('.result_line');
						after_wrapper.width(before_wrapper.width()/2);
						result_line.css('left', (before_wrapper.width()/2)+'px');
					});
				});
	
				jQuery.fn.FingerScroll = function() {
					var scrollStartPos = 0,
					correction = jQuery(this).offset().left,
					page_x = 0,
					after_wrapper  = jQuery(this).find('.after_wrapper'),
					result_line = jQuery(this).find('.result_line');
					
					jQuery(this).bind('touchstart', function(event) {
						var e = event.originalEvent;
						scrollStartPos = jQuery(this).scrollTop() + e.touches[0].pageY;
					});
					jQuery(this).bind('touchmove', function(event) {									   
						var e = event.originalEvent;
						correction = jQuery(this).offset().left;
						page_x = e.touches[0].pageX-correction;
	
						after_wrapper.width(page_x);
						result_line.css('left', page_x+'px');
						e.preventDefault();
					});
					return this;
				};			
			</script>
			";

		
            wp_reset_query();

            return $compile;

        }

        add_shortcode($shortcodeName, 'shortcode_before_after');
    }
}

#Shortcode name
$shortcodeName = "before_after";
$shortcode_before_after = new before_after();
$shortcode_before_after->register_shortcode($shortcodeName);
?>