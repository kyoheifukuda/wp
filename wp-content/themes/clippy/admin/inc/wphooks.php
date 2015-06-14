<?php
/*********************************************************************************************

Load wp_head function in header.php / Enqueue Files In Header

*********************************************************************************************/
function site5framework_header_init() {
    if (!is_admin()) {

    wp_enqueue_script( 'jquery' );

	wp_enqueue_script('modernizr', get_template_directory_uri() .'/js/vendor/modernizr-2.6.1-respond-1.1.0.min.js', false, '2.6.1', false);
	wp_enqueue_script('prettyphoto-js', get_template_directory_uri() .'/lib/prettyphoto/jquery.prettyPhoto.js', array('jquery'), '3.1.4', false);
	wp_enqueue_style ('prettyphoto-css', get_template_directory_uri().'/lib/prettyphoto/css/prettyPhoto.css', 'style', false);

	wp_enqueue_script('superfish-js', get_template_directory_uri().'/lib/superfish/superfish.js');
	wp_enqueue_style ('superfish-css', get_template_directory_uri().'/lib/superfish/superfish.css');

	//registered scripts
	wp_register_script( 'flexslider-js', get_template_directory_uri().'/lib/flexslider/jquery.flexslider.js', false, '1.0', true );  
	wp_register_style ( 'flexslider-css', get_template_directory_uri().'/lib/flexslider/flexslider.css', false, '1.0', false );  

	wp_register_script( 'fitvids-js', get_template_directory_uri().'/lib/fitvids/jquery.fitvids.js', false, '1.0', true ); 
	wp_enqueue_script(  'fitvids-js');
	
	wp_register_script( 'jplayer-js', get_template_directory_uri().'/lib/jplayer/jquery.jplayer.min.js', false, '2.1.0', true );  
	wp_register_style ( 'jplayer-css', get_template_directory_uri().'/lib/jplayer/jplayer.css', false, '1.0', false );  

	}
}
add_action('init', 'site5framework_header_init');


/*********************************************************************************************

admin hooks / portfolio media uploader

*********************************************************************************************/
function site5framework_mediauploader_init() {
    if (is_admin()) {
    wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script('site5mediauploader', get_template_directory_uri().'/admin/js/site5mediauploader.js', false, '2.1', true);
}
}
add_action('init', 'site5framework_mediauploader_init');


/*********************************************************************************************

Load custom favicon in header.php

*********************************************************************************************/
function site5framework_custom_shortcut_favicon() {
	if (of_get_option('favicon') != '') {
    echo '<link rel="shortcut icon" href="'. of_get_option('favicon') .'" type="image/ico" />'."\n";
	}
	else { ?><link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/favicon.ico" type="image/ico" />
	<?php }
}
add_action('wp_head', 'site5framework_custom_shortcut_favicon');

/*********************************************************************************************

Load contactform js when contact page called

*********************************************************************************************/
function site5framework_contactform_init() {
	if (is_page_template('page-temp-contact.php') && !is_admin()) {
    wp_enqueue_script('contactform', get_template_directory_uri().'/lib/contactform/contactform.js', false, '1.0', false);
    }
}
add_action('template_redirect', 'site5framework_contactform_init');


/*********************************************************************************************

Load stats in footer.php

*********************************************************************************************/
function site5framework_analytics(){
	$output = of_get_option('stats');
	if ( $output <> "" )
	echo stripslashes($output) . "\n";
}
add_action('wp_footer','site5framework_analytics');
?>