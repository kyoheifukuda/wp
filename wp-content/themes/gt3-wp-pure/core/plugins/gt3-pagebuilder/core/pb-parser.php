<?php

function get_pb_parser($modules)
{
    global $lineWidth; $compile = "";
    if (!is_array($modules)) {$modules=array();}
    $allModulesCount = count($modules);
    $normalModulesCount = 0;
    $allModulesICounter = 0;
    $normalModulesICounter = 0;

    #Count normal modules
    foreach ($modules as $module_key => $module) {
        if ($module['name']!=="bg_start" && $module['name']!=="bg_end") {
            $normalModulesCount++;
        }
    }

    foreach ($modules as $module_key => $module) {
        $allModulesICounter++;
        if ($module['name']=="bg_start" || $module['name']=="bg_end") {
            if ($module['name']=="bg_start") {

                $GLOBALS['showOnlyOneTimeJS']['fw_block'] = "
                <script>
                    function fw_block() {
                        if (jQuery('div').hasClass('right-sidebar') || jQuery('div').hasClass('left-sidebar')) {} else {
                            var fw_block = jQuery('.fw_block');
                            var fw_block_parent = fw_block.parent().width();
                            var fw_site_width = jQuery(window).width();
                            var fw_contentarea_site_width_diff = fw_site_width - fw_block_parent;

                            fw_block.css('margin-left', '-'+fw_contentarea_site_width_diff/2+'px').css('width', fw_site_width+'px').children().css('padding-left', fw_contentarea_site_width_diff/2+'px').css('padding-right', fw_contentarea_site_width_diff/2+'px');
                        jQuery('.module_google_map .fw_wrapinner, .module_wall .fw_wrapinner').css('padding-left', '0px').css('padding-right', '0px');
                        }
                    }
                    jQuery(document).ready(function() {
                        jQuery('.fw_block').wrapInner('<div class=\"fw_wrapinner\"></div>');
                        fw_block();
                    });
                    jQuery(window).resize(function(){
                        fw_block();
                    });
                </script>
                ";

                $compile .= '<div class="fw_block bg_start'.(isset($module['custom_class']) && strlen($module['custom_class'])>0 ? " ".$module['custom_class'] : '').'" data-option="'.$module['properties'].'" data-background="" style="margin-bottom:'.$module['padding_bottom'].';padding-top:'.$module['padding_top'].'; background:'.((strlen($module['bg_color'])>0) ? "#".$module['bg_color'] : '').' '.((strlen($module['bg_image'])>0) ? "url('".$module['bg_image']."')" : '').' '.(($module['properties'] == "stretch") ? 'no-repeat' : 'repeat').' 0 0; '.(($module['properties'] == "stretch") ? 'background-size:cover;' : '').'">';
            }
            if ($module['name']=="bg_end") {
                if ($lineWidth<1) {
                    $compile .= '</div><!-- bg_end here -->';
                }
                $compile .= '</div><!-- module_line_trigger -->';
                $lineWidth = 1;
            }
        }
        else {
            $normalModulesICounter++;

            #GET SIZE
            if ($module['size'] == "block_1_4") {
                $outputClass = "span3";
            }
            if ($module['size'] == "block_1_3") {
                $outputClass = "span4";
            }
            if ($module['size'] == "block_1_2") {
                $outputClass = "span6";
            }
            if ($module['size'] == "block_2_3") {
                $outputClass = "span8";
            }
            if ($module['size'] == "block_3_4") {
                $outputClass = "span9";
            }
            if ($module['size'] == "block_1_1") {
                $outputClass = "span12";
            }

            if ($normalModulesICounter == 1 || $lineWidth >= 1) {
                $lineWidth = 0;
                $compile .= "<div class='row'>";
            }

            #open main module container
            $compile .= "<div style='padding-bottom:{$module['padding_bottom']};' class='{$outputClass} ".(($normalModulesICounter==1) ? "first-module" : "")." module_number_{$normalModulesICounter} module_cont ".(isset($module['custom_class']) ? $module['custom_class'] : '').((isset($module['heading_alignment']) && $module['heading_alignment'] == "center") ? 'center_title' : '')." module_{$module['name']}'>";

            ################################################################################################
            #######################################            #############################################
            ####################################### CASE START #############################################
            #######################################            #############################################
            ################################################################################################
            switch ($module['name']) {

                #NEW MODULE
                case "before_after":
                    $compile .= do_shortcode("[before_after
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    image_before='".$module["image_before"]."'
                    image_after='".$module["image_after"]."'
                    [/before_after]");
                    break;
                #BREAK

                #NEW MODULE
                case "title":
                    $compile .= do_shortcode("[title
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_alignment='".$module["heading_alignment"]."'
                    ]".$module["heading_text"]."[/title]");
                    break;
                #BREAK

                #NEW MODULE
                case "text_area":
                    $compile .= do_shortcode("[textarea
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    ]".$module["text"]."[/textarea]");
                    break;
                #BREAK

                #NEW MODULE
                case "html":
                    $compile .= do_shortcode("[textarea
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    module='html'
                    ]".$module["html"]."[/textarea]");
                    break;
                #BREAK

                #NEW MODULE
                case "javascript":
                    $compile .= do_shortcode("[textarea
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    module='html'
                    ]".$module["html"]."[/textarea]");
                    break;
                #BREAK

                #NEW MODULE
                case "layer_slider":
                    $compile .= do_shortcode("[textarea
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    module='html'
                    ]".$module["html"]."[/textarea]");
                    break;
                #BREAK

                #NEW MODULE
                case "content":
                    #heading
                    if (strlen($module['heading_color'])>0) {$custom_color = "color:#{$module['heading_color']};";} else {$custom_color = "";}
                    if (strlen($module['heading_text'])>0) {
                        $compile .= "<div class='bg_title'><".$module['heading_size']." style='".$custom_color."' class='headInModule'>{$module['heading_text']}</".$module['heading_size']."></div>";
                    }
                    $compile .= "<div class='module_content'>";
                    $compile .= str_replace("\r", "<br />", get_the_content(__('Read more!', 'gt3_builder')));

                    $compile .= "</div>";
                    global $contentAlreadyPrinted;
                    $contentAlreadyPrinted = true;
                    break;
                #BREAK

                #NEW MODULE
                case "google_map":
                    $compile .= do_shortcode("[textarea
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    module='map'
                    fullwidth_map='".$module["fullwidth_map"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    ]".$module["map"]."[/textarea]");
                    break;
                #BREAK

                #NEW MODULE
                case "social_share":
                    $compile .= do_shortcode("[social_share
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    ][/social_share]");
                    break;
                #BREAK

                #NEW MODULE
                case "sitemap":
                    $compile .= do_shortcode("[sitemap
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    show_posts='".$module["show_posts"]."'
                    show_site_feeds='".$module["show_site_feeds"]."'
                    ][/sitemap]");
                    break;
                #BREAK

                #NEW MODULE
                case "testimonial":

                    $compile_cpt_ids = array();

                    if (isset($module["cpt_ids"]) && (is_array($module["cpt_ids"]))) {
                        foreach ($module["cpt_ids"] as $testkey => $testvalue) {
                            array_push($compile_cpt_ids, $testkey);
                        }
                    }

                    $compile .= do_shortcode("[testimonials
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    testimonials_in_line='".$module["testimonials_in_line"]."'
                    cpt_ids='".implode(",", $compile_cpt_ids)."'
                    sorting_type='".$module["sorting_type"]."'
                    ][/testimonials]");
                    break;
                #BREAK

                #NEW MODULE
                case "video":
                    $compile .= do_shortcode("[video
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    w='100%'
                    h='".$module["video_height"]."'
                    video_url='".$module["video_url"]."'
                    ][/video]");
                    break;
                #BREAK

                #NEW MODULE
                case "divider":
                    $compile .= do_shortcode("[divider
                    divider_color='".$module["divider_color"]."'

                    ][/divider]");
                    break;
                #BREAK

                #NEW MODULE
                case "gallery":
                    $compile .= do_shortcode("[show_gallery
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    galleryid='".$module["selected_gallery"]."'
                    images_in_a_row='".$module["images_in_a_row"]."'
                    ][/show_gallery]");
                    break;
                #BREAK

                #NEW MODULE
                case "wall":
                    $compile .= do_shortcode("[show_wall
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    galleryid='".$module["selected_gallery"]."'
                    images_in_a_row='".$module["images_in_a_row"]."'
                    ][/show_wall]");
                    break;
                #BREAK

                #NEW MODULE
                case "tabs":
                    if (!isset($tabcompile)) {$tabcompile='';}
                    if (is_array($module["module_items"])) {
                        foreach ($module["module_items"] as $tabkey => $tab) {
                            $tabcompile .= "[tab title='".$tab['title']."' expanded_state='".$tab['expanded_state']."']".$tab['description']."[/tab]";
                        }
                    }
                    $compile .= do_shortcode("[tabs
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    tab_type='".$module["tab_type"]."'
                    divider_color='".(isset($module["divider_color"]) ? $module["divider_color"] : '')."'
                    divider_type='".(isset($module["divider_type"]) ? $module["divider_type"] : '')."'
                    ]".$tabcompile."[/tabs]");
                    unset($tabcompile);
                    break;
                #BREAK

                #NEW MODULE
                case "custom_list":
                    if (!isset($licompile)) {$licompile='';}
                    if (is_array($module["module_items"])) {
                        foreach ($module["module_items"] as $listkey => $list_item) {
                            $licompile .= "[li]".$list_item['text']."[/li]";
                        }
                    }
                    $compile .= do_shortcode("[list
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    type='".$module["list_type"]."'
                    ]".$licompile."[/list]");
                    unset($licompile);
                    break;
                #BREAK

                #NEW MODULE
                case "team":
                    $compile_cpt_ids = array();

                    if (isset($module["cpt_ids"]) && (is_array($module["cpt_ids"]))) {
                        foreach ($module["cpt_ids"] as $testkey => $testvalue) {
                            array_push($compile_cpt_ids, $testkey);
                        }
                    }

                    $compile .= do_shortcode("[ourteam
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    items_per_line='".$module["items_per_line"]."'
                    order='".$module["order"]."'
                    cpt_ids='".implode(",", $compile_cpt_ids)."'][/ourteam]");
                    break;
                #BREAK

                #NEW MODULE
                case "feature_posts":
                    $compile_cats = array();

                    if (isset($module["selected_categories"]) && (is_array($module["selected_categories"]))) {
                        foreach ($module["selected_categories"] as $catkey => $catvalue) {
                            array_push($compile_cats, $catkey);
                        }
                    }

                    $compile_cats = implode(",", $compile_cats);

                    $compile .= do_shortcode("[feature_posts
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    number_of_posts='".$module["number_of_posts"]."'
                    posts_per_line='".$module["posts_per_line"]."'
                    selected_categories='".$compile_cats."'
                    sorting_type='".$module["sorting_type"]."'
                    [/feature_posts]");
                    break;
                #BREAK

                #NEW MODULE
                case "feature_portfolio":
                    $compile_cats = array();

                    if (isset($module["selected_categories"]) && (is_array($module["selected_categories"]))) {
                        foreach ($module["selected_categories"] as $catkey => $catvalue) {
                            array_push($compile_cats, $catkey);
                        }
                    }

                    $compile_cats = implode(",", $compile_cats);

                    $compile .= do_shortcode("[feature_portfolio
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    number_of_posts='".$module["number_of_posts"]."'
                    posts_per_line='".$module["posts_per_line"]."'
                    selected_categories='".$compile_cats."'
                    sorting_type='".$module["sorting_type"]."'
                    [/feature_portfolio]");
                    break;
                #BREAK

                #NEW MODULE
                case "promo_text":
                    $compile .= do_shortcode("[promo_text
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    main_text='".$module["main_text"]."'
                    main_text_color='".$module["main_text_color"]."'
                    additional_text_color='".$module["additional_text_color"]."'
                    button_text='".$module["button_text"]."'
                    button_link='".$module["button_link"]."'
					button_type='".$module["promo_button_type"]."'
                    additional_text='".$module["additional_text"]."'][/promo_text]");
                    break;
                #BREAK

                #NEW MODULE
                case "iconboxes":
                    $compile .= do_shortcode("[iconbox
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    icon_type='".$module["icon_type"]."'
                    target='".$module["target"]."'
                    link='".$module["link"]."'
                    iconbox_heading='".$module["iconbox_heading"]."'
                    ]".$module["iconbox_text"]."[/iconbox]");
                    break;
                #BREAK

                #NEW MODULE
                case "statistic":
                    $compile .= do_shortcode("[statistic
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    icon_type='".$module["icon_type"]."'
                    stat_heading='".$module["stat_heading"]."'
                    ]".$module["stat_count"]."[/statistic]");
                    break;
                #BREAK

                #NEW MODULE
                case "messageboxes":
                    $compile .= do_shortcode("[messagebox
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    icon_type='".$module["icon_type"]."'
                    box_type='".$module["box_type"]."'
                    ]".$module["messagebox_text"]."[/messagebox]");
                    break;
                #BREAK

                #NEW MODULE
                case "blockquote":
                    $compile .= do_shortcode("[blockquote
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    quote_type='".$module["quote_type"]."'
                    author_name='".$module["author_name"]."'
                    ]".$module["quote_text"]."[/blockquote]");
                    break;
                #BREAK

                #NEW MODULE
                case "accordion":

                    if (!isset($accompile)) {$accompile='';}

                    if (is_array($module["module_items"])) {
                        foreach ($module["module_items"] as $acckey => $acc_item) {
                            $accompile .= "[accordion_item title='".$acc_item['title']."' expanded_state='".$acc_item['expanded_state']."']".$acc_item['description']."[/accordion_item]";
                        }
                    }
                    $compile .= do_shortcode("[accordion_shortcode
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    ]".$accompile."[/accordion_shortcode]");
                    unset($accompile);
                    break;
                #BREAK

                #NEW MODULE
                case "price_table":

                    if (!isset($tempcompile)) {$tempcompile='';}

                    if (isset($module["module_items"]) && is_array($module["module_items"])) {
                        $price_items_number = count($module["module_items"]);
                        $thiswidth = 100/$price_items_number - 0.3;
                        foreach ($module["module_items"] as $key => $thisitem) {

                            if (isset($thisitem['price_features']) && is_array($thisitem['price_features'])) {
                                $price_features = implode("||-||", $thisitem['price_features']);
                            } else {
                                $price_features = '';
                            }

                            $tempcompile .= "[pricetable_item block_name='".$thisitem['block_name']."' block_price='".$thisitem['block_price']."' block_period='".$thisitem['block_period']."' price_features='".$price_features."' block_link='".$thisitem['block_link']."' get_it_now_caption='".$thisitem['get_it_now_caption']."' most_popular='".$thisitem['most_popular']."' width='".$thiswidth."'][/pricetable_item]";
                        }
                    }
                    $compile .= do_shortcode("[pricetable
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    price_items_number='".$price_items_number."'
                    ]".$tempcompile."[/pricetable]");
                    unset($tempcompile, $price_features);
                    break;
                #BREAK

                #NEW MODULE
                case "toggle":

                    if (!isset($toggompile)) {$toggompile='';}

                    if (is_array($module["module_items"])) {
                        foreach ($module["module_items"] as $togglekey => $togg_item) {
                            $toggompile .= "[toggles_item title='".$togg_item['title']."' expanded_state='".$togg_item['expanded_state']."']".$togg_item['description']."[/toggles_item]";
                        }
                    }
                    $compile .= do_shortcode("[toggles_shortcode
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    ]".$toggompile."[/toggles_shortcode]");
                    unset($toggompile);
                    break;
                #BREAK


                #NEW MODULE
                case "faq":

                    if (!isset($faqgompile)) {$faqgompile='';}

                    if (is_array($module["module_items"])) {
                        foreach ($module["module_items"] as $togglekey => $togg_item) {
                            $faqgompile .= "[faq_item title='".$togg_item['title']."' expanded_state='".$togg_item['expanded_state']."']".$togg_item['description']."[/faq_item]";
                        }
                    }
                    $compile .= do_shortcode("[faq
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    ]".$faqgompile."[/faq]");
                    unset($faqgompile);
                    break;
                #BREAK

                #NEW MODULE
                case "blog":
                    $compile_cat_ids = array();

                    if (isset($module["cat_ids"]) && (is_array($module["cat_ids"]))) {
                        foreach ($module["cat_ids"] as $testkey => $testvalue) {
                            array_push($compile_cat_ids, $testkey);
                        }
                    }
                    $compile .= do_shortcode("[blog
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    posts_per_page='".$module["posts_per_page"]."'
                    view_type='".$module["view_type"]."'
                    cat_ids='".implode(",", $compile_cat_ids)."'
                    ][/blog]");
                    break;
                #BREAK


                #NEW MODULE
                case "counter":
                    $compile .= do_shortcode("[counter
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    stat_heading='".$module["stat_heading"]."'
                    stat_icon='".$module["stat_icon"]."'
                    ]".$module["stat_count"]."[/counter]");
                    break;
                #BREAK


                #NEW MODULE
                case "diagramm":

                    if (!isset($diagcompile)) {$diagcompile='';}


                    if (isset($module["module_items"]) && is_array($module["module_items"])) {
						$diag_items_number = count($module["module_items"]);
						$diag_width = 100/count($module["module_items"]);
						
                        foreach ($module["module_items"] as $diagkey => $diag_item) {
							$diagcompile .= "[diagramm_item padding_between_items='".$module["padding_between_items"]."' diag_width='".$diag_width."' percent='".$diag_item['percent']."' diag_title='".$diag_item['title']."']".$diag_item['description']."[/diagramm_item]";
                        }
                    }
					
                    $compile .= do_shortcode("[diagramm
                    heading_alignment='".$module["heading_alignment"]."'
					diagram_color='#".$module["diagram_color"]."'
					diagram_bg='#".$module["diagram_bg"]."'
					bar_width='".$module["bar_width"]."'
					percent_size='".$module["percent_size"]."'
					diagram_size='".$module["diagram_size"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    ]".$diagcompile."[/diagramm]");
                    unset($diagcompile);
                    break;
                #BREAK

                #NEW MODULE
                case "portfolio":
                    $compile_cats = array();

                    if (isset($module["selected_categories"]) && (is_array($module["selected_categories"]))) {
                        foreach ($module["selected_categories"] as $catkey => $catvalue) {
                            array_push($compile_cats, $catkey);
                        }
                    }

                    $compile .= do_shortcode("[portfolio
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    posts_per_page='".$module["posts_per_page"]."'
                    view_type='".$module["view_type"]."'
                    default_state='".$module["default_state"]."'
                    filter='".(isset($module["filter"]) ? $module["filter"] : "on")."'
                    selected_categories='".implode(",", $compile_cats)."'
                    ][/portfolio]");
                    break;
                #BREAK

                #NEW MODULE
                case "portfolio_masonry":
                    $compile_cats = array();

                    if (isset($module["selected_categories"]) && (is_array($module["selected_categories"]))) {
                        foreach ($module["selected_categories"] as $catkey => $catvalue) {
                            array_push($compile_cats, $catkey);
                        }
                    }

                    $compile .= do_shortcode("[portfolio_masonry
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    posts_per_page='".$module["posts_per_page"]."'
                    filter='".(isset($module["filter"]) ? $module["filter"] : "on")."'
                    selected_categories='".implode(",", $compile_cats)."'
                    ][/portfolio_masonry]");
                    break;
                #BREAK

                #NEW MODULE
                case "partners":

                    $compile_cpt_ids = array();

                    if (isset($module["cpt_ids"]) && (is_array($module["cpt_ids"]))) {
                        foreach ($module["cpt_ids"] as $testkey => $testvalue) {
                            array_push($compile_cpt_ids, $testkey);
                        }
                    }

                    $compile .= do_shortcode("[partners
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    partners_in_line='".$module["partners_in_line"]."'
                    cpt_ids='".implode(",", $compile_cpt_ids)."'
                    ][/partners]");
                    break;
                #BREAK

                #NEW MODULE
                case "contact_info":

                    $compile .= do_shortcode("[contacts
                    heading_alignment='".$module["heading_alignment"]."'
                    heading_color='".$module["heading_color"]."'
                    heading_size='".$module["heading_size"]."'
                    heading_text=\"".$module["heading_text"]."\"
                    module_id='".$module_key."'
                    ][/contacts]");
                    break;
                #BREAK


            }
            ################################################################################################
            ########################################          ##############################################
            ######################################## CASE END ##############################################
            ########################################          ##############################################
            ################################################################################################

            #Close main module container

            $compile .= "</div><!-- .module_cont -->";

            #If this is last module - close
            if ($normalModulesICounter == $normalModulesCount) {
                $compile .= "</div>";
                continue;
            }

            if ($module['size'] == "block_1_4") {
                $lineWidth += 1/4;
            }
            if ($module['size'] == "block_1_3") {
                $lineWidth += 1/3;
            }
            if ($module['size'] == "block_1_2") {
                $lineWidth += 1/2;
            }
            if ($module['size'] == "block_2_3") {
                $lineWidth += 2/3;
            }
            if ($module['size'] == "block_3_4") {
                $lineWidth += 3/4;
            }
            if ($module['size'] == "block_1_1") {
                $lineWidth += 1;
            }

            #$compile .= CLEAR IF ITS A NEW LINE
            if ($lineWidth >= 1) {
                $compile .= "</div>";
            }
        }
    }

    return $compile;
}

?>