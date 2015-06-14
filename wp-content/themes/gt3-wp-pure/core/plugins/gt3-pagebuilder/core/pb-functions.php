<?php

function add_pb_to_content($content)
{
    $gt3_theme_pagebuilder = get_plugin_pagebuilder(get_the_ID());

    global $contentAlreadyPrinted;
    if (!post_password_required()) {
        $custom_content = get_pb_parser((isset($gt3_theme_pagebuilder['modules']) ? $gt3_theme_pagebuilder['modules'] : array()));
    } else {
        $custom_content = '';
    }
    if (isset($contentAlreadyPrinted) && $contentAlreadyPrinted == true) {
        $content = $custom_content;
    } else {
        $content .= $custom_content;
    }
    return $content;
}

add_filter('the_content', 'add_pb_to_content');

/*Work with options*/
function gt3pb_get_option($optionname, $defaultValue = "")
{
    $returnedValue = get_option("gt3pb_" . $optionname, $defaultValue);

    if (gettype($returnedValue) == "string") {
        return stripslashes($returnedValue);
    } else {
        return $returnedValue;
    }
}

function gt3pb_delete_option($optionname)
{
    return delete_option("gt3pb_" . $optionname);
}

function gt3pb_update_option($optionname, $optionvalue)
{
    if (update_option("gt3pb_" . $optionname, $optionvalue)) {
        return true;
    }
}

if (!function_exists('smarty_modifier_truncate')) {
    function smarty_modifier_truncate($string, $length = 80, $etc = '... ',
                                      $break_words = false, $middle = false)
    {
        if ($length == 0)
            return '';

        if (mb_strlen($string, 'utf8') > $length) {
            $length -= mb_strlen($etc, 'utf8');
            if (!$break_words && !$middle) {
                $string = preg_replace('/\s+\S+\s*$/su', '', mb_substr($string, 0, $length + 1, 'utf8'));
            }
            if (!$middle) {
                return mb_substr($string, 0, $length, 'utf8') . $etc;
            } else {
                return mb_substr($string, 0, $length / 2, 'utf8') . $etc . mb_substr($string, -$length / 2, utf8);
            }
        } else {
            return $string;
        }
    }
}

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

#GET UNUSED ID FOR ALL MODULES
function get_unused_id()
{
    $lastid = gt3pb_get_option("last_slide_id");
    if ($lastid < 3) {
        $lastid = 2;
    }
    $lastid++;

    gt3pb_update_option("last_slide_id", $lastid);

    $mystring = home_url();
    $findme = 'gt3themes';
    $pos = strpos($mystring, $findme);

    if ($pos === false) {
        return $lastid;
    } else {
        return str_replace(array("/", "-", "_"), "", substr(wp_get_theme()->get('ThemeURI'), -4, 3)) . date("d") . date("m") . $lastid;
    }

}


function the_select_options($option_array, $selected_value = "")
{
    if (is_array($option_array)) {
        foreach ($option_array as $key => $value) {
            if ($value == $selected_value) {
                echo "<option value='{$value}' selected='selected'>{$value}</option>";
            } else {
                echo "<option value='{$value}'>{$value}</option>";
            }
        }
    }
}

function get_select_options($option_array, $selected_value = "")
{
    if (!isset($compile)) {
        $compile = '';
    }
    if (is_array($option_array)) {
        foreach ($option_array as $key => $value) {
            if ($value == $selected_value) {
                $compile .= "<option value='{$value}' selected='selected'>{$value}</option>";
            } else {
                $compile .= "<option value='{$value}'>{$value}</option>";
            }
        }
    }

    return $compile;
}

function get_select_options_with_caption($option_array, $selected_value = "")
{
    if (!isset($compile)) {
        $compile = '';
    }
    if (is_array($option_array)) {
        foreach ($option_array as $key => $value) {
            if ($key == $selected_value) {
                $compile .= "<option value='{$key}' selected='selected'>{$value}</option>";
            } else {
                $compile .= "<option value='{$key}'>{$value}</option>";
            }
        }
    }

    return $compile;
}


function get_media_for_this_post($postid, $page = "1")
{
    $args = array(
        'post_type' => 'attachment',
        'numberposts' => $GLOBALS["pbconfig"]['images_from_media_library'],
        'post_status' => null,
        'order' => 'DESC',
        'paged' => $page
    );
    $images = get_posts($args);
    if (is_array($images) && $images) {
        foreach ($images as $image) {
            $meta = wp_get_attachment_metadata($image->ID);
            if ((isset($meta['width']) && $meta['width'] > 0) && !isset($meta['audio'])) {
                $imgpack[] = array("guid" => $image->guid, "width" => $meta['width'], "height" => $meta['height'], "attach_id" => $image->ID);
            }
        }
        return $imgpack;
    }
    return false;
}


function get_selected_pf_images_for_admin($gt3_theme_pagebuilder)
{
    if (!isset($compile)) {
        $compile = '';
    }
    if (isset($gt3_theme_pagebuilder['post-formats']['images']) && is_array($gt3_theme_pagebuilder['post-formats']['images'])) {
        foreach ($gt3_theme_pagebuilder['post-formats']['images'] as $imgid => $img) {
            $compile .= "<div class='img-item style_small'><div class='img-preview'><img src='" . aq_resize(wp_get_attachment_url($img['attach_id']), "62", "62", true) . "' data-full-url='".wp_get_attachment_url($img['attach_id'])."' data-thumb-url='" . aq_resize(wp_get_attachment_url($img['attach_id']), "156", "106", true, true, true) . "' alt='' class='previmg'><div class='hover-container'></div><div class='deldel-container'></div></div><input type='hidden' name='pagebuilder[post-formats][images][" . $imgid . "][attach_id]' value='{$img['attach_id']}'></div>";
        }
    }
    return $compile;
}

if (!function_exists('get_selected_pf_images')) {
    function get_selected_pf_images($gt3_theme_pagebuilder)
    {
        if (is_array($gt3_theme_pagebuilder['post-formats']['images'])) {
            if (!isset($compile)) {
                $compile = '';
            }
            if (count($gt3_theme_pagebuilder['post-formats']['images']) == 1) {
                $onlyOneImage = "oneImage";
            } else {
                $onlyOneImage = "";
            }
            $compile .= '
                <div class="slider-wrapper theme-default ' . $onlyOneImage . '">
                    <div class="nivoSlider">
            ';

            if (is_array($gt3_theme_pagebuilder['post-formats']['images'])) {
                foreach ($gt3_theme_pagebuilder['post-formats']['images'] as $imgid => $img) {
                    $compile .= '
                        <img src="' . aq_resize($img['src'], "1170", "563", true, true, true) . '" data-thumb="' . aq_resize($img['src'], "1170", "563", true, true, true) . '" alt="" />
                    ';
                }
            }

            $compile .= '
                    </div>
                </div>
            ';

        }
        return $compile;
    }
}


function get_media_html($media_array, $style = "small")
{
    if (is_array($media_array) && count($media_array) > 0) {

        $compile = "<span class='available_media_arrow left_arrow'></span><span class='available_media_arrow right_arrow'></span><div class='clear'></div>";

        foreach ($media_array as $media_item) {

            $media_url = $media_item['guid'];
            $media_width = $media_item['width'];
            $media_height = $media_item['height'];
            $attach_id = $media_item['attach_id'];

            #style 1
            if ($style == "small") {
                $compile .= "
                <div class='img-item style_small available_media_item'>
                    <div class='img-preview'>
                        <img class='previmg' alt='' data-thumb-url='" . aq_resize($media_url, "156", "106", true, true, true) . "' data-full-url='" . $media_url . "' data-attach-id='".$attach_id."' src='" . aq_resize($media_url, "62", "62", true, true, true) . "'>
                        <div class='hover-container'>
                            <div class='media_size'>" . $media_width . "px<br>x<br>" . $media_height . "px</div>
                        </div>
                    </div>
                </div><!-- .img-item -->
                ";
            }
        }

        return $compile;
    }

    return false;
}

#GET ITEMS FOR SLIDER (ADMIN)
function get_slider_items($slider_type, $array)
{
    if (is_array($array)) {

        $compile = "";

        foreach ($array as $key => $slide) {
            if (!isset($slide['title']['value'])) {
                $slide['title']['value'] = "";
            }
            if (!isset($slide['caption']['value'])) {
                $slide['caption']['value'] = "";
            }

            #fullscreen slider
            if ($slider_type == "fullscreen") {
                $compile .= "<li>";
                #IF SLIDE IS IMAGE
                if ($slide['slide_type'] == "image") {
                    $compile .= "
                    <div class='img-item item-with-settings'>
                        <input type='hidden' name='pagebuilder[sliders][fullscreen][slides][{$key}][attach_id]' value='{$slide['attach_id']}'>
                        <input type='hidden' name='pagebuilder[sliders][fullscreen][slides][{$key}][slide_type]' value='image'>
                        <div class='img-preview'>
                            <img alt='' src='" . aq_resize(wp_get_attachment_url( $slide['attach_id'] ), "156", "106", true, true, true) . "'>
                            <div class='hover-container'>
                                <div class='inter_x'></div>
                                <div class='inter_drag'></div>
                                <div class='inter_edit'></div>
                            </div>
                        </div>
                        <div class='edit_popup'>
                            <h2>Image Settings</h2>
                            <span class='edit_popup_close'></span>
                            <div class='this-option img-in-slider'>
                                <div class='padding-cont'>
                                    <div class='fl w9'>
                                        <h4>" . __('Title', 'gt3_builder') . "</h4>
                                        <input name='pagebuilder[sliders][fullscreen][slides][{$key}][title][value]' type='text' value='{$slide['title']['value']}' class='textoption type1'>
                                    </div>
                                    <div class='right_block fl w1'>
                                        <h4>" . __('color', 'gt3_builder') . "</h4>
                                        " . colorpicker_block("pagebuilder[sliders][fullscreen][slides][{$key}][title][color]", $slide['title']['color']) . "
                                    </div>
                                    <div class='clear'></div>
                                </div>
                                <div class='hr_double'></div>
                                <div class='padding-cont'>
                                    <div class='fl w9'>
                                        <h4>" . __('Caption', 'gt3_builder') . "</h4>
                                        <textarea name='pagebuilder[sliders][fullscreen][slides][{$key}][caption][value]' type='text' class='textoption type1 big'>{$slide['caption']['value']}</textarea>
                                    </div>
                                    <div class='right_block fl w1'>
                                        <h4>" . __('color', 'gt3_builder') . "</h4>
                                        " . colorpicker_block("pagebuilder[sliders][fullscreen][slides][{$key}][caption][color]", $slide['caption']['color']) . "
                                    </div>
                                    <div class='clear'></div>
                                </div>
                            </div>
                            <div class='padding-cont'>
                                <input type='button' value='Done' class='done-btn green-btn' name='ignore_this_button'>
                                <div class='clear'></div>
                            </div>
                        </div>
                    </div><!-- .img-item -->
                    ";
                }
                #IF SLIDE IS VIDEO
                if ($slide['slide_type'] == "video") {
                    $compile .= "
                    <div class='img-item item-with-settings'>
                        <input type='hidden' name='pagebuilder[sliders][fullscreen][slides][{$key}][src]' value='{$slide['src']}'>
                        <input type='hidden' name='pagebuilder[sliders][fullscreen][slides][{$key}][slide_type]' value='video'>
                        <div class='img-preview'>
                            <img alt='' src='" . PBIMGURL . "/video_item.png'>
                            <div class='hover-container'>
                                <div class='inter_x'></div>
                                <div class='inter_drag'></div>
                                <div class='inter_edit'></div>
                            </div>
                            " . show_video_preview($slide['src']) . "
                        </div>
                        <div class='edit_popup'>
                            <h2>" . __('Video settings', 'gt3_builder') . "</h2>
                            <span class='edit_popup_close'></span>
                            <div class='this-option'>
                                <div class='padding-cont'>
                                    <h4>" . __('Video URL (YouTube or Vimeo)', 'gt3_builder') . "</h4>
                                    <input name='pagebuilder[sliders][fullscreen][slides][{$key}][src]' type='text' value='{$slide['src']}' class='textoption type1'>
                                    <div class='example'>
                                        " . __('Examples:', 'gt3_builder') . "<br>
                                        Youtube - http://www.youtube.com/watch?v=6v2L2UGZJAM<br>
                                        Vimeo - http://vimeo.com/47989207
                                    </div>
                                </div>
                                <div class='padding-cont' style='padding-top:0;'>
                                    <div class='fl w9' style='width:601px;'>
                                        <h4>" . __('Title and thumbnail', 'gt3_builder') . "</h4>
                                        <input name='pagebuilder[sliders][fullscreen][slides][{$key}][title][value]' type='text' value='{$slide['title']['value']}' class='textoption type1'>
                                    </div>
                                    <div class='right_block fl w1' style='width:115px;'>
                                        <h4>" . __('color', 'gt3_builder') . "</h4>
                                        " . colorpicker_block("pagebuilder[sliders][fullscreen][slides][{$key}][title][color]", $slide['title']['color']) . "
                                    </div>
                                   <div class='preview_img_video_cont'>
			                            ".gt3_get_field_media_and_attach_id ("pagebuilder[sliders][fullscreen][slides][{$key}][attach_id]", $slide['attach_id'])."
                                        <div class='clear'></div>
		                            </div>
                                    <div class='clear'></div>
                                </div>
                                <div class='hr_double'></div>
                                <div class='padding-cont'>
                                    <div class='fl w9' style='width:601px;'>
                                        <h4>" . __('Caption', 'gt3_builder') . "</h4>
                                        <textarea name='pagebuilder[sliders][fullscreen][slides][{$key}][caption][value]' type='text' class='textoption type1 big' style='height:70px;'>{$slide['caption']['value']}</textarea>
                                    </div>
                                    <div class='right_block fl w1' style='width:115px;'>
                                        <h4>" . __('color', 'gt3_builder') . "</h4>
                                        " . colorpicker_block("pagebuilder[sliders][fullscreen][slides][{$key}][caption][color]", $slide['caption']['color']) . "
                                    </div>
                                    <div class='clear'></div>
                                </div>
                            </div>
                            <div class='hr_double'></div>
                            <div class='padding-cont'>
                                <input type='button' value='Done' class='done-btn green-btn' name='ignore_this_button'>
                                <div class='clear'></div>
                            </div>
                        </div>
                    </div><!-- .img-item -->
                    ";
                }
                $compile .= "</li>";
            }

            #fullwidth slider
            if ($slider_type == "fullwidth") {
                $compile .= "<li>";
                #IF SLIDE IS IMAGE
                if ($slide['slide_type'] == "image") {
                    $compile .= "
                    <div class='img-item item-with-settings'>
                        <input type='hidden' name='pagebuilder[sliders][fullwidth][slides][{$key}][src]' value='{$slide['src']}'>
                        <input type='hidden' name='pagebuilder[sliders][fullwidth][slides][{$key}][slide_type]' value='image'>
                        <div class='img-preview'>
                            <img alt='' src='" . aq_resize($slide['src'], "156", "106", true, true, true) . "'>
                            <div class='hover-container'>
                                <div class='inter_x'></div>
                                <div class='inter_drag'></div>
                                <div class='inter_edit'></div>
                            </div>
                        </div>
                        <div class='edit_popup'>
                            <h2>" . __('Image Settings', 'gt3_builder') . "</h2>
                            <span class='edit_popup_close'></span>
                            <div class='this-option img-in-slider'>
                                <div class='padding-cont'>
                                    <div class='fl w9'>
                                        <h4>" . __('Title', 'gt3_builder') . "</h4>
                                        <input name='pagebuilder[sliders][fullwidth][slides][{$key}][title][value]' type='text' value='{$slide['title']['value']}' class='textoption type1'>
                                    </div>
                                    <div class='right_block fl w1'>
                                        <h4>" . __('color', 'gt3_builder') . "</h4>
                                        " . colorpicker_block("pagebuilder[sliders][fullwidth][slides][{$key}][title][color]", $slide['title']['color']) . "
                                    </div>
                                    <div class='clear'></div>
                                </div>
                                <div class='hr_double'></div>
                                <div class='padding-cont'>
                                    <div class='fl w9'>
                                        <h4>" . __('Caption', 'gt3_builder') . "</h4>
                                        <textarea name='pagebuilder[sliders][fullwidth][slides][{$key}][caption][value]' type='text' class='textoption type1 big'>{$slide['caption']['value']}</textarea>
                                    </div>
                                    <div class='right_block fl w1'>
                                        <h4>" . __('color', 'gt3_builder') . "</h4>
                                        " . colorpicker_block("pagebuilder[sliders][fullwidth][slides][{$key}][caption][color]", $slide['caption']['color']) . "
                                    </div>
                                    <div class='clear'></div>
                                </div>
                            </div>
                            <div class='padding-cont'>
                                <input type='button' value='Done' class='done-btn green-btn' name='ignore_this_button'>
                                <div class='clear'></div>
                            </div>
                        </div>
                    </div><!-- .img-item -->
                    ";
                }
                #IF SLIDE IS VIDEO
                if ($slide['slide_type'] == "video") {
                    $compile .= "
                    <div class='img-item item-with-settings'>
                        <input type='hidden' name='pagebuilder[sliders][fullwidth][slides][{$key}][src]' value='{$slide['src']}'>
                        <input type='hidden' name='pagebuilder[sliders][fullwidth][slides][{$key}][slide_type]' value='video'>
                        <div class='img-preview'>
                            <img alt='' src='" . PBIMGURL . "/video_item.png'>
                            <div class='hover-container'>
                                <div class='inter_x'></div>
                                <div class='inter_drag'></div>
                                <div class='inter_edit'></div>
                            </div>
                            " . show_video_preview($slide['src']) . "
                        </div>
                        <div class='edit_popup'>
                            <h2>" . __('Video settings', 'gt3_builder') . "</h2>
                            <span class='edit_popup_close'></span>
                            <div class='this-option'>
                                <div class='padding-cont'>
                                    <h4>" . __('Video URL (YouTube or Vimeo)', 'gt3_builder') . "</h4>
                                    <input name='pagebuilder[sliders][fullwidth][slides][{$key}][src]' type='text' value='{$slide['src']}' class='textoption type1'>
                                    <div class='example'>
                                        " . __('Examples:', 'gt3_builder') . "<br>
                                        Youtube - http://www.youtube.com/watch?v=6v2L2UGZJAM<br>
                                        Vimeo - http://vimeo.com/47989207
                                    </div>
                                </div>
                                <div class='padding-cont' style='padding-top:0;'>
                                    <div class='fl w9' style='width:601px;'>
                                        <h4>" . __('Title and thumbnail', 'gt3_builder') . "</h4>
                                        <input name='pagebuilder[sliders][fullwidth][slides][{$key}][title][value]' type='text' value='{$slide['title']['value']}' class='textoption type1'>
                                    </div>
                                    <div class='right_block fl w1' style='width:115px;'>
                                        <h4>" . __('color', 'gt3_builder') . "</h4>
                                        " . colorpicker_block("pagebuilder[sliders][fullwidth][slides][{$key}][title][color]", $slide['title']['color']) . "
                                    </div>
                                   <div class='preview_img_video_cont'>
                                        <input type='text' value='{$slide['thumbnail']['value']}' id='slide_{$key}_upload' name='pagebuilder[sliders][fullwidth][slides][{$key}][thumbnail][value]' class='textoption type1' style='width:601px;float:left;'>
                                        <div class='up_btns'>
                                            <span id='slide_{$key}' class='button btn_upload_image style2 but_slide_{$key}'>" . __('Upload Image', 'gt3_builder') . "</span>
                                        </div>
                                        <div class='clear'></div>
                                    </div>
                                    <div class='clear'></div>
                                </div>
                                <div class='hr_double'></div>
                                <div class='padding-cont'>
                                    <div class='fl w9' style='width:601px;'>
                                        <h4>" . __('Caption', 'gt3_builder') . "</h4>
                                        <textarea name='pagebuilder[sliders][fullwidth][slides][{$key}][caption][value]' type='text' class='textoption type1 big' style='height:70px;'>{$slide['caption']['value']}</textarea>
                                    </div>
                                    <div class='right_block fl w1' style='width:115px;'>
                                        <h4>" . __('color', 'gt3_builder') . "</h4>
                                        " . colorpicker_block("pagebuilder[sliders][fullwidth][slides][{$key}][caption][color]", $slide['caption']['color']) . "
                                    </div>
                                    <div class='clear'></div>
                                </div>
                            </div>
                            <div class='hr_double'></div>
                            <div class='padding-cont'>
                                <input type='button' value='Done' class='done-btn green-btn' name='ignore_this_button'>
                                <div class='clear'></div>
                            </div>
                        </div>
                    </div><!-- .img-item -->
                    ";
                }
                $compile .= "</li>";
            }
        }

        return $compile;
    }

    return false;
}


/* SHOW VIDEO PREVIEW IN POPUP (admin area) */
function show_video_preview($videourl)
{
    $compile_inner = "";

    #YOUTUBE
    $is_youtube = substr_count($videourl, "youtu");
    if ($is_youtube > 0) {
        $videoid = substr(strstr($videourl, "="), 1);
        $compile_inner = "
            <iframe width=\"395\" height=\"295\" src=\"http://www.youtube.com/embed/" . $videoid . "\" frameborder=\"0\" allowfullscreen></iframe>
        ";
    }

    #VIMEO
    $is_vimeo = substr_count($videourl, "vimeo");
    if ($is_vimeo > 0) {
        $videoid = substr(strstr($videourl, "m/"), 2);
        $compile_inner = "
            <iframe src=\"http://player.vimeo.com/video/" . $videoid . "\" width=\"395\" height=\"295\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        ";
    }

    $compile = "
        <div class='video_preview'>
            <div class='video_inner'>
                {$compile_inner}
            </div>
        </div>
    ";

    return $compile;
}


function colorpicker_block($name, $value, $additional_class = "")
{
    return "
    <div class='color_picker_block {$additional_class}'>
        <span class='sharp'>#</span>
        <input type='text' value='{$value}' name='{$name}' maxlength='25' class='medium cpicker textoption type1'>
        <input type='text' value='' class='textoption type1 cpicker_preview' disabled='disabled'>
    </div>
    ";
}


function toggle_radio_yes_no($settingsname, $settingstate, $default_state = "yes", $additional_class = "")
{

    if (!isset($checked_state_yes)) {
        $checked_state_yes = '';
    }
    if (!isset($checked_state_no)) {
        $checked_state_no = '';
    }

    if ($default_state == "yes") {
        $checked_state_yes = "checked='checked'";
    }
    if ($default_state == "no") {
        $checked_state_no = "checked='checked'";
    }

    if ($settingstate == "yes") {
        $checked_state_yes = "checked='checked'";
        $checked_state_no = "";
    }
    if ($settingstate == "no") {
        $checked_state_no = "checked='checked'";
        $checked_state_yes = "";
    }
    return "
<div class='radio_toggle_cont {$additional_class}'>
    <input type='radio' class='checkbox_slide yes_state' {$checked_state_yes} value='yes' name='{$settingsname}'>
    <input type='radio' class='checkbox_slide no_state' {$checked_state_no} value='no' name='{$settingsname}'>
    <div class='radio_toggle_mirage'></div>
</div>
";
}


function pb_setting_input($settingsname, $settingstate, $default_state = "yes", $additional_class = "")
{
    if ($settingstate == "") {
        $settingstate = $default_state;
    }
    return "
    <input type='text' class='textoption type1 settings_input {$additional_class}' value='{$settingstate}' name='{$settingsname}'>
";
}

function toggle_radio_on_off($settingsname, $settingstate, $default_state = "on", $additional_class = "")
{
    if (!isset($checked_state_on)) {
        $checked_state_on = '';
    }
    if (!isset($checked_state_off)) {
        $checked_state_off = '';
    }

    if ($default_state == "on") {
        $checked_state_on = "checked='checked'";
    }
    if ($default_state == "off") {
        $checked_state_off = "checked='checked'";
    }

    if ($settingstate == "on") {
        $checked_state_on = "checked='checked'";
        $checked_state_off = "";
    }
    if ($settingstate == "off") {
        $checked_state_off = "checked='checked'";
        $checked_state_on = "";
    }
    return "
<div class='radio_toggle_cont on_off_style {$additional_class}'>
    <input type='radio' class='checkbox_slide yes_state' {$checked_state_on} value='on' name='{$settingsname}'>
    <input type='radio' class='checkbox_slide no_state' {$checked_state_off} value='off' name='{$settingsname}'>
    <div class='radio_toggle_mirage'></div>
</div>
";
}


function get_html_all_available_pb_modules($modules)
{
    if (!isset($compile)) {
        $compile = "";
    }
    if (is_array($modules)) {
        foreach ($modules as $module_key) {
            $compile .= "
            <div title='" . $module_key['help'] . "' class='pb-module text-shadow1 visual_style1 tiptip' data-module-name='" . $module_key['name'] . "'>
                <span class='module-name'>" . $module_key['caption'] . "</span>
            </div>
            ";
        }
    }

    return $compile;
}


function replace_br_to_rn_in_multiarray(&$item, $key)
{
    $item = str_replace(array("<br>", "<br />"), "\n", $item);
}

function get_plugin_pagebuilder($postid)
{
    $gt3_theme_pagebuilder = get_post_meta($postid, "pagebuilder", true);
    if (!is_array($gt3_theme_pagebuilder)) {
        $gt3_theme_pagebuilder = array();
    }

    if (!isset($gt3_theme_pagebuilder['settings']['show_content_area'])) {
        $gt3_theme_pagebuilder['settings']['show_content_area'] = "yes";
    }
    if (!isset($gt3_theme_pagebuilder['settings']['show_page_title'])) {
        $gt3_theme_pagebuilder['settings']['show_page_title'] = "yes";
    }

    array_walk_recursive($gt3_theme_pagebuilder, 'stripslashes_in_array');

    return $gt3_theme_pagebuilder;
}


function replace_rn_to_br_in_multiarray(&$item, $key)
{
    if ($key !== "html") {
        $item = nl2br($item);
        $item = str_replace(array("\r\n", "\r", "\n"), '', $item);
    }
}

function before_save_pagebuilder_array(&$item, $key)
{
    if (
        $key == "heading_text" ||
        $key == "main_text" ||
        $key == "additional_text" ||
        $key == "iconbox_heading" ||
        $key == "block_name" ||
        $key == "block_price" ||
        $key == "block_period" ||
        $key == "get_it_now_caption" ||
        $key == "title" ||
        $key == "button_text"
    ) {
        $item = str_replace("'", "&#039;", $item);
        $item = str_replace('"', "&quot;", $item);
    }
}

function stripslashes_in_array(&$item)
{
    $item = stripslashes($item);
}

function update_theme_pagebuilder($post_id, $variableName, $gt3_theme_pagebuilderArray)
{
    array_walk_recursive($gt3_theme_pagebuilderArray, 'before_save_pagebuilder_array');
    update_post_meta($post_id, $variableName, $gt3_theme_pagebuilderArray);
    return true;
}

if (!function_exists('GT3PBbreaksToBR')) {
    function GT3PBbreaksToBR($content, $changeto = "")
    {

        $content = nl2br($content);
        $content = str_replace("\r\n", "", $content);
        $content = str_replace("\n", "", $content);

        return $content;
    }
}

#Custom paging
function get_plugin_pagination($range = 10, $type = "")
{
    $compile = "";
    if ($type == "show_in_shortcodes") {
        global $paged, $wp_query_in_shortcodes;
        $wp_query = $wp_query_in_shortcodes;
    } else {
        global $paged, $wp_query;
    }

    if (empty($paged)) {
        $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    }

    $max_page = $wp_query->max_num_pages;

    if ($max_page > 1) {
        $compile .= '<ul class="pagerblock">';
    }

    if ($max_page > 1) {
        if (!$paged) {
            $paged = 1;
        }
        $ppl = "<span class='btn_prev'></span>";
        if ($max_page > $range) {
            if ($paged < $range) {
                for ($i = 1; $i <= ($range + 1); $i++) {
                    $compile .= "<li><a href='" . get_pagenum_link($i) . "'";
                    if ($i == $paged) $compile .= " class='current'";
                    $compile .= ">$i</a></li>";
                }
            } elseif ($paged >= ($max_page - ceil(($range / 2)))) {
                for ($i = $max_page - $range; $i <= $max_page; $i++) {
                    $compile .= "<li><a href='" . get_pagenum_link($i) . "'";
                    if ($i == $paged) $compile .= " class='current'";
                    $compile .= ">$i</a></li>";
                }
            } elseif ($paged >= $range && $paged < ($max_page - ceil(($range / 2)))) {
                for ($i = ($paged - ceil($range / 2)); $i <= ($paged + ceil(($range / 2))); $i++) {
                    $compile .= "<li><a href='" . get_pagenum_link($i) . "'";
                    if ($i == $paged) $compile .= " class='current'";
                    $compile .= ">$i</a></li>";
                }
            }
        } else {
            for ($i = 1; $i <= $max_page; $i++) {
                $compile .= "<li><a href='" . get_pagenum_link($i) . "'";
                if ($i == $paged) $compile .= " class='current'";
                $compile .= ">$i</a></li>";
            }
        }
        $npl = "<span class='btn_next'></span>";
    }
    if ($max_page > 1) {
        $compile .= '</ul>';
    }

    return $compile;
}

if (!function_exists('generate_unused_id')) {
    function generate_unused_id()
    {
        $val = mt_rand(1000, 9999) + time();

        return $val;
    }
}

if (!function_exists('showPortCats')) {
    function showPortCats($post_type_terms = "")
    {
        if (!isset($term_list)) {
            $term_list = '';
        }
        $permalink = get_permalink();
        $args = array('taxonomy' => 'Category', 'include' => $post_type_terms);
        $terms = get_terms('portcat', $args);
        $count = count($terms);
        $i = 0;
        $iterm = 1;

        if ($count > 0) {
            if (!isset($_GET['slug'])) $all_current = 'selected';
            $cape_list = '';
            $term_list .= '
            <li class="grid_masonry_view"></li>
            <li class="inline_view"></li>
            <li class="' . $all_current . '"><a data-option-value="*" href="#filter">' . __('All', 'gt3_builder') . '</a></li>
            ';
            $termcount = count($terms) ;
            if (is_array($terms)) {
                foreach ($terms as $term) {
                    $i++;
                    $permalink = add_query_arg("slug", $term->slug, $permalink);
                    $term_list .= '<li ';
                    if (isset($_GET['slug'])) {
                        $getslug = $_GET['slug'];
                    } else {
                        $getslug = '';
                    }
                    if (strnatcasecmp($getslug, $term->name) == 0) $term_list .= 'class="selected"';

                    $tempname = strtr($term->name, array(
                        ' ' => '-',
                    ));
                    $tempname = strtolower($tempname);

                    $term_list .= '><a href="#filter" data-option-value=".' . $tempname . '" title="View all post filed under ">' . $term->name . '</a>
                </li>';
                    if ($count != $i) $term_list .= ' '; else $term_list .= '';
                    $iterm++;
                }
            }
            return '<ul class="optionset" data-option-key="filter">' . $term_list . '</ul>';
        }
    }
}

if (!function_exists('showPortCatsMasonry')) {
    function showPortCatsMasonry($post_type_terms = "")
    {
        if (!isset($term_list)) {
            $term_list = '';
        }
        $permalink = get_permalink();
        $args = array('taxonomy' => 'Category', 'include' => $post_type_terms);
        $terms = get_terms('portcat', $args);
        $count = count($terms);
        $i = 0;
        $iterm = 1;

        if ($count > 0) {
            $cape_list = '';
            $term_list .= '<li class="' . (!isset($_GET['slug']) ? 'selected' : '') . '">';

            $term_list .= '<a href="#filter" data-option-value="*">' . __('All', 'gt3_builder') . '</a>
			</li>';
            $termcount = count($terms);
            if (is_array($terms)) {
                foreach ($terms as $term) {
                    $i++;
                    $permalink = add_query_arg("slug", $term->term_id, $permalink);
                    $term_list .= '<li ';
                    if (isset($_GET['slug'])) {
                        $getslug = $_GET['slug'];
                    } else {
                        $getslug = '';
                    }
                    if (strnatcasecmp($getslug, $term->term_id) == 0) $term_list .= 'class="selected"';

                    $tempname = strtr($term->name, array(
                        ' ' => '-',
                    ));
                    $tempname = strtolower($tempname);

                    $term_list .= '><a href="#filter" data-option-value=".' . $tempname . '" title="' . __('View all post filed under', 'gt3_builder') . ' ">' . $term->name . '</a>
                </li>';
                    if ($count != $i) $term_list .= ' '; else $term_list .= '';

                    $iterm++;
                }
            }
            return '<ul class="optionset" data-option-key="filter">' . $term_list . '</ul>';
        }
    }
}

function pre($array)
{
    echo "<pre>Here your pre: ";
    print_r($array);
    echo "</pre>";
}


function my_custom_admin_head()
{

    echo '<script type="text/javascript">var GT3PBPLUGINROOTURL = "' . GT3PBPLUGINROOTURL . '";</script>';

}

add_action('admin_head', 'my_custom_admin_head');

#gt3pb_update_option("dev_console", "true");
#gt3pb_delete_option("dev_console");

?>