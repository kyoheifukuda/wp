<?php

#Frontend
if (!function_exists('css_js_register')) {
    function css_js_register()
    {
        $wp_upload_dir = wp_upload_dir();

        #CSS
        wp_enqueue_style('gt3_default_style', get_bloginfo('stylesheet_url'));
        wp_enqueue_style("gt3_theme", get_template_directory_uri() . '/css/theme.css');
        wp_enqueue_style("gt3_custom", $wp_upload_dir['baseurl'] . "/" . "custom.css");

        #JS
        wp_enqueue_script("jquery");
        wp_enqueue_script('gt3_theme_js', get_template_directory_uri() . '/js/theme.js', array(), false, true);
    }
}
add_action('wp_enqueue_scripts', 'css_js_register');

#Admin
add_action('admin_enqueue_scripts', 'admin_css_js_register');
function admin_css_js_register()
{
    #CSS (MAIN)
    wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/core/admin/css/jquery-ui.css');
    wp_enqueue_style('colorpicker_css', get_template_directory_uri() . '/core/admin/css/colorpicker.css');
    wp_enqueue_style('gallery_css', get_template_directory_uri() . '/core/admin/css/gallery.css');
    wp_enqueue_style('colorbox_css', get_template_directory_uri() . '/core/admin/css/colorbox.css');
    wp_enqueue_style('selectBox_css', get_template_directory_uri() . '/core/admin/css/jquery.selectBox.css');
    wp_enqueue_style('admin_css', get_template_directory_uri() . '/core/admin/css/admin.css');
    #CSS OTHER

    #JS (MAIN)
    wp_enqueue_script('admin_js', get_template_directory_uri() . '/core/admin/js/admin.js');
    wp_enqueue_script('ajaxupload_js', get_template_directory_uri() . '/core/admin/js/ajaxupload.js');
    wp_enqueue_script('colorpicker_js', get_template_directory_uri() . '/core/admin/js/colorpicker.js');
    wp_enqueue_script('selectBox_js', get_template_directory_uri() . '/core/admin/js/jquery.selectBox.js');
    wp_enqueue_script('backgroundPosition_js', get_template_directory_uri() . '/core/admin/js/jquery.backgroundPosition.js');
    wp_enqueue_script(array("jquery-ui-core", "jquery-ui-dialog", "jquery-ui-sortable"));
    wp_enqueue_media();
}

#Data for creating static css/js files.
$custom_css = new cssJsGenerator(
    $filename = "custom.css",
    $filetype = "css",
    $output = '
    /* Main Font */
    header a, h1, h2, h3, h4, h5, h6, body, code, body #mc_signup_submit, input, textarea
    {font-family:"' . gt3_get_theme_option("main_font") . '";}

    /* Main Color */
    .dropcap.type2,
    .shortcode_blockquote.type2:before,
    .dropcap.type5,
    .menu li:hover a,
    .menu_mobile li:hover a,
    .menu_mobile li:hover li:hover a,
    .menu_mobile li:hover li:hover li:hover a,
    .box_type2,
    .menu li:hover .sub-menu li:hover > a,
    a,
    .featured_items_title a:hover,
    .fp_cat a:hover,
    .most_popular .currprice,
    .most_popular .currperiod,
    .contact_info_text a:hover,
    .block_post_meta_stand a:hover,
    .prev_next_links a:hover,
    .portfolio_item_title:hover h4,
    .post-comments span:hover,
    .preview_categ a:hover
    {color:#' . gt3_get_theme_option("color_theme") . ';}

    /* Border Color */
    .shortcode_blockquote.type5
    {border-color:#' . gt3_get_theme_option("color_theme") . ';}

    /* Main Background-Color */
    .btn_type5,
    hr.type3,
    body .btn_type3:hover,
    body .btn_type1:hover,
    .most_popular .shortcode_button,
    .sicon
    {background-color:#' . gt3_get_theme_option("color_theme") . ';}

    /* Headers */
    h1 {font-size:' . gt3_get_theme_option("h1_font_size") . ';line-height:' . gt3_get_theme_option("h1_line_height") . '; letter-spacing: ' . gt3_get_theme_option("h1_letter_spacing") . ';}
    h2 {font-size:' . gt3_get_theme_option("h2_font_size") . ';line-height:' . gt3_get_theme_option("h2_line_height") . '; letter-spacing: ' . gt3_get_theme_option("h2_letter_spacing") . ';}
    h3 {font-size:' . gt3_get_theme_option("h3_font_size") . ';line-height:' . gt3_get_theme_option("h3_line_height") . '; letter-spacing: ' . gt3_get_theme_option("h3_letter_spacing") . ';}
    h4 {font-size:' . gt3_get_theme_option("h4_font_size") . ';line-height:' . gt3_get_theme_option("h4_line_height") . '; letter-spacing: ' . gt3_get_theme_option("h4_letter_spacing") . ';}
    h5 {font-size:' . gt3_get_theme_option("h5_font_size") . ';line-height:' . gt3_get_theme_option("h5_line_height") . '; letter-spacing: ' . gt3_get_theme_option("h5_letter_spacing") . ';}
    h6, .comment-reply-title {font-size:' . gt3_get_theme_option("h6_font_size") . ';line-height:' . gt3_get_theme_option("h6_line_height") . ';}
    '
);

?>