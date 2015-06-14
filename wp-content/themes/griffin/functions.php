<?php
// theme setup
if (!function_exists('griffin_setup')):
	function griffin_setup() {	
		register_nav_menus(array(
			'primary' => __('Primary Menu', 'griffin'),			
			'footer' => __('Footer Menu', 'griffin')	
		));
		add_theme_support('post-thumbnails');
		add_theme_support('automatic-feed-links');	
		add_image_size('featured-full', 750, 429, true);
		add_image_size('featured-teaser', 450);
		add_editor_style(get_template_directory_uri() . '/assets/css/editor-style.css');
		// set content width 
		global $content_width;  
		if (!isset($content_width)) {$content_width = 750;}		
	}
endif; 
add_action('after_setup_theme', 'griffin_setup');

// load css 
function griffin_css() {		
	wp_enqueue_style('griffin_ubuntu', '//fonts.googleapis.com/css?family=Ubuntu:400,700');
	wp_enqueue_style('griffin_bootstrap_css', get_template_directory_uri() . '/assets/css/bootstrap.min.css');	   
	wp_enqueue_style('griffin_style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'griffin_css');

// load javascript
function griffin_javascript() {	
	wp_enqueue_script('griffin_script', get_template_directory_uri() . '/assets/js/griffin.js', array('jquery'), '1.0', true);
	wp_enqueue_script('jquery-masonry');
	if (is_singular() && comments_open()) {wp_enqueue_script('comment-reply');}
}
add_action('wp_enqueue_scripts', 'griffin_javascript');

// html5 shiv
function griffin_html5_shiv() {
    echo '<!--[if lt IE 9]>';
    echo '<script src="'. get_template_directory_uri() .'/assets/js/html5shiv.js"></script>';
    echo '<![endif]-->';
}
add_action('wp_head', 'griffin_html5_shiv');

// title tag filter
function griffin_title($title, $sep) {
	global $paged, $page;
	if (is_feed()) {return $title;}
	$title .= get_bloginfo('name');	
	$site_description = get_bloginfo('description', 'display');
	if ( $site_description && (is_home() || is_front_page())) {
		$title = "$title $sep $site_description";
	}	
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __('Page %s', 'griffin'), max($paged, $page));
	}
	return $title;
}
add_filter('wp_title', 'griffin_title', 10, 2);

// custom header image
$header_img = array(	
	'flex-height' => true,
	'flex-width' => true,
	'height' => '320',
	'default-image' => get_template_directory_uri() . '/assets/img/header.jpg',
	'header-text' => false
);
add_theme_support('custom-header', $header_img);

// theme customizer
function griffin_customize_register($wp_customize) {
	// custom logo
	$wp_customize->add_section('griffin_logo_section', array(
		'title' => __('Custom Logo', 'griffin'),
		'priority' => 900,
		'type' => 'option'		
	));
	$wp_customize->add_setting('griffin_logo_setting', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	));
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo', array(
		'label' => __('Logo', 'griffin'),
		'section' => 'griffin_logo_section',
		'settings' => 'griffin_logo_setting'
	)));
	 // custom colors
	$wp_customize->add_section('griffin_color_section', array(
		'title' => __('Custom Colors', 'griffin'),
		'priority' => 901
	));
	$wp_customize->add_setting('griffin_background_color', array(		
	    'default' => '#f3f3f3',
	    'sanitize_callback' => 'sanitize_hex_color'	    
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'background_color', array(
		'label' => __('Background Color', 'griffin'),        
        'section' => 'griffin_color_section',
        'settings' => 'griffin_background_color'
    )));
    $wp_customize->add_setting('griffin_title_color', array(		
	    'default' => '#ffffff',
	    'sanitize_callback' => 'sanitize_hex_color'	    
	));	
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'title_color', array(
		'label' => __('Site Title Color', 'griffin'),        
        'section' => 'griffin_color_section',
        'settings' => 'griffin_title_color'
    )));
    $wp_customize->add_setting('griffin_tagline_color', array(		
	    'default' => '#999999',
	    'sanitize_callback' => 'sanitize_hex_color'	    
	));	
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'tagline_color', array(
		'label' => __('Tagline Color', 'griffin'),        
        'section' => 'griffin_color_section',
        'settings' => 'griffin_tagline_color'
    )));
	$wp_customize->add_setting('griffin_secondary_color', array(		
	    'default' => '#009dd9',
	    'sanitize_callback' => 'sanitize_hex_color'	    
	));	
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
		'label' => __('Secondary Color', 'griffin'),        
        'section' => 'griffin_color_section',
        'settings' => 'griffin_secondary_color'
    )));    
}
add_action('customize_register', 'griffin_customize_register');

function griffin_custom_css() {
	wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/custom.css');
	$background_color = get_theme_mod('griffin_background_color','#f3f3f3');
	$title_color = get_theme_mod('griffin_title_color','#f3f3f3');
	$tagline_color = get_theme_mod('griffin_tagline_color','#999999');
    $secondary_color = get_theme_mod('griffin_secondary_color','#009dd9');
    $custom_css = "
    			body {background-color:{$background_color};}
    			header #header-name {color:{$title_color}; border-color:{$title_color};}
    			header #header-description {color:{$tagline_color};}
    			a:hover, #primary-menu .menu-item-has-children:hover .sub-menu li a:hover, .widget_tag_cloud a:hover, #footer-widgets .widget a:hover, .teaser-title a:hover, .sticky h3 span, .pager a.page-numbers:hover, article #post-links a:hover, #comments .bypostauthor .comment-author {color:{$secondary_color};} 
    			#sidebar-widgets .widget h4, .teaser-more, .sticky h3 span {border-color:{$secondary_color};}
    			";
    wp_add_inline_style('custom-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'griffin_custom_css');

// custom excerpt 
function new_excerpt_more($more) {
	global $post;
	return '... <p><a class="teaser-more" href="'. get_permalink($post->ID) . '">' . 'Continue Reading' . '</a></p>';
}
add_filter('excerpt_more', 'new_excerpt_more');

// sidebars
function griffin_widgets_init() {
	register_sidebar(array(
		'name' => __('Primary Sidebar', 'griffin'),
		'id' => 'primary-sidebar',
		'description' => __('Widgets will appear in the right sidebar on posts and pages', 'griffin'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));
	register_sidebar(array(
		'name' => __('Footer Left', 'griffin'),
		'id' => 'footer-left',
		'description' => __('Widgets will appear in the left column of the footer', 'griffin'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));
	register_sidebar(array(
		'name' => __('Footer Middle', 'griffin'),
		'id' => 'footer-middle',
		'description' => __('Widgets will appear in the middle column of the footer', 'griffin'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));
	register_sidebar(array(
		'name' => __('Footer Right', 'griffin'),
		'id' => 'footer-right',
		'description' => __('Widgets will appear in the right column of the footer', 'griffin'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4>',
		'after_title' => '</h4>'
	));
}
add_action('widgets_init', 'griffin_widgets_init');

// comments
if (!function_exists('griffin_comment')) :
	function griffin_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		switch ($comment->comment_type) :
        case 'pingback' :
        case 'trackback' :
		?>	
		<li class="pingback">
        <?php comment_author_link(); ?>
	    <?php
	    break;
	    default :
	    ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">		
			<div class="comment-avatar">				
				<?php echo get_avatar($comment, 43); ?>
			</div> 
			<div class="comment-text">
				<p class="comment-meta">
					<span class="comment-author"><?php comment_author(); ?></span>
					<span class="comment-date"><?php echo get_comment_date() . ' - ' . get_comment_time() ?></span>
					<?php edit_comment_link(__( 'Edit', 'griffin' ), '', ''); ?> 	
					<?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply', 'griffin'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?> 
				</p>					
				<div class="comment-body"><?php comment_text(); ?></div>
				<?php if ('0' == $comment->comment_approved) : ?>				
					<p class="comment-awaiting-moderation"><?php _e('Comment is awaiting moderation!', 'griffin'); ?></p>					
				<?php endif; ?>	
			</div>		
		<?php 	
        break;
    	endswitch;
	}
endif;

// pager
if (!function_exists('griffin_pagination')):
	function griffin_pagination() {
		global $wp_query;
		$big = 999999999;	
		echo '<div class="pager">';	
		echo paginate_links( array(
			'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format' => '?paged=%#%',
			'current' => max(1, get_query_var('paged')),
			'total' => $wp_query->max_num_pages,
			'prev_next' => True,
			'prev_text' => __('<span>&Larr;</span> Previous', 'griffin'),
			'next_text' => __('Next <span>&Rarr;</span>', 'griffin'),
		));
		echo '</div>';
	}
endif;
?>