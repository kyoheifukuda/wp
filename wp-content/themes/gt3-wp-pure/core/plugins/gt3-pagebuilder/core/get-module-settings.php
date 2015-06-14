<?php

function get_module_settings_part_heading($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now)
{
    if (!isset($gt3_theme_pagebuilder['modules'][$moduleid]['heading_text'])) {
        $gt3_theme_pagebuilder['modules'][$moduleid]['heading_text'] = '';
    }
    if (!isset($gt3_theme_pagebuilder['modules'][$moduleid]['heading_alignment'])) {
        $gt3_theme_pagebuilder['modules'][$moduleid]['heading_alignment'] = '';
    }

    return "
    <div class='padding-cont'>
        <div class='heading'>
            <h4>" . __('Heading', 'gt3_builder') . "</h4>
            <input type='text' class='textoption type1' value='{$gt3_theme_pagebuilder['modules'][$moduleid]['heading_text']}' name='pagebuilder[modules][$moduleid][heading_text]'>
        </div>
        <div class='alignment'>
            <h4>" . __('Alignment', 'gt3_builder') . "</h4>
            <select class='newselect' name='pagebuilder[modules][$moduleid][heading_alignment]'>
                " . get_select_options($GLOBALS["pbconfig"]['all_available_headers_alignment'], $gt3_theme_pagebuilder['modules'][$moduleid]['heading_alignment']) . "
            </select>
        </div>
        <div class='heading_size'>
            <h4>" . __('Size', 'gt3_builder') . "</h4>
            <select class='newselect' name='pagebuilder[modules][$moduleid][heading_size]'>
                " . get_select_options($GLOBALS["pbconfig"]['all_available_headers_for_module'], $pb_module_size_now) . "
            </select>
        </div>
        <div class='heading_color'>
            <h4>" . __('Color', 'gt3_builder') . "</h4>
            " . colorpicker_block("pagebuilder[modules][$moduleid][heading_color]", (isset($gt3_theme_pagebuilder['modules'][$moduleid]['heading_color']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['heading_color'] : '')) . "
        </div>
        <div class='clear'></div>
    </div>
    <div class='hr_double'></div>
    ";
}

function get_module_settings_part_textarea($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $temp, $headingtext, $settingname, $tinymce_activation_class = "")
{
    return "
        <div class='enter_option_row tinyCont'>
            <h5>{$headingtext}</h5>
                <textarea name='pagebuilder[modules][$moduleid][$settingname]' class='enter_text1' id='" . $tinymce_activation_class . "'>" . (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) ? $gt3_theme_pagebuilder['modules'][$moduleid][$settingname] : '') . "</textarea>
        </div>
    ";
}

function get_module_settings_part_textarea_without_tiny($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $temp, $headingtext, $settingname, $tinymce_activation_class = "")
{
    return "
        <div class='enter_option_row'>
            <h5>{$headingtext}</h5>
                <textarea name='pagebuilder[modules][$moduleid][$settingname]' class='enter_text1' id='" . $tinymce_activation_class . "'>" . (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) ? $gt3_theme_pagebuilder['modules'][$moduleid][$settingname] : '') . "</textarea>
        </div>
    ";
}

function get_empty_textarea($headingtext, $classes, $width = "100%", $textalign = "left", $default_value = "")
{
    return "
        <div class='enter_option_row' style='width:{$width} !important;'>
            <h5>{$headingtext}</h5>
            <textarea name='' class='enter_text1 " . $classes . "' style='text-align: {$textalign} !important;'></textarea>
        </div>
    ";
}

function get_module_settings_part_select($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $temp, $headingtext, $settingname, $width, $available_options_in_select)
{
    return "
        <div class='enter_option_row'>
            <h5>$headingtext</h5>
            <select class='newselect' name='pagebuilder[modules][$moduleid][$settingname]' style='width:{$width} !important;'>
                " . get_select_options($available_options_in_select, (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) ? $gt3_theme_pagebuilder['modules'][$moduleid][$settingname] : '')) . "
            </select>
        </div>
    ";
}

function get_module_settings_part_select_with_caption($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $temp, $headingtext, $settingname, $width, $available_options_in_select)
{
    return "
        <div class='enter_option_row'>
            <h5>$headingtext</h5>
            <select class='newselect' name='pagebuilder[modules][$moduleid][$settingname]' style='width:{$width} !important;'>
                " . get_select_options_with_caption($available_options_in_select, (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) ? $gt3_theme_pagebuilder['modules'][$moduleid][$settingname] : '')) . "
            </select>
        </div>
    ";
}

function get_module_settings_part_upload_file($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $temp, $headingtext, $settingname, $width)
{
    return "
        <div class='enter_option_row upload_file_cont'>
            <h5>$headingtext</h5>
            <div class='input'>
                <input type='text' value='" . (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) ? $gt3_theme_pagebuilder['modules'][$moduleid][$settingname] : '') . "' name='pagebuilder[modules][$moduleid][$settingname]' class='textoption type1' style='width:609px;float:left;'>
                <div class='up_btns' style='float:left;'>
                    <span id='uploaded_file_{$settingname}{$moduleid}' class='button btn_upload_image style2'>" . __('Upload Image', 'gt3_builder') . "</span>
                </div>
                <div class='clear'></div>
            </div>
        </div>
        <script type='text/javascript'>
        jQuery(document).ready(function ($) {
            reactivate_ajax_image_upload();
        });
        </script>
    ";
}

function get_empty_select($headingtext, $classes, $available_options_in_select, $width = "100px", $default_value = "")
{
    return "
        <div class='enter_option_row'>
            <h5>$headingtext</h5>
            <select class='newselect " . $classes . "' name='' style='width:{$width} !important;'>
                " . get_select_options_with_caption($available_options_in_select, '') . "
            </select>
        </div>
    ";
}

function get_module_settings_part_input($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $temp, $headingtext, $settingname, $width, $textalign, $defaultvalue = '')
{
    return "
        <div class='enter_option_row'>
            <h5>$headingtext</h5>
            <input style='width:{$width} !important; text-align: {$textalign} !important;' type='text' value='" . ((isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) && strlen($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) > 0) ? $gt3_theme_pagebuilder['modules'][$moduleid][$settingname] : $defaultvalue) . "' name='pagebuilder[modules][$moduleid][$settingname]' class='enter_text1'>
        </div>
    ";
}


function get_module_settings_part_cpts($gt3_theme_pagebuilder, $moduleid, $headingtext, $settingname, $cpt)
{
    $compile = "
    <div class='enter_option_row'>
        <h5>$headingtext</h5>";

    $wp_query_cpt_posts = new WP_Query();
    $args = array(
        'post_type' => $cpt,
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    if (count($wp_query_cpt_posts->query($args)) > 0) {
        $wp_query_cpt_posts->query($args);
        while ($wp_query_cpt_posts->have_posts()) : $wp_query_cpt_posts->the_post();

            if (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname][get_the_ID()]) && $gt3_theme_pagebuilder['modules'][$moduleid][$settingname][get_the_ID()] == "on") {
                $selectedstate = "checked";
            } else {
                $selectedstate = "";
            }

            $compile .= "<input id='post" . get_the_ID() . "' " . $selectedstate . " type='checkbox' name='pagebuilder[modules][$moduleid][$settingname][" . get_the_ID() . "]'> <label for='post" . get_the_ID() . "'>" . get_the_title() . "</label>";

        endwhile;
    } else {
        switch($cpt) {
            case "partners":
                $compile .= 'No partner logo available. Please add new partner logo in the partners section.';
                break;
            case "testimonials":
                $compile .= 'No testimonial available. Please add new testimonial in the testimonials section.';
                break;
            case "team":
                $compile .= 'No team member available. Please add new member in the team section.';
                break;
        }
    }

    $compile .= "
    </div>
    ";

    return $compile;
}


function get_module_settings_part_categories($gt3_theme_pagebuilder, $moduleid, $headingtext, $settingname, $cpt)
{
    $rnd = mt_rand(1, 9999);
    $checked_isset = "checked";
    $cathided_state = "cat_hided";
    if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['show_all_categories']) && $gt3_theme_pagebuilder['modules'][$moduleid]['show_all_categories'] == "on") {
        $cathided_state = "cat_hided";
    }
    $compile = "
    <div class='enter_option_row'>
        <h5>$headingtext</h5>";

    if ($cpt == "post") {
        $args = array(
            'type' => $cpt
        );
        $categories = get_categories($args);
        if (count($categories) > 0) {

            foreach ($categories as $cat) {
                if (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname][$cat->cat_ID]) && $gt3_theme_pagebuilder['modules'][$moduleid][$settingname][$cat->cat_ID] == "on") {
                    $checked_isset = "";
                    $cathided_state = "";
                    continue;
                }
            }

            $compile .= "<input class='all_part' " . $checked_isset . " " . ((isset($gt3_theme_pagebuilder['modules'][$moduleid]['show_all_categories']) && $gt3_theme_pagebuilder['modules'][$moduleid]['show_all_categories'] == "on") ? "checked" : "") . " type='checkbox' name='pagebuilder[modules][$moduleid][show_all_categories]'> <span>" . __("All", "gt3_builder") . "</span>";

            foreach ($categories as $cat) {

                if (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname][$cat->cat_ID]) && $gt3_theme_pagebuilder['modules'][$moduleid][$settingname][$cat->cat_ID] == "on") {
                    $selectedstate = "checked";
                } else {
                    $selectedstate = "";
                }

                $compile .= "<input class='category_part " . $cathided_state . "' " . $selectedstate . " type='checkbox' name='pagebuilder[modules][$moduleid][$settingname][" . $cat->cat_ID . "]'> <span class='" . $cathided_state . "'>" . $cat->name . "</span>";

            }
        } else {
            $compile .= __("No category available. Please add new category in the posts section.", "gt3_builder");
        }
    } elseif ($cpt == "port") {
        $args = array('taxonomy' => 'Category');
        $terms = get_terms('portcat', $args);
        if (is_array($terms) && count($terms) > 0) {

            foreach ($terms as $cat) {
                if (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname][$cat->term_id]) && $gt3_theme_pagebuilder['modules'][$moduleid][$settingname][$cat->term_id] == "on") {
                    $checked_isset = "";
                    $cathided_state = "";
                    continue;
                }
            }

            $compile .= "<input class='all_part' " . $checked_isset . " " . ((isset($gt3_theme_pagebuilder['modules'][$moduleid]['show_all_categories']) && $gt3_theme_pagebuilder['modules'][$moduleid]['show_all_categories'] == "on") ? "checked" : "") . " type='checkbox' name='pagebuilder[modules][$moduleid][show_all_categories]'> <span>" . __("All", "gt3_builder") . "</span>";

            foreach ($terms as $cat) {
                if (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname][$cat->term_id]) && $gt3_theme_pagebuilder['modules'][$moduleid][$settingname][$cat->term_id] == "on") {
                    $selectedstate = "checked";
                } else {
                    $selectedstate = "";
                }

                $compile .= "<input class='category_part " . $cathided_state . "' " . $selectedstate . " type='checkbox' name='pagebuilder[modules][$moduleid][$settingname][" . $cat->term_id . "]'> <span class='" . $cathided_state . "'>" . $cat->name . "</span>";
            }
        } else {
            $compile .= __("No category available. Please add new category in the portfolio section.", "gt3_builder");
        }
    }

    $compile .= "
    </div>
    ";

    return $compile;
}


function get_shortcode_settings_part_icons()
{
    $compile = "
        <div class='enter_option_row all_available_font_icons'>
            <h5>" . __('Select icon', 'gt3_builder') . "</h5>
            <ul>";
    foreach ($GLOBALS["pbconfig"]['all_available_font_icons'] as $icon) {
        $compile .= "<li><i data-icon-code='" . $icon . "' class='stand_icon " . $icon . "'></i></li>";
    }

    $compile .= "
            </ul>
            <div class='clear'></div>
        </div>
    ";

    return $compile;
}

function get_module_settings_part_icons($gt3_theme_pagebuilder, $moduleid, $headingtext, $settingname)
{
    $compile = "
        <div class='enter_option_row all_available_font_icons'>
            <h5>" . $headingtext . "</h5>
            <ul>";
    foreach ($GLOBALS["pbconfig"]['all_available_font_icons'] as $icon) {
        $compile .= "<li><i data-icon-code='" . $icon . "' class='stand_icon " . $icon . "'></i></li>";
    }

    $compile .= "
            </ul>
            <div class='clear'></div>
            <input type='text' value='" . (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) ? $gt3_theme_pagebuilder['modules'][$moduleid][$settingname] : '') . "' name='pagebuilder[modules][$moduleid][$settingname]' class='enter_text1 icon_type'>
        </div>
    ";

    return $compile;
}

function get_module_settings_part_any_icon($gt3_theme_pagebuilder, $moduleid, $headingtext, $settingname)
{
    $compile = "
        <div class='enter_option_row select_only_one_fa_icon'>
            <h5>" . $headingtext . "</h5>
            <input type='hidden' class='any_icons_settingname' name='pagebuilder[modules][$moduleid][$settingname]' value='" . (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) ? $gt3_theme_pagebuilder['modules'][$moduleid][$settingname] : '') . "'>
            ";

    $compile .= "<ul class='all_available_font_icons_for_any_icons'>";

    foreach ($GLOBALS["pbconfig"]['all_available_font_icons'] as $icon) {
        $compile .= "<li class='".((isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) && $gt3_theme_pagebuilder['modules'][$moduleid][$settingname] == $icon) ? "active" : "")."'><i data-icon-code='" . $icon . "' class='stand_icon " . $icon . "'></i></li>";
    }

    $compile .= "
            </ul>
            <div class='clear'></div>
        </div>
    ";

    return $compile;
}

function get_module_settings_part_any_icons($gt3_theme_pagebuilder, $moduleid, $headingtext, $settingname)
{
    $compile = "
        <div class='enter_option_row all_available_font_icons_for_any_icons_cont'>
            <h5>" . $headingtext . "</h5>
            <input type='hidden' class='any_icons_settingname' name='any_icons_settingname' value='" . $settingname . "'>
            <input type='hidden' class='any_icons_moduleid' name='any_icons_moduleid' value='" . $moduleid . "'>
            <div class='already_added_icons sortable_icons_list'>";

    if (isset($gt3_theme_pagebuilder['modules'][$moduleid][$settingname]) && is_array($gt3_theme_pagebuilder['modules'][$moduleid][$settingname])) {
        foreach ($gt3_theme_pagebuilder['modules'][$moduleid][$settingname] as $key => $value) {
            $compile .= "
            <div class='stand_iconsweet ui-state-default'>
                <span class='stand_icon-container'><i class='stand_icon " . $value['data-icon-code'] . "'></i></span>
                <input type='hidden' name='pagebuilder[modules][" . $moduleid . "][" . $settingname . "][" . $key . "][data-icon-code]' value='" . $value['data-icon-code'] . "'><input class='icon_name textoption type1' type='text' name='pagebuilder[modules][" . $moduleid . "][" . $settingname . "][" . $key . "][name]' value='" . $value['name'] . "' placeholder='" . __('Give some name', 'gt3_builder') . "'>
                <input class='icon_link textoption type1' type='text' name='pagebuilder[modules][" . $moduleid . "][" . $settingname . "][" . $key . "][link]' value='" . $value['link'] . "' placeholder='" . __('Give some link', 'gt3_builder') . "'>
                <input class='cpicker textoption type1' type='text' name='pagebuilder[modules][" . $moduleid . "][" . $settingname . "][" . $key . "][fcolor]' value='" . $value['fcolor'] . "' placeholder='" . __('Foreground color', 'gt3_builder') . "'>
                <input type='text' value='' class='cpicker_preview textoption type1' disabled='disabled' style='background-color:#" . $value['fcolor'] . "'>
                <input class='cpicker textoption type1' type='text' name='pagebuilder[modules][" . $moduleid . "][" . $settingname . "][" . $key . "][bcolor]' value='" . $value['bcolor'] . "' placeholder='" . __('Background color', 'gt3_builder') . "'>
                <input type='text' value='' class='cpicker_preview textoption type1' disabled='disabled' style='background-color:#" . $value['bcolor'] . "'>
                <span class='remove_me'><i class='remove_any_icons icon-remove'></i></span>
            </div>";
        }
    }

    $compile .= "</div><ul class='all_available_font_icons_for_any_icons'>";

    foreach ($GLOBALS["pbconfig"]['all_available_font_icons'] as $icon) {
        $compile .= "<li><i data-icon-code='" . $icon . "' class='stand_icon " . $icon . "'></i></li>";
    }

    $compile .= "
            </ul>
            <div class='clear'></div>
        </div>
    ";

    return $compile;
}

function get_module_settings_part_padding_bottom($gt3_theme_pagebuilder, $moduleid)
{
    $compile = "
        <div class='enter_option_row'>
            <h5>" . __('You can use the custom CSS class for this module.', 'gt3_builder') . "</h5>
            <input type='text' value='" . (isset($gt3_theme_pagebuilder['modules'][$moduleid]['custom_class']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['custom_class'] : '') . "' name='pagebuilder[modules][$moduleid][custom_class]' class='enter_text1' style='width:115px !important; text-align:center;'>
        </div>
        <div class='enter_option_row margin-bottom-block'>
            <h5>" . __('Please set the custom margin-bottom of the module.', 'gt3_builder') . "</h5>
            <input type='text' value='" . (isset($gt3_theme_pagebuilder['modules'][$moduleid]['padding_bottom']) ? $gt3_theme_pagebuilder['modules'][$moduleid]['padding_bottom'] : $GLOBALS["pbconfig"]['default_padding_after_module']) . "' name='pagebuilder[modules][$moduleid][padding_bottom]' class='enter_text1' style='width:115px !important; text-align:center;'>
        </div>
    ";

    return $compile;
}

function get_empty_input($headingtext, $classes, $width = "200px", $textalign = "center", $default_value = "")
{
    return "
        <div class='enter_option_row'>
            <h5>$headingtext</h5>
            <input style='width:{$width} !important; text-align: {$textalign} !important;' type='text' value='" . $default_value . "' name='' class='enter_text1 " . $classes . "'>
        </div>
    ";
}

function get_module_settings_part_done_btn()
{
    return "
        <div class='padding-cont done-block' style='padding-top:0;'>
            <input type='button' name='ignore_this_button' class='done-btn green-btn' value='" . __('Done', 'gt3_builder') . "'>
            <div class='clear'></div>
        </div>
    ";
}

function get_module_settings_part_add_list_ability($gt3_theme_pagebuilder, $moduleid, $pb_module_size_now, $temp, $caption)
{
    if (!isset($compile)) {
        $compile = '';
    }
    $compile .= "
        <div class='rows_must_be_here'>
            <input type='hidden' value='{$moduleid}' class='moduleid' name='moduleid'>
            <div class='heading line_option visual_style1 small_type hovered clickable add_new_row_section'>
                <div class='option_title text-shadow1'>{$caption}</div>
                <div class='some-element cross'></div>
                <div class='pre_toggler'></div>
            </div>
            <div class='clear'></div>
            <ul class='sections row-list'>";
    if (isset($gt3_theme_pagebuilder['modules'][$moduleid]['module_items']) && is_array($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'])) {
        foreach ($gt3_theme_pagebuilder['modules'][$moduleid]['module_items'] as $itemid => $item) {
            $compile .= "
                <li class='section'>
                    <div class='heading line_option visual_style1 big_type'>
                        <div class='option_title text-shadow1'>&nbsp;</div>
                        <div class='some-element clickable edit hovered'></div>
                        <div class='pre_toggler'></div>
                        <div class='some-element movable move hovered'></div>
                        <div class='pre_toggler'></div>
                        <div class='some-element clickable delete hovered'></div>
                        <div class='pre_toggler'></div>
                    </div>
                    <div class='clear'></div>
                    <div class='hide_area'>
                        <div class='some-padding'>
                            <textarea class='expanded_text1 type2 mt' name='pagebuilder[modules][$moduleid][module_items][$itemid][text]'>{$item['text']}</textarea>
                        </div>
                    </div>
                </li>
             ";
        }
    }
    $compile .= "
            </ul>
            <div class='clear'></div>
        </div>
    ";
    return $compile;
}

?>