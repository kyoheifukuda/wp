<?php

global $wp_customize;

if ( isset( $wp_customize ) ) {
	
	/* Add additional options to Theme Customizer */
	function portfolio_init_customizer( $wp_customize ) {		
		// Add new settings sections
	    $wp_customize->add_section(
	    'portfolio_font_options',
	    array(
	        'title'     => __('Font options', 'portfolio'),
	        'priority'  => 200
	    	)
	    );
	    
	    $wp_customize->add_section(
	    'portfolio_layout_options',
	    array(
	        'title'     => __('Layout & Features', 'portfolio'),
	        'priority'  => 300
	    	)
	    );
	    
	    $wp_customize->add_section(
	    'portfolio_post_options',
	    array(
	        'title'     => __('Post display', 'portfolio'),
	        'priority'  => 400,
	        'active_callback' => 'portfolio_is_singular'
	    	)
	    );
	    
	    // Add new settings
	    $wp_customize->add_setting(
	    	'portfolio_logo',
	    	array(
	    		'default' => '',
	    		'capability' => 'edit_theme_options',
	    		'sanitize_callback' => 'esc_url_raw'
	    	)
	    );
	    
	    $wp_customize->add_setting( 
	    	'portfolio_primary_color', 
	    	array( 
	    		'default' => '#5cc1a9', 
	    		'capability' => 'edit_theme_options',
	    		'transport' => 'postMessage',
	    		'sanitize_callback' => 'sanitize_hex_color'
	    	)
	    );
	    
		$wp_customize->add_setting(
			'portfolio_font',
			array(
			    'default'   => 'google',
			    'capability' => 'edit_theme_options',
			    'sanitize_callback' => 'portfolio_sanitize_font'
			)
		);
		
		$wp_customize->add_setting(
		    'portfolio_google_font',
		    array(
		        'default'   => 'http://fonts.googleapis.com/css?family=Open+Sans:700',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'esc_url_raw'
		    )
		);
		
		$wp_customize->add_setting(
			'portfolio_body_font',
			array(
		    	'default'   => 'google',
		    	'capability' => 'edit_theme_options',
		    	'sanitize_callback' => 'portfolio_sanitize_font'
			)
		);
			
		$wp_customize->add_setting(
		    'portfolio_body_google_font',
		    array(
		        'default'   => 'http://fonts.googleapis.com/css?family=Open+Sans:400',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'esc_url_raw'
		    )
		);
		
		$wp_customize->add_setting(
			'portfolio_article_column',
			array( 
				'default'   => '4',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'portfolio_sanitize_article_column'
			)
		);
		
		$wp_customize->add_setting(
			'portfolio_date_format',
			array( 
				'default'   => 'default',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'portfolio_sanitize_date_format'
			)
		);
		
		$wp_customize->add_setting(
		    'portfolio_content_width',
		    array(
		        'default'   => '700',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'intval'
		    )
		);
		
		$wp_customize->add_setting(
		    'portfolio_word_break',
		    array(
		        'default'   => '0',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'portfolio_sanitize_checkbox'
		    )
		);
		
		$wp_customize->add_setting(
		    'portfolio_full_width_images',
		    array(
		        'default'   => '1',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'portfolio_sanitize_checkbox'
		    )
		);
		
		$wp_customize->add_setting(
		    'portfolio_post_show_title',
		    array(
		        'default'   => '1',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'portfolio_sanitize_checkbox'
		    )
		);
		
		$wp_customize->add_setting(
		    'portfolio_post_show_date',
		    array(
		        'default'   => '1',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'portfolio_sanitize_checkbox'
		    )
		);
		
		$wp_customize->add_setting(
		    'portfolio_post_show_category',
		    array(
		        'default'   => '1',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'portfolio_sanitize_checkbox'
		    )
		);
		
		$wp_customize->add_setting(
		    'portfolio_post_show_social',
		    array(
		        'default'   => '1',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'portfolio_sanitize_checkbox'
		    )
		);
		
		$wp_customize->add_setting(
		    'portfolio_post_show_tags',
		    array(
		        'default'   => '1',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'portfolio_sanitize_checkbox'
		    )
		);
		
		$wp_customize->add_setting(
		    'portfolio_post_show_author',
		    array(
		        'default'   => '1',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'portfolio_sanitize_checkbox'
		    )
		);
		
		$wp_customize->add_setting(
		    'portfolio_frontpage_animation',
		    array(
		        'default'   => '1',
		        'capability' => 'edit_theme_options',
		        'sanitize_callback' => 'portfolio_sanitize_checkbox'
		    )
		);
		
		// Add control for the settings
		$wp_customize->add_control(
			new WP_Customize_Image_Control( 
				$wp_customize, 
				'portfolio_logo', 
				array(
					'label'      => __('Logo image', 'portfolio'),
					'section'    => 'title_tagline',
					'settings'   => 'portfolio_logo'
				) 
			)
		);
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 
				'portfolio_primary_color', 
				array( 
					'label' => __('Primary Color', 'portfolio'), 
					'section' => 'colors', 
					'settings' => 'portfolio_primary_color'
				)
			)
		);		
		
		$wp_customize->add_control(
		    'portfolio_font',
		    array(
		        'section'  => 'portfolio_font_options',
		        'label'    => __('Header Font', 'portfolio'),
		        'type'     => 'select',
		        'choices'  => array(
		        	'google'    		=> 'Google Font',
		        	'verdana'   		=> 'Verdana',
		        	'georgia'    		=> 'Georgia',
		        	'arial'      		=> 'Arial',
		        	'impact'     		=> 'Impact',
		        	'tahoma'     		=> 'Tahoma',
		            'times'      		=> 'Times New Roman',		            
		            'comic sans ms'     => 'Comic Sans MS',
		            'courier new'   	=> 'Courier New',
		            'helvetica'  		=> 'Helvetica'
		        )
		   	 )
		);
	
		$wp_customize->add_control(
		    'portfolio_google_font',
		    array(
		        'section'  => 'portfolio_font_options',
		        'label'    => __('Google Font URL for Header', 'portfolio'),
		        'type'     => 'text',
		        'active_callback' => 'portfolio_font_url_field'
	    	)
		);
			
		$wp_customize->add_control(
		    'portfolio_body_font',
		    array(
		        'section'  => 'portfolio_font_options',
		        'label'    => __('Body Font', 'portfolio'),
		        'type'     => 'select',
		        'choices'  => array(
		        	'google'    		=> 'Google Font',
		        	'verdana'   		=> 'Verdana',
		        	'georgia'    		=> 'Georgia',
		        	'arial'      		=> 'Arial',
		        	'impact'     		=> 'Impact',
		        	'tahoma'     		=> 'Tahoma',
		            'times'      		=> 'Times New Roman',		            
		            'comic sans ms'     => 'Comic Sans MS',
		            'courier new'   	=> 'Courier New',
		            'helvetica'  		=> 'Helvetica'
		        )
		   	 )
		);	
		
		$wp_customize->add_control(
		    'portfolio_body_google_font',
		    array(
		        'section'  => 'portfolio_font_options',
		        'label'    => __('Google Font URL for the Body', 'portfolio'),
		        'type'     => 'text',
		        'active_callback' => 'portfolio_body_font_url_field'
	    	)
		);
		
		$wp_customize->add_control(
		    'portfolio_article_column',
		    array(
		        'section'  => 'portfolio_layout_options',
		        'label'    => __('Amount of article columns', 'portfolio'),
		        'type'     => 'select',
		        'choices'  => array(
		            '4'     => __('4 Column', 'portfolio'),
		            '3'     => __('3 Columns', 'portfolio'),
		            '2'     => __('2 Columns', 'portfolio')
		        )
		    )
		);
		
		$wp_customize->add_control(
		    'portfolio_date_format',
		    array(
		        'section'  => 'portfolio_layout_options',
		        'label'    => __('Date format', 'portfolio'),
		        'type'     => 'select',
		        'choices'  => array(
		            'default'     => __('Default theme format', 'portfolio'),
		            'wordpress'     => __('WordPress Date Format', 'portfolio')
		        )
		    )
		);
		
		$wp_customize->add_control(
		    'portfolio_content_width',
		    array(
		        'section'  => 'portfolio_layout_options',
		        'label'    => __('Content width', 'portfolio'),
		        'type'     => 'text'
		    )
		);
		
		$wp_customize->add_control(
            'portfolio_word_break',
            array(
                'section'  => 'portfolio_layout_options',
                'label'    => __('Enable word-break', 'portfolio'),
                'type'     => 'checkbox'
            )
        );
        
        $wp_customize->add_control(
            'portfolio_full_width_images',
            array(
                'section'  => 'portfolio_layout_options',
                'label'    => __('Full-width images', 'portfolio'),
                'type'     => 'checkbox'
            )
        );
        
        $wp_customize->add_control(
            'portfolio_frontpage_animation',
            array(
                'section'  => 'portfolio_layout_options',
                'label'    => __('Frontpage items animation', 'portfolio'),
                'type'     => 'checkbox'
            )
        );
        
        $wp_customize->add_control(
            'portfolio_post_show_title',
            array(
                'section'  => 'portfolio_post_options',
                'label'    => __('Show title', 'portfolio'),
                'type'     => 'checkbox'
            )
        );
        
        $wp_customize->add_control(
            'portfolio_post_show_date',
            array(
                'section'  => 'portfolio_post_options',
                'label'    => __('Show date', 'portfolio'),
                'type'     => 'checkbox'
            )
        );
        
        $wp_customize->add_control(
            'portfolio_post_show_category',
            array(
                'section'  => 'portfolio_post_options',
                'label'    => __('Show category', 'portfolio'),
                'type'     => 'checkbox'
            )
        );
        
        $wp_customize->add_control(
            'portfolio_post_show_tags',
            array(
                'section'  => 'portfolio_post_options',
                'label'    => __('Show tags', 'portfolio'),
                'type'     => 'checkbox'
            )
        );
        
        $wp_customize->add_control(
            'portfolio_post_show_social',
            array(
                'section'  => 'portfolio_post_options',
                'label'    => __('Show social icons', 'portfolio'),
                'type'     => 'checkbox'
            )
        );
        
        $wp_customize->add_control(
            'portfolio_post_show_author',
            array(
                'section'  => 'portfolio_post_options',
                'label'    => __('Show author', 'portfolio'),
                'type'     => 'checkbox'
            )
        );
	}
	
	add_action( 'customize_register', 'portfolio_init_customizer' );
}

/*
 * Context functions
 */
 
function portfolio_is_singular($section) {
	return is_singular();
} 
 
function portfolio_font_url_field($control) {
	$option = $control->manager->get_setting('portfolio_font');
	return $option->value() == 'google';
}

function portfolio_body_font_url_field($control) {
	$option = $control->manager->get_setting('portfolio_body_font');
	return $option->value() == 'google';
}

/*
 * Sanitization functions
 */
function portfolio_sanitize_article_column($value) {
	if(in_array($value, array('1', '2', '3', '4'))) {
		return $value;
	}
	
	return null;	
}

function portfolio_sanitize_font($value) {
	$fonts = array(
		'google', 
		'verdana', 
		'georgia', 
		'arial', 
		'impact', 
		'tahoma', 
		'times',
		'comic sans ms',
		'courier new',
		'helvetica'
	);
	
	if(in_array($value, $fonts)) {
		return $value;
	}
	
	return null;
}

function portfolio_sanitize_date_format($value) {
	if($value === 'default' || $value === 'wordpress') {
		return $value;
	}
	return null;
}

function portfolio_sanitize_checkbox($value) {
	if($value == '1' || $value == '0') {
		return $value;
	}
	return null;
}

// Add CSS styles generated from GK Cusotmizer settings
function portfolio_customizer_css() {
	$google = esc_attr(get_theme_mod('portfolio_google_font', 'http://fonts.googleapis.com/css?family=Open+Sans:700'));
	$fname = array();
	preg_match('@family=(.+)$@is', $google, $fname);
	$font_family = "'" . str_replace('+', ' ', preg_replace('@:.+@', '', preg_replace('@&.+@', '', $fname[1]))) . "'";
	
	$body_google = esc_attr(get_theme_mod('portfolio_body_google_font', 'http://fonts.googleapis.com/css?family=Open+Sans:400'));
	$body_fname = array();
	preg_match('@family=(.+)$@is', $body_google, $body_fname);
	$body_font_family = "'" . str_replace('+', ' ', preg_replace('@:.+@', '', preg_replace('@&.+@', '', $body_fname[1]))) . "'";
    
    if (get_theme_mod('portfolio_font') == 'google') {
    	$portfolio_font = $font_family;
    } else {
    	$portfolio_font = esc_attr(get_theme_mod('portfolio_font'));
    }
    
    if (get_theme_mod('portfolio_body_font') == 'google') {
    	$body_portfolio_font = $body_font_family;
    } else {
    	$body_portfolio_font = esc_attr(get_theme_mod('portfolio_body_font'));
    }
    
    $primary_color = esc_attr(get_theme_mod('portfolio_primary_color', '#5cc1a9'));
    
    ?>   
    <style type="text/css">
    	body { font-family: <?php echo $body_portfolio_font; ?> }
        .site-title { font-family: <?php echo $portfolio_font; ?> }
    
    	#primary,
    	#comments,
    	.author-info,
    	.attachment #primary,
    	.site-content.archive #gk-search,
    	.search-no-results .page-content {
    		width: <?php echo get_theme_mod('portfolio_content_width', 700); ?>px;
    	}
    
    	<?php if(get_theme_mod('portfolio_word_break', '0') == '1') : ?>
        body {
            -ms-word-break: break-all;
            word-break: break-all;
            word-break: break-word;
            -webkit-hyphens: auto;
            -moz-hyphens: auto;
            -ms-hyphens: auto;
            hyphens: auto;
        }
        <?php endif; ?>
    
        a,
        a.inverse:active,
        a.inverse:focus,
        a.inverse:hover,
        button,
        input[type="submit"],
        input[type="button"],
        input[type="reset"],
        .entry-summary .readon,
        .comment-author .fn,
        .comment-author .url,
        .comment-reply-link,
        .comment-reply-login,
        #content .tags-links a:active,
        #content .tags-links a:focus,
        #content .tags-links a:hover,
        .nav-menu li a:active,
        .nav-menu li a:focus,
        .nav-menu li a:hover,
        ul.nav-menu ul a:hover,
        .nav-menu ul ul a:hover,
        .gk-social-buttons a:hover:before,
        .format-gallery .entry-content .page-links a:hover,
        .format-audio .entry-content .page-links a:hover,
        .format-status .entry-content .page-links a:hover,
        .format-video .entry-content .page-links a:hover,
        .format-chat .entry-content .page-links a:hover,
        .format-quote .entry-content .page-links a:hover,
        .page-links a:hover,
        .paging-navigation a:active,
        .paging-navigation a:focus,
        .paging-navigation a:hover,
        .comment-meta a:hover,
        .social-menu li:hover:before,
        .entry-title a:hover {
        	color: <?php echo $primary_color; ?>;
        }
        button,
        input[type="submit"],
        input[type="button"],
        input[type="reset"],
        .entry-summary .readon {
        	border: 1px solid <?php echo $primary_color; ?>;
        }
        .nav-menu .current_page_item > a,
        .nav-menu .current_page_ancestor > a,
        .nav-menu .current-menu-item > a,
        .nav-menu .current-menu-ancestor > a {
        	border-color: <?php echo $primary_color; ?>;
        	color: <?php echo $primary_color; ?>;
        }
        .format-status .entry-content .page-links a,
        .format-gallery .entry-content .page-links a,
        .format-chat .entry-content .page-links a,
        .format-quote .entry-content .page-links a,
        .page-links a {
        	background:  <?php echo $primary_color; ?>;
        	border-color: <?php echo $primary_color; ?>;
        }
        .hentry .mejs-controls .mejs-time-rail .mejs-time-current,
        .comment-post-author,
        .sticky .post-preview:after,
        .entry-header.sticky:after {
        	background: <?php echo $primary_color; ?>;
        }
        .comments-title > span,
        .comment-reply-title > span {
        	border-bottom-color: <?php echo $primary_color; ?>;
        }
    </style>
    <?php   
    
    $width = '';
    if ( get_theme_mod('portfolio_article_column', '4') == '4') { $width = '25%'; }
    elseif ( get_theme_mod('portfolio_article_column', '2') == '2') { $width = '50%'; }
    else { $width = '33%'; }
	 ?>
    <style type="text/css">
        .site-content.archive article { width: <?php echo $width ?>; }
    </style> 
    <?php 
}

add_action( 'wp_head', 'portfolio_customizer_css' );

function portfolio_customize_register($wp_customize) {
	if ( $wp_customize->is_preview() && ! is_admin() ) {
		add_action( 'wp_footer', 'portfolio_customize_preview', 21);
    }
}

add_action( 'customize_register', 'portfolio_customize_register' );

function portfolio_customize_preview() {
    ?>
    <script>
    (function($){
    	wp.customize('portfolio_primary_color', function(value) {
    	    value.bind( function( to ) {
    	    	to = to ? to : '#5cc1a9';
    	    	// set colors:
    	    	var new_css = 'a, a.inverse:active, a.inverse:focus, a.inverse:hover, .entry-title a:hover, button, input[type="submit"], input[type="button"], input[type="reset"], .entry-summary .readon, .comment-author .fn, .comment-author .url, .comment-reply-link, .comment-reply-login, #content .tags-links a:active, #content .tags-links a:focus, #content .tags-links a:hover, .nav-menu li a:active, .nav-menu li a:focus, .nav-menu li a:hover, ul.nav-menu ul a:hover, .nav-menu ul ul a:hover, .gk-social-buttons a:hover:before, .format-gallery .entry-content .page-links a:hover, .format-audio .entry-content .page-links a:hover, .format-status .entry-content .page-links a:hover, .format-video .entry-content .page-links a:hover, .format-chat .entry-content .page-links a:hover, .format-quote .entry-content .page-links a:hover, .page-links a:hover, .paging-navigation a:active, .paging-navigation a:focus, .paging-navigation a:hover, .comment-meta a:hover, .social-menu li:hover:before { color: '+to+'; } button, input[type="submit"], input[type="button"], input[type="reset"], .entry-summary .readon { border: 1px solid '+to+'; } .nav-menu .current_page_item > a, .nav-menu .current_page_ancestor > a, .nav-menu .current-menu-item > a, .nav-menu .current-menu-ancestor > a { border-color: '+to+'; color: '+to+'; } .format-status .entry-content .page-links a, .format-gallery .entry-content .page-links a, .format-chat .entry-content .page-links a, .format-quote .entry-content .page-links a, .page-links a { background-color: '+to+'; border-color: '+to+'; } .hentry .mejs-controls .mejs-time-rail .mejs-time-current, .comment-post-author {background: '+to+';} .comments-title > span, .comment-reply-title > span { border-bottom-color: '+to+'; }';
    	    	
    	    	if($(document).find('#portfolio-new-css-1').length) {
    	    		$(document).find('#portfolio-new-css-1').remove();
    	    	}
    	    	
    	    	$(document).find('head').append($('<style id="portfolio-new-css-1">' + new_css + '</style>'));
    	    });
    	});
    })(jQuery);
    </script>
    <?php
}

// EOF