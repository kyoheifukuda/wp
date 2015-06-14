<?php 
/*********************************************************************************************

Adding Translation Option

*********************************************************************************************/
load_theme_textdomain( 'site5framework', get_template_directory().'/languages' );
$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if ( is_readable($locale_file) ) require_once($locale_file);


//Theme Shortname prefix (in format "shortcode_") for theme options and custom meta fields
define('SN', 'cl_');

/*********************************************************************************************

Load site5framework Theme Options

*********************************************************************************************/
require('theme-options.php');



/*********************************************************************************************

Add Thumbnail Support and Image resizing 

*********************************************************************************************/
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 250, 250 ); // default Post Thumbnail dimensions   
}

if ( function_exists( 'add_image_size' ) ) { 
    //add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
    add_image_size( 'post-thumb', 320, 320, true ); //(cropped)
    add_image_size( 'gallery-slide', 510, 99999, false ); //(cropped)
}

add_theme_support( 'post-formats', array('aside', 'status', 'image' ,'gallery','link','quote','audio', 'video' ));


/*********************************************************************************************

Add Custom Background Support

*********************************************************************************************/
$defaults = array(
  'default-color'          => 'FFFFFF',
  'wp-head-callback'       => '_custom_background_cb',
  'admin-head-callback'    => '',
  'admin-preview-callback' => ''
);
add_theme_support( 'custom-background', $defaults );


function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID))  { return true; }
    return false;
}

/*********************************************************************************************

Fix rel validation on category links

*********************************************************************************************/
add_filter( 'the_category', 'add_nofollow_cat' );  
function add_nofollow_cat( $text ) { $text = str_replace('rel="category tag"', "", $text); return $text; }



/*********************************************************************************************

Load Styles and Javascripts

*********************************************************************************************/
function theme_scripts_styles() {

    //loaded in head
    wp_enqueue_style( 'clippy-style', get_stylesheet_directory_uri() . '/css/style.css' );

    wp_enqueue_script( 'masonry-js', get_stylesheet_directory_uri() . '/js/jquery.masonry_min.js', array('jquery'), '1.5.21', true );
    wp_enqueue_script( 'imagesloaded-js', get_stylesheet_directory_uri() . '/js/jquery.imagesloaded.min.js', array('jquery'), '1.5.21', true );
    wp_enqueue_script( 'clippy-main-js', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'theme_scripts_styles' );



/*********************************************************************************************

Body class for pages with sidebar

*********************************************************************************************/
add_action('wp_head', create_function("",'ob_start();') );
add_action('get_sidebar', 'my_sidebar_class');
add_action('wp_footer', 'my_sidebar_class_replace');
 
function my_sidebar_class($name=''){
  static $class="withsidebar";
  if(!empty($name))$class.=" sidebar-{$name}";
  my_sidebar_class_replace($class);
}
 
function my_sidebar_class_replace($c=''){
  static $class='';
  if(!empty($c)) $class=$c;
  else {
    echo str_replace('<body class="','<body class="'.$class.' ',ob_get_clean());
    ob_start();
  }
}

/*********************************************************************************************

Transparent Wmode for Flash

*********************************************************************************************/
function add_embed_video_wmode_transparent($html) {
    if ( strpos( $html, "<embed src=" ) !== false )
    { return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html); }
    elseif ( strpos ( $html, 'feature=oembed' ) !== false )
    { return str_replace( 'feature=oembed', 'feature=oembed&wmode=opaque', $html ); }
    else
    { return $html; }
}
add_filter( 'embed_oembed_html', 'add_embed_video_wmode_transparent', 10, 3);


function add_youtube_video_wmode_transparent($html) {
  if (strpos($html, "<iframe" ) !== false) {
    $search = array('?rel=0');
    $replace = array('?rel=0&amp;wmode=transparent');
    $html = str_replace($search, $replace, $html);
    return $html;
  } else {
      return $html;
  }
}

/*********************************************************************************************

Remove Inline CSS for Galleries

*********************************************************************************************/

add_filter( 'use_default_gallery_style', '__return_false' );


function extract_gallery( $content) {
    $expr = '/\[gallery(.*?)\]/i';
    $content = preg_match_all($expr, $content, $matches);
    $galleries ='';
    foreach ($matches[0] as $gallery) {
      $galleries .= do_shortcode($gallery);
    }
    return $galleries;
    
}

