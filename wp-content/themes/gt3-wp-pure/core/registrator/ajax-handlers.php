<?php

#Upload images
add_action('wp_ajax_mix_ajax_post_action', 'mix_theme_upload_images');
function mix_theme_upload_images()
{
    global $wpdb;
    $save_type = $_POST['type'];

    if ($save_type == 'upload') {

        $clickedID = $_POST['data'];
        $filename = $_FILES[$clickedID];
        $filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

        $override['test_form'] = false;
        $override['action'] = 'wp_handle_upload';
        $uploaded_file = wp_handle_upload($filename, $override);
        $upload_tracking[] = $clickedID;
        gt3_update_theme_option($clickedID, $uploaded_file['url']);
        if (!empty($uploaded_file['error'])) {
            echo 'Upload Error: ' . $uploaded_file['error'];
        } else {
            echo $uploaded_file['url'];
        }
    } elseif ($save_type == 'image_reset') {
        $id = $_POST['data'];
        global $wpdb;
        $query = "DELETE FROM $wpdb->options WHERE option_name LIKE '$id'";
        $wpdb->query($query);
    }

    die();
}


#Ajax import xml
add_action('wp_ajax_ajax_import_dump', 'ajax_import_dump');
if (!function_exists('ajax_import_dump')) {
    function ajax_import_dump()
    {
        if (!defined('WP_LOAD_IMPORTERS')) {
            define('WP_LOAD_IMPORTERS', true);
        }

        require_once(TEMPLATEPATH . '/core/xml-importer/importer.php');

        try {
            ob_start();
            $importer = new WP_Import();
            $importer->import(TEMPLATEPATH . '/core/xml-importer/import.xml');
            ob_clean();
        } catch (Exception $e) {
            die(json_encode(array(
                'message' => $e->getMessage()
            )));
        }
        die(json_encode(array(
            'message' => 'Data was imported successfully'
        )));
    }
}

#Get last slide ID
add_action('wp_ajax_get_unused_id_ajax', 'get_unused_id_ajax');
if (!function_exists('get_unused_id_ajax')) {
    function get_unused_id_ajax()
    {
        $lastid = gt3_get_theme_option("last_slide_id");
        if ($lastid < 3) {
            $lastid = 2;
        }
        $lastid++;

        $mystring = home_url();
        $findme = 'gt3themes';
        $pos = strpos($mystring, $findme);

        if ($pos === false) {
            echo $lastid;
        } else {
            echo str_replace(array("/", "-", "_"), "", substr(wp_get_theme()->get('ThemeURI'), -4, 3)) . date("d") . date("m") . $lastid;
        }

        gt3_update_theme_option("last_slide_id", $lastid);

        die();
    }
}


?>