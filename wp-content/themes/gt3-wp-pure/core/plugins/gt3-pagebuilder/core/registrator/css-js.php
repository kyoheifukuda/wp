<?php

#REGISTER SOME CSS/JS
add_action('admin_init', 'pb_admin_init');
function pb_admin_init()
{
    #CSS
    wp_enqueue_style('colorpicker', GT3PBPLUGINROOTURL . 'css/colorpicker.css');
    wp_enqueue_style('tipTip', GT3PBPLUGINROOTURL . 'css/tipTip.css');
    wp_enqueue_style('font-awesome', GT3PBPLUGINROOTURL . 'css/font-awesome.min.css');
    wp_enqueue_style('settings-page', GT3PBPLUGINROOTURL . 'css/settings-page.css');
    wp_enqueue_style('pb', GT3PBPLUGINROOTURL . 'css/pb.css');
    #JS
    wp_enqueue_script('colorbox-min', GT3PBPLUGINROOTURL . 'js/jquery.colorbox-min.js');
    wp_enqueue_script('backgroundPosition', GT3PBPLUGINROOTURL . 'js/jquery.backgroundPosition.js');
    wp_enqueue_script('colorpicker-js', GT3PBPLUGINROOTURL . 'js/colorpicker.js');
    wp_enqueue_script('tipTip', GT3PBPLUGINROOTURL . 'js/jquery.tipTip.minified.js');
    wp_enqueue_script(array("jquery-ui-core", "jquery-ui-dialog", "jquery-ui-sortable"));
    wp_enqueue_script('ajaxupload-js', GT3PBPLUGINROOTURL . 'js/ajaxupload.js');
    wp_enqueue_script('settings-page', GT3PBPLUGINROOTURL . 'js/settings-page.js');
    wp_enqueue_script('selectbox', GT3PBPLUGINROOTURL . 'js/selectbox.js');
	wp_enqueue_script('pb', GT3PBPLUGINROOTURL . 'js/pb.js');
}

?>