<?php
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails', array('post', 'page', 'port', 'team', 'testimonials', 'partners'));
    add_theme_support('automatic-feed-links');
}


#add shortcode button to tinyMCE
function shortcode_button_reg($buttons)
{
    array_push($buttons, 'shortcodes');
    return $buttons;
}

add_filter('mce_buttons', 'shortcode_button_reg', 0);


function shortcode_js_reg($plugin_array)
{
    $plugin_array['shortcodes'] = GT3PBPLUGINROOTURL . '/js/shortcodes.js';
    return $plugin_array;
}

add_filter('mce_external_plugins', 'shortcode_js_reg');


/* MOOORE Excerpt length */
function custom_excerpt_length($length)
{
    return 200;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);


function addFeaturedImageSupport()
{
    add_theme_support('post-formats', array('image', 'video'));
}
add_action('after_setup_theme', 'addFeaturedImageSupport');


$shortcodesUI = new shortcodesUI();

?>