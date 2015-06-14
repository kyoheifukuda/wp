<?php

#tab
function single_tab($atts, $content = null) {
	extract( shortcode_atts( array(
        'title' => 'Title',
        'expanded_state' => '',
	), $atts ) );
	
		return "<div class='shortcode_tab_item_title expand_".$expanded_state."'>".$title."</div><div class='shortcode_tab_item_body tab-content clearfix'><div class='ip'>".$content."</div></div>";

	}
add_shortcode('tab', 'single_tab');

class shortcode_tabs {

	public function register_shortcode($shortcodeName) {
		function shortcode_tabs($atts, $content = null) {

            $compile='';

			extract( shortcode_atts( array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'tab_type' => 'type1',
			), $atts ) );

            #heading
            if (strlen($heading_color)>0) {$custom_color = "color:#{$heading_color};";}
            if (strlen($heading_text)>0) {
                $compile .= "<div class='bg_title'><".$heading_size." style='".(isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '')."' class='headInModule'>{$heading_text}</".$heading_size."></div>";
            }

			$compile .= "
			<div class='shortcode_tabs ".$tab_type."'>
			    <div class='all_head_sizer'><div class='all_heads_cont'></div></div>
			    <div class='all_body_sizer'><div class='all_body_cont'></div></div>
			    ".do_shortcode($content)."
			</div>
			";

            $GLOBALS['showOnlyOneTimeJS']['tabs'] = "
            <script>
            jQuery(document).ready(function($) {
                $('.shortcode_tabs').each(function(index) {
                    /* GET ALL HEADERS */
                    var i = 1;
                    $(this).find('.shortcode_tab_item_title').each(function(index) {
                        $(this).addClass('it'+i); jQuery(this).attr('whatopen', 'body'+i);
                        $(this).addClass('head'+i);
                        $(this).parents('.shortcode_tabs').find('.all_heads_cont').append(this);
                        i++;
                    });

                    /* GET ALL BODY */
                    var i = 1;
                    $(this).find('.shortcode_tab_item_body').each(function(index) {
                        $(this).addClass('body'+i);
                        $(this).addClass('it'+i);
                        $(this).parents('.shortcode_tabs').find('.all_body_cont').append(this);
                        i++;
                    });

                    /* OPEN ON START */
                    $(this).find('.expand_yes').addClass('active');
                    var whatopenOnStart = $(this).find('.expand_yes').attr('whatopen');
                    $(this).find('.'+whatopenOnStart).addClass('active').fadeIn();
                });

                $(document).on('click', '.shortcode_tab_item_title', function(){
                    $(this).parents('.shortcode_tabs').find('.shortcode_tab_item_body').removeClass('active').hide();
                    $(this).parents('.shortcode_tabs').find('.shortcode_tab_item_title').removeClass('active');
                    var whatopen = $(this).attr('whatopen');
                    $(this).parents('.shortcode_tabs').find('.'+whatopen).addClass('active').fadeIn();
                    $(this).addClass('active');
                });
            });
            </script>
            ";

			return $compile;
		}
		add_shortcode($shortcodeName, 'shortcode_tabs');
	}
}

$shortcodeName="tabs";
$shortcode_tabs = new shortcode_tabs();
$shortcode_tabs->register_shortcode($shortcodeName);

?>