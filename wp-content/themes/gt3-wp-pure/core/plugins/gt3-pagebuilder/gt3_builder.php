<?php
/*
Plugin Name: GT3 Page Builder
Plugin URI: http://www.gt3themes.com/
Description: GT3 Page Builder is a powerful WordPress plugin that allows you to create the unlimited number of custom page layouts in WordPress themes. This special drag and drop plugin will save your time when building the pages.
Version: 1.4 (build d8cf3d0)
Author: GT3 Themes
Author URI: http://www.gt3themes.com/

--- THIS PLUGIN AND ALL FILES INCLUDED ARE COPYRIGHT © GT3 Themes 2013.
YOU MAY NOT MODIFY, RESELL, DISTRIBUTE, OR COPY THIS CODE IN ANY WAY. ---

*/

define('GT3PBVERSION', '1.4');
define('GT3PBPLUGINROOTURL', get_template_directory_uri().'/core/plugins/gt3-pagebuilder/');
define('GT3PBPLUGINPATH', plugin_dir_path(__FILE__));
define('PBIMGURL', GT3PBPLUGINROOTURL . "img/");

add_action('init', 'gt3pb_locale');
function gt3pb_locale()
{
    load_plugin_textdomain('gt3_builder', false, '/core/languages/');
}

/*Load files*/
require_once(GT3PBPLUGINPATH . "core/loader.php");

#SAVE
add_action('save_post', 'save_postdata');

#REGISTER PAGE BUILDER
add_action('add_meta_boxes', 'add_custom_box');
function add_custom_box()
{
    if (is_array($GLOBALS["pbconfig"]['page_builder_enable_for_posts'])) {
        foreach ($GLOBALS["pbconfig"]['page_builder_enable_for_posts'] as $post_type) {
            add_meta_box(
                'pb_section',
                __('GT3 Page Builder', 'gt3_builder'),
                'pagebuilder_inner_custom_box',
                $post_type
            );
        }
    }
}

function pagebuilder_inner_custom_box($post)
{
    isset($_POST['tinymce_activation_class']) ? $tinymce_activation_class = $_POST['tinymce_activation_class'] : $tinymce_activation_class = '';
    $now_post_type = get_post_type();

    wp_nonce_field(null, 'pagebuilder_noncename');
    $gt3_theme_pagebuilder = get_plugin_pagebuilder($post->ID);
    if (!is_array($gt3_theme_pagebuilder)) {
        $gt3_theme_pagebuilder = array();
    }

    global $modules;

#get all sidebars
    $media_for_this_post = get_media_for_this_post(get_the_ID());
    $js_for_pb = "
    <script>
        var post_id = " . get_the_ID() . ";
        var show_img_media_library_page = 1;
    </script>";

    echo $js_for_pb;
    echo "
<!-- popup background -->
<div class='popup-bg'></div>
<div class='waiting-bg'><div class='waiting-bg-img'></div></div>
";
#START BUILDER AREA
    if ($now_post_type == "page" && get_page_template_slug() == "page-contacts.php") {
        echo '
        <div class="pb-cont page-builder-container bbg">
            <div class="padding-cont">
                Google map:<br>
                <textarea name="pagebuilder[settings][google_map]" style="width: 100%; height: 140px;">'.(isset($gt3_theme_pagebuilder['settings']['google_map']) ? $gt3_theme_pagebuilder['settings']['google_map'] : "").'</textarea>
            </div>
        </div>
        ';
    }
    if (in_array($now_post_type, $GLOBALS["pbconfig"]['pb_modules_enabled_for'])) {
        echo "
<div class='pb-cont page-builder-container bbg'>
    <div class='padding-cont main_descr'>" . __("You can use this drag and drop page builder to create unlimited custom page layouts. It is too simple, just click any module below, adjust your own settings and preview the page. That's all.", "gt3_builder") . "</div>
    <div>
        <div class='hideable-content'>
            <div class='padding-cont'>
                <div class='available-modules-cont'>
                    " . get_html_all_available_pb_modules($modules) . "
                </div>
                <div class='clear'></div>
            </div>
            <div class='pb-list-active-modules'>
                <div class='padding-cont'>
                    <ul class='sortable-modules'>
                    ";

        if (isset($gt3_theme_pagebuilder['modules']) && is_array($gt3_theme_pagebuilder['modules'])) {
            foreach ($gt3_theme_pagebuilder['modules'] as $moduleid => $module) {
                if ($module['size'] == "block_1_4") {
                    $size_caption = "1/4";
                }
                if ($module['size'] == "block_1_3") {
                    $size_caption = "1/3";
                }
                if ($module['size'] == "block_1_2") {
                    $size_caption = "1/2";
                }
                if ($module['size'] == "block_2_3") {
                    $size_caption = "2/3";
                }
                if ($module['size'] == "block_3_4") {
                    $size_caption = "3/4";
                }
                if ($module['size'] == "block_1_1") {
                    $size_caption = "1/1";
                }
                echo get_pb_module($module['name'], $module['caption'], $moduleid, $gt3_theme_pagebuilder, $module['size'], $size_caption, $tinymce_activation_class);
            }
        }

        echo "
                    </ul>
                    <div class='clear'></div>
                </div>
            </div>
        </div>
    </div>
</div>
";
    }
#END BUILDER AREA


#POSTFORMATS. VISIBLE ONLY ON GT3 THEMES.
if (GT3THEME_INSTALLED == true && ($now_post_type == "post" || $now_post_type == "port")) {
    echo "
<div class='pb-cont page-settings-container'>
    <div class='pb10'>
        <div class='hideable-content'>
            <div class='post-formats-container'>
                <!-- Video post format -->
                <div id='video_sectionid_inner'>
                    <h2>Post format video URL:</h2>
                    <input type='text' class='medium textoption type1' name='pagebuilder[post-formats][videourl]' value='" . (isset($gt3_theme_pagebuilder['post-formats']['videourl']) ? $gt3_theme_pagebuilder['post-formats']['videourl'] : "") . "'>
                    <div class='example'>Examples:<br>Youtube - http://www.youtube.com/watch?v=6v2L2UGZJAM<br>Vimeo - http://vimeo.com/47989207</div>
                    <div class='video_height' style='margin-top:15px;'>
                        <div class='enter_option_row'>
                            <h2>Video height</h2>
                            <input type='text' class='medium textoption type1' name='pagebuilder[post-formats][video_height]' value='" . (isset($gt3_theme_pagebuilder['post-formats']['video_height']) ? $gt3_theme_pagebuilder['post-formats']['video_height'] : "") . "' style='width:70px;text-align:center;'>
                        </div>
                    </div>
                </div>
                <!-- Image post format -->
                <div id='portslides_sectionid_inner'>
                    <div class='portslides_sectionid_title'><h2>Slider Images</h2></div>
                    <div class='selected-images-for-pf'>
                        " . get_selected_pf_images_for_admin($gt3_theme_pagebuilder) . "
                    </div>
					<hr class='img_seperator'>
                    <div class='available-images-for-pf available_media'>
                        <div class='ajax_cont'>
                            " . get_media_html($media_for_this_post, "small") . "
                        </div>
                        <div class='img-item style_small add_image_to_sliders_available_media cboxElement'>
                            <div class='img-preview'>
                                <img alt='' src='" . PBIMGURL . "/add_image.png'>
                            </div>
                        </div><!-- .img-item -->
                    </div>
                </div>
            </div>
            <div class='clear'></div>
        </div>
    </div>
</div>
            ";

}

#GALLERY AREA
    if ($now_post_type == "gallery") {
        echo "
        <!-- FULLSCREEN SLIDER SETTINGS -->
                <div class='padding-cont  stand-s pt_" . $now_post_type . "'>
                    <div class='bg_or_slider_option slider_type active'>
                        <input type='hidden' name='settings_type' value='fullscreen' class='settings_type'>
                        <div class='hideable-area'>
                            <div class='padding-cont help text-shadow2'></div>
                            <div class='padding-cont' style='padding-bottom:11px;'>
                                <div class='selected_media'>
                                    <div class='append_block'>
                                         <ul class='sortable-img-items'>
                                           " . get_slider_items("fullscreen", (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['slides']) ? $gt3_theme_pagebuilder['sliders']['fullscreen']['slides'] : '')) . "
                                         </ul>
                                    </div>
                                    <div class='clear'></div>
                                </div>
                            </div>
                            <div style='' class='hr_double style2'></div>
                            <div class='padding-cont' style='padding-top:12px;'>
								<div class='gt3settings_box no-margin'>									
									<div class='gt3settings_box_title'><h2>" . __('Select media', 'gt3_builder') . "</h2></div>
									<div class='gt3settings_box_content'>
										<div class='available_media'>
											<div class='ajax_cont'>
												" . get_media_html($media_for_this_post, "small") . "
											</div>
											<div class='img-item style_small add_image_to_sliders_available_media cboxElement'>
												<div class='img-preview'>
													<img alt='' src='" . PBIMGURL . "/add_image.png'>
												</div>
											</div><!-- .img-item -->
											<div class='img-item style_small add_video_slider'>
												<div class='img-preview'>
													<img alt='' class='previmg' data-full-url='" . PBIMGURL . "/video_item.png' src='" . PBIMGURL . "/add_video.png'>
												</div>
											</div><!-- .img-item -->
											<div class='clear'></div>
										</div>
									</div>
								</div>
                            </div>
                            <div class='hr_double style2'></div>
                            <div class='padding-cont'>
                                <div class='radio_block'>
                                    <div style='width: 190px;' class='caption'><h2 style='color:#A1A1A1;' class='text-shadow2'>" . __('show thumbnails', 'gt3_builder') . "</h2></div>
                                    <div class='radio_selector'>
                                        " . toggle_radio_on_off('pagebuilder[sliders][fullscreen][thumbnails]', (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['thumbnails']) ? $gt3_theme_pagebuilder['sliders']['fullscreen']['thumbnails'] : ''), 'on') . "
                                    </div>
                                    <div class='help_here help text-shadow2'>
                                        &nbsp;
                                    </div>
                                    <div class='clear'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END SETTINGS -->";
    }

#TESTIMONIALS AREA
    if ($now_post_type == "testimonials") {
        echo "
            <!-- TESTIMONIALS SETTINGS -->
            <div class='padding-cont pt_" . $now_post_type . "'>

            <div class='testimonials_cont'>
                <div class='append_items'>
                    <label for='testimonials_author' class='label_type1'>" . __('Author:', 'gt3_builder') . "</label> <input type='text' value='" . (isset($gt3_theme_pagebuilder['page_settings']['testimonials']['testimonials_author']) ? $gt3_theme_pagebuilder['page_settings']['testimonials']['testimonials_author'] : '') . "' id='testimonials_author' name='pagebuilder[page_settings][testimonials][testimonials_author]' class='testimonials_author itt_type1'><br>
                    <label for='testimonials_position' class='label_type1'>" . __('Company:', 'gt3_builder') . "</label> <input type='text' value='" . (isset($gt3_theme_pagebuilder['page_settings']['testimonials']['company']) ? $gt3_theme_pagebuilder['page_settings']['testimonials']['company'] : '') . "' id='testimonials_company' name='pagebuilder[page_settings][testimonials][company]' class='testimonials_company itt_type1'>
                </div>
            </div>

            </div>
            <!-- END SETTINGS -->";
    }

#PARTNERS AREA
    if ($now_post_type == "partners") {
        echo "
            <!-- PARTNERS SETTINGS -->
            <div class='padding-cont pt_" . $now_post_type . "' style='margin-top:20px;'>

            <div class='partners_cont gt3settings_box'>
				<div class='gt3settings_box_title'><h2>Advanced options</h2></div>
				<div class='gt3settings_box_content'>
					<div class='append_items'>
						<label for='partners_link' class='label_type1'>" . __('External link:', 'gt3_builder') . "</label> <input type='text' value='" . (isset($gt3_theme_pagebuilder['page_settings']['partners']['partners_link']) ? $gt3_theme_pagebuilder['page_settings']['partners']['partners_link'] : '') . "' id='partners_link' name='pagebuilder[page_settings][partners][partners_link]' class='partners_link itt_type1'>
					</div>
				</div>
            </div>

            </div>
            <!-- END SETTINGS -->";
    }

#STRIP AREA
    if ($now_post_type == "page" && get_page_template_slug() == "page-strip.php") {
        echo "
            <!-- STRIP SETTINGS -->
            <div class='padding-cont pt_" . $now_post_type . "' style='margin-top:20px;'>

            <div class='strip_cont gt3settings_box'>
				<div class='gt3settings_box_title'><h2>Strip page options</h2></div>
				<div class='gt3settings_box_content'>
					<ul class='append_items'>";

    if (isset($gt3_theme_pagebuilder['strips']) && is_array($gt3_theme_pagebuilder['strips'])) {
        foreach ($gt3_theme_pagebuilder['strips'] as $stripid => $stripdata) {
            echo "
            <li>
                <div class='sort_drug strip_head'>".(!empty($stripdata['striptitle1']) ? $stripdata['striptitle1'] : "Strip item")."</div>
                <input type='text' placeholder='Title 1' name='pagebuilder[strips][$stripid][striptitle1]' value='".$stripdata['striptitle1']."'>
                <input type='text' placeholder='Title 2' name='pagebuilder[strips][$stripid][striptitle2]' value='".$stripdata['striptitle2']."'>
                <input type='text' placeholder='Title 3' name='pagebuilder[strips][$stripid][striptitle3]' value='".$stripdata['striptitle3']."'>
                <input type='text' placeholder='Title 4' name='pagebuilder[strips][$stripid][striptitle4]' value='".$stripdata['striptitle4']."'>
                <input type='text' placeholder='Title 5' name='pagebuilder[strips][$stripid][striptitle5]' value='".$stripdata['striptitle5']."'>
                <input type='text' placeholder='Link' name='pagebuilder[strips][$stripid][link]' value='".$stripdata['link']."'>
                <input type='text' placeholder='Image' name='pagebuilder[strips][$stripid][image]' value='".$stripdata['image']."' class='gt3UploadImg'>
                <span class='remove_strip'>[x]</span>
            </li>";
        }
    }

        echo "
					</ul>
					<input class='button button-primary button-large add-new-strip' type='button' value='Add New Strip'>
					<style>
                        .edit-form-section, .page-builder-container {
                            display:none;
                        }
                    </style>
				</div>
            </div>

            </div>
            <!-- END SETTINGS -->";
    }

#PORTFOLIO AREA
    if ($now_post_type == "port") {
        echo "
            <!-- PARTNERS SETTINGS -->
            <div class='padding-cont pt_" . $now_post_type . "'>

            <div class='partners_cont gt3settings_box'>
				<div class='gt3settings_box_title'><h2>Advanced options</h2></div>
				<div class='gt3settings_box_content'>
					<div class='append_items'>
						<label for='work_link' class='label_type1'>" . __('Link to the work:', 'gt3_builder') . "</label><br><input type='text' value='" . (isset($gt3_theme_pagebuilder['page_settings']['portfolio']['work_link']) ? $gt3_theme_pagebuilder['page_settings']['portfolio']['work_link'] : '') . "' id='work_link' name='pagebuilder[page_settings][portfolio][work_link]' class='work_link itt_type1'>
					</div>
					<hr>
					<div class='port_skills_cont'>
					    <div class='item-with-settings'>
					        <div class='all_available_port_skills_icons edit_popup' style='background-color: #ffffff;'>";
foreach ($GLOBALS["pbconfig"]['all_available_font_icons'] as $av__ficon) {
    echo "<i class='".$av__ficon."'></i>";
}
        echo "
					        </div>
					    </div>
						<ul class='all_added_skills sortable_icons_list'>";
						if (isset($gt3_theme_pagebuilder['page_settings']['portfolio']['skills']) && is_array($gt3_theme_pagebuilder['page_settings']['portfolio']['skills'])) {
							foreach ($gt3_theme_pagebuilder['page_settings']['portfolio']['skills'] as $key => $value) {
								echo "
									<li class='stand_iconsweet ui-state-default'> <input type='text' class='itt_type1 ww10 select_icon_and_insert_here' name='pagebuilder[page_settings][portfolio][skills][{$key}][icon]' placeholder='Icon' value='{$value["icon"]}'> <input type='text' class='itt_type1 ww43' name='pagebuilder[page_settings][portfolio][skills][{$key}][name]' placeholder='Field name' value='{$value["name"]}'> <input type='text' class='itt_type1 ww43' name='pagebuilder[page_settings][portfolio][skills][{$key}][value]' placeholder='Field value' value='{$value["value"]}'> <span class='remove_skill'><i class='stand_icon icon-remove'></i></span></li>
								";
							}
						}
					echo "
						</ul>
						<div class='heading line_option visual_style1 small_type hovered clickable add_new_port_skills'>
							<div class='option_title text-shadow1'>" . __('Add Custom Field', 'gt3_builder') . "</div>
							<div class='some-element cross'></div>
							<div class='pre_toggler'></div>
						</div>
					</div>
				</div>
			</div>

            </div>
            <!-- END SETTINGS -->";
    }

#TEAM AREA
    if ($now_post_type == "team") {
        echo "
            <!-- TEAM SETTINGS -->
            <div class='padding-cont pt_" . $now_post_type . "'>

            <div class='partners_cont gt3settings_box'>
				<div class='gt3settings_box_title'><h2>Advanced options</h2></div>
				<div class='gt3settings_box_content'>
					<div class='append_items'>
						<label for='position_link' class='label_type1'>Position:</label> <input type='text' value='" . (isset($gt3_theme_pagebuilder['page_settings']['team']['position']) ? $gt3_theme_pagebuilder['page_settings']['team']['position'] : '') . "' id='position_link' name='pagebuilder[page_settings][team][position]' class='position_link itt_type1'>
						<div>
							<div class='hleft' style='vertical-align:top;'>" . __('Social icons', 'gt3_builder') . "</div>
							<div class='hright'>
								<div class='added_icons sortable_icons_list'>";
	
								if (isset($gt3_theme_pagebuilder['page_settings']['icons']) && is_array($gt3_theme_pagebuilder['page_settings']['icons'])) {
									foreach ($gt3_theme_pagebuilder['page_settings']['icons'] as $key => $value) {
										echo "
                                        <div class='stand_iconsweet ui-state-default'>
                                            <span class='stand_icon-container'><i class='stand_icon " . $value['data-icon-code'] . "'></i></span>
                                            <input type='hidden' name='pagebuilder[page_settings][icons][" . $key . "][data-icon-code]' value='" . $value['data-icon-code'] . "'>
                                            <input class='icon_name' type='text' name='pagebuilder[page_settings][icons][" . $key . "][name]' value='" . $value['name'] . "' placeholder='" . __('Give Some Name', 'gt3_builder') . "'>
                                            <input class='icon_link' type='text' name='pagebuilder[page_settings][icons][" . $key . "][link]' value='" . $value['link'] . "' placeholder='" . __('Give Some Link', 'gt3_builder') . "'>
                                            <input class='cpicker' type='text' name='pagebuilder[page_settings][icons][" . $key . "][fcolor]' value='" . $value['fcolor'] . "' placeholder='" . __('Foreground Color', 'gt3_builder') . "'>
                                            <input type='text' value='' class='cpicker_preview' disabled='disabled' style='background-color:#" . $value['fcolor'] . "'>
                                            <span class='remove_me'><i class='stand_icon icon-remove'></i></span>
                                        </div>";

                                    }
								}
	
			echo "
								</div>
								<div class='social_list_for_select'>";
	
			foreach ($GLOBALS["pbconfig"]['all_available_font_icons'] as $icon) {
				echo "<div class='stand_social'><i data-icon-code='" . $icon . "' class='stand_icon " . $icon . "'></i></div>";
			}
	
			echo "
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>

            </div>
            <!-- END SETTINGS -->";
    }

#JS FOR AJAX UPLOADER
    ?>
    <script type="text/javascript">

        function reactivate_ajax_image_upload() {
            var admin_ajax = '<?php echo admin_url("admin-ajax.php"); ?>';
            $('.btn_upload_image').each(function () {
                var clickedObject = jQuery(this);
                var clickedID = jQuery(this).attr('id');
                new AjaxUpload(clickedID, {
                    action: '<?php echo admin_url("admin-ajax.php"); ?>',
                    name: clickedID, // File upload name
                    data: { // Additional data to send
                        action: 'mix_ajax_post_action',
                        type: 'upload',
                        data: clickedID },
                    autoSubmit: true, // Submit file after selection
                    responseType: false,
                    onChange: function (file, extension) {
                    },
                    onSubmit: function (file, extension) {
                        clickedObject.text('Uploading'); // change button text, when user selects file
                        this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
                        interval = window.setInterval(function () {
                            var text = clickedObject.text();
                            if (text.length < 13) {
                                clickedObject.text(text + '.');
                            }
                            else {
                                clickedObject.text('Uploading');
                            }
                        }, 200);
                    },
                    onComplete: function (file, response) {

                        window.clearInterval(interval);
                        clickedObject.text('Upload Image');
                        this.enable(); // enable upload button

                        // If there was an error
                        if (response.search('Upload Error') > -1) {
                            var buildReturn = '<span class="upload-error">' + response + '</span>';
                            jQuery(".upload-error").remove();
                            clickedObject.parent().after(buildReturn);

                        }
                        else {
                            var buildReturn = '<a href="' + response + '" class="uploaded-image" target="_blank"><img class="hide option-image" id="image_' + clickedID + '" src="' + response + '" alt="" /></a>';

                            jQuery(".upload-error").remove();
                            jQuery("#image_" + clickedID).remove();
                            clickedObject.parent().next().after(buildReturn);
                            jQuery('img#image_' + clickedID).fadeIn();
                            clickedObject.next('span').fadeIn();
                            clickedObject.parent().prev('input').val(response);
                        }
                    }
                });
            });
        }


        $(document).ready(function () {
            reactivate_ajax_image_upload();
        });
    </script>
    <?php #END JS FOR AJAX UPLOADER ?>

<?php
#DEVELOPER CONSOLE
    if (gt3pb_get_option("dev_console") == "true") {
        echo "<pre style='color:#000000;'>";
        print_r($gt3_theme_pagebuilder);
        echo "</pre>";
    }

}

#START SAVE MODULE
function save_postdata($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    #CHECK PERMISSIONS
    if (!current_user_can('edit_post', $post_id))
        return;

    #START SAVING
    if (!isset($_POST['pagebuilder'])) {
        $pbsavedata = array();
    } else {
        $pbsavedata = $_POST['pagebuilder'];
        update_theme_pagebuilder($post_id, "pagebuilder", $pbsavedata);
    }
}

?>