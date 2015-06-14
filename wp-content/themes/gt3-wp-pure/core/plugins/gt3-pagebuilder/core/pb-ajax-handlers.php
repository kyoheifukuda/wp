<?php
#Get media for postid
add_action('wp_ajax_get_media_for_postid', 'get_media_for_postid');
if (!function_exists('get_media_for_postid')) {
    function get_media_for_postid()
    {
        $postid = $_POST['post_id'];
        $page = $_POST['page'];
        $media_for_this_post = get_media_for_this_post($postid, $page);
        if (is_array($media_for_this_post) && count($media_for_this_post) > 0) {
            echo get_media_html($media_for_this_post, "small");
        } else {
            echo "no_items";
        }

        die();
    }
}


#Get module html
add_action('wp_ajax_get_module_html', 'get_module_html');
if (!function_exists('get_module_html')) {
    function get_module_html()
    {
        $module_caption = $_POST['module_caption'];
        $module_name = $_POST['module_name'];
        $postid = $_POST['postid_for_module'];
        $tinymce_activation_class = $_POST['tinymce_activation_class'];
        $module_size = "block_1_4";
        $size_caption = "1/4";

        if ($module_name == "bg_start" || $module_name == "bg_end") {
            $module_size = "block_1_1";
            $size_caption = "1/1";
        }

        echo get_pb_module($module_name, $module_caption, get_unused_id(), "", $module_size, $size_caption, $tinymce_activation_class);

        die();
    }
}

#Upload images
add_action('wp_ajax_mix_ajax_post_action', 'mix_ajax_callback');
if (!function_exists('mix_ajax_callback')) {
    function mix_ajax_callback()
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
            gt3pb_update_option($clickedID, $uploaded_file['url']);
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
}

#Compile ShortcodesUI and push it
add_action('wp_ajax_getshortcodesUI', 'prefix_ajax_getshortcodesUI');
if (!function_exists('prefix_ajax_getshortcodesUI')) {
    function prefix_ajax_getshortcodesUI()
    {
        $shortcodesUI = shortcodesUI::getInstance()->getCompile();

        echo "<div class='select_shortcode_cont'><div class='select_shortcode_label'>Select shortcode:</div> <div class='select_shortcode_dropdown'><select name='select_shortcode' class='select_shortcode'>";
        if (is_array($shortcodesUI)) {
            foreach ($shortcodesUI as $array) {
                echo "<option value='" . $array['name'] . "'>" . ((isset($array['caption']) && strlen($array['caption']) > 0) ? $array['caption'] : $array['name']) . "</option>";
            }
        }
        echo "</select></div><div class='clear'></div></div>";

        if (is_array($shortcodesUI)) {
            foreach ($shortcodesUI as $array) {
                echo "
                <div shortcodename='" . $array['name'] . "' class='shortcodeitem " . $array['name'] . "'>
                    <div class='handler_body'>" . $array['handler'] . "</div>                    
					<div class='shortcode_insert_button'><button class='insertshortcode button button-primary button-small'>" . __('Insert', 'gt3_builder') . "</button><div class='clear'></div></div>
                </div>				
                ";
            }
        }
        ?>

        <script>
            jQuery('.shortcodeitem:first').show();
        </script>

        <?php

        die();
    }
}


#Get unused ID
add_action('wp_ajax_get_unused_id_ajax', 'get_unused_id_ajax');
if (!function_exists('get_unused_id_ajax')) {
    function get_unused_id_ajax()
    {
        $lastid = gt3pb_get_option("last_slide_id");
        if ($lastid < 3) {
            $lastid = 2;
        }
        $lastid++;

        echo $lastid;

        gt3pb_update_option("last_slide_id", $lastid);

        die();
    }
}

?>