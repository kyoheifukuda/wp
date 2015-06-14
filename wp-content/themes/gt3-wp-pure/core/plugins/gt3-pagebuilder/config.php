<?php

#main pb block settings
$GLOBALS["pbconfig"]['slider_and_bg_area'] = true;
$GLOBALS["pbconfig"]['slider_and_bg_area_enable_for'] = array('gallery', 'post', 'port', 'page');

#background / slider settings
$GLOBALS["pbconfig"]['enable_fullscreen_slider'] = true;
$GLOBALS["pbconfig"]['enable_fullwidth_slider'] = false;
$GLOBALS["pbconfig"]['enable_background_image'] = true;
$GLOBALS["pbconfig"]['enable_background_color'] = true;

#For this post types we enable page builder
$GLOBALS["pbconfig"]['page_builder_enable_for_posts'] = array('post', 'port', 'page', 'gallery', 'testimonials', 'partners', 'team');

#detail settings for page customization
$GLOBALS["pbconfig"]['pb_modules_enabled_for'] = array('page', 'port');
$GLOBALS["pbconfig"]['page_settings_enabled_for'] = array('page', 'post', 'team', 'port');
$GLOBALS["pbconfig"]['fullcreen_slider_enabled_for'] = array('gallery');
$GLOBALS["pbconfig"]['fullwidth_slider_enabled_for'] = array();
$GLOBALS["pbconfig"]['bg_image_enabled_for'] = array('post', 'port', 'page');
$GLOBALS["pbconfig"]['bg_color_enabled_for'] = array('post', 'port', 'page');

#List bg types for pages
$GLOBALS["pbconfig"]['page_bg_available_types'] = array('stretched', 'repeat');

#all_available_headers_for_module
$GLOBALS["pbconfig"]['all_available_headers_for_module'] = array("h1", "h2", "h3", "h4", "h5", "h6");

#all_available_headers_for_module
$GLOBALS["pbconfig"]['all_available_headers_alignment'] = array("left", "center", "right");

#default heading in module
$GLOBALS["pbconfig"]['default_heading_in_module'] = "h4";

#available quote types
$GLOBALS["pbconfig"]['all_available_quote_types'] = array("" => "Default", "type1" => "Type1", "type2" => "Type2", "type3" => "Type3", "type4" => "Type4", "type5" => "Type5");

#available animation
$GLOBALS["pbconfig"]['all_available_animation'] = array(
    "none" => "None",
    "pulse" => "Pulse",
    "flipInX" => "flipInX",
    "fadeIn" => "fadeIn",
    "fadeInUp" => "fadeInUp",
    "fadeInDown" => "fadeInDown",
    "fadeInLeft" => "fadeInLeft",
    "fadeInRight" => "fadeInRight",
    "fadeInUpBig" => "fadeInUpBig",
    "fadeInDownBig" => "fadeInDownBig",
    "fadeInLeftBig" => "fadeInLeftBig",
    "fadeInRightBig" => "fadeInRightBig",
    "bounceIn" => "bounceIn",
    "bounceInUp" => "bounceInUp",
    "bounceInDown" => "bounceInDown",
    "bounceInLeft" => "bounceInLeft",
    "bounceInRight" => "bounceInRight",
    "rotateInUpLeft" => "rotateInUpLeft",
    "rotateInDownLeft" => "rotateInDownLeft",
    "rotateInUpRight" => "rotateInUpRight",
    "rotateInDownRight" => "rotateInDownRight",
    "lightSpeedRight" => "lightSpeedRight",
    "lightSpeedLeft" => "lightSpeedLeft",
    "rollin" => "rollin"
);

#gallery
$GLOBALS["pbconfig"]['gallery_module_default_width'] = "100px";
$GLOBALS["pbconfig"]['gallery_module_default_height'] = "150px";

#blog default posts per page
$GLOBALS["pbconfig"]['blog_default_posts_per_page'] = 7;
$GLOBALS["pbconfig"]['blog_masonry_default_posts_per_page'] = 7;
$GLOBALS["pbconfig"]['all_blogpost_date_types'] = array("date-inside_meta" => "Inside blog post meta", "date-global_left" => "Global left", "date-top_left" => "Above featured image", "date-content_left" => "Below featured image");
$GLOBALS["pbconfig"]['all_blogpost_title_types'] = array("title-top" => "Above featured image", "title-content" => "Below featured image");
$GLOBALS["pbconfig"]['all_blogpost_meta_types'] = array("meta-top" => "Above featured image", "meta-content" => "Below featured image", "meta-bottom" => "Below content");

#portfolio default posts per page
$GLOBALS["pbconfig"]['posts_per_page'] = 4;
#$GLOBALS["pbconfig"]['all_available_portfolio_types'] = array("1 column", "2 columns", "3 columns", "4 columns", "Grid", "Masonry");
$GLOBALS["pbconfig"]['all_available_portfolio_types'] = array("Grid", "Masonry");

#featured posts number of posts (not main blog module!)
$GLOBALS["pbconfig"]['featured_posts_default_number_of_posts'] = 12;
$GLOBALS["pbconfig"]['featured_posts_default_posts_per_line'] = 4;
$GLOBALS["pbconfig"]['featured_posts_letters_in_excerpt'] = 130;
$GLOBALS["pbconfig"]['featured_posts_available_post_types'] = array(
    "post" => "Post",
    "port" => "Portfolio",
);
$GLOBALS["pbconfig"]['featured_posts_available_sorting_type'] = array("new", "random");

#default video height
$GLOBALS["pbconfig"]['default_video_height'] = "450px";

#default number of workers for team module
$GLOBALS["pbconfig"]['team_default_numbers'] = 20;

#testimonials
$GLOBALS["pbconfig"]['all_available_testimonial_display_type'] = array("type1", "type2");

#all available testimonial sorting type
$GLOBALS["pbconfig"]['all_available_testimonial_sorting_type'] = array("new", "random");

#all available iconboxes
$GLOBALS["pbconfig"]['all_available_iconboxes'] = array("a", "b", "c");

#iconboxes img preview
$GLOBALS["pbconfig"]['iconboxes_img_preview_url'] = "/core/admin/img/available_iconboxes.jpg";

#all available custom list types
$GLOBALS["pbconfig"]['all_available_custom_list_types'] = array(
    "ordered" => "Ordered",
    "list_type1" => "Arrow",
    "list_type2" => "Plus",
    "" => "Normal",
    "list_type3" => "Download",
    "list_type4" => "Print",
    "list_type5" => "Edit",
    "list_type6" => "Attach"
);

#all available custom buttons
$GLOBALS["pbconfig"]['all_available_custom_buttons'] = array(
    "btn_small btn_type1" => "Small Dark",
    "btn_small btn_type2" => "Small Gray",
    "btn_small btn_type3" => "Small Light Gray",
    "btn_small btn_type4" => "Small Light",
    "btn_small btn_type5" => "Small Colored",
    "btn_small btn_type6" => "Small Sea Blue",
    "btn_small btn_type7" => "Small Green",
    "btn_small btn_type8" => "Small Lime",
    "btn_small btn_type9" => "Small Yellow",
    "btn_small btn_type10" => "Small Orange",
    "btn_small btn_type11" => "Small Red",
    "btn_small btn_type12" => "Small Pink",
    "btn_small btn_type13" => "Small Magenta",
    "btn_small btn_type14" => "Small Purple",
    "btn_small btn_type15" => "Small Violet",
	"btn_small btn_type16" => "Small Blue",
	"btn_small btn_type17" => "Small Light Blue",
    "btn_normal btn_type1" => "Medium Dark",
    "btn_normal btn_type2" => "Medium Gray",
    "btn_normal btn_type3" => "Medium Light Gray",
    "btn_normal btn_type4" => "Medium Light",
    "btn_normal btn_type5" => "Medium Colored",
    "btn_normal btn_type6" => "Medium Sea Blue",
    "btn_normal btn_type7" => "Medium Green",
    "btn_normal btn_type8" => "Medium Lime",
    "btn_normal btn_type9" => "Medium Yellow",
    "btn_normal btn_type10" => "Medium Orange",
    "btn_normal btn_type11" => "Medium Red",
    "btn_normal btn_type12" => "Medium Pink",
    "btn_normal btn_type13" => "Medium Magenta",
    "btn_normal btn_type14" => "Medium Purple",
    "btn_normal btn_type15" => "Medium Violet",
	"btn_normal btn_type16" => "Medium Blue",
	"btn_normal btn_type17" => "Medium Light Blue",
    "btn_large btn_type1" => "Large Dark",
    "btn_large btn_type2" => "Large Gray",
    "btn_large btn_type3" => "Large Light Gray",
    "btn_large btn_type4" => "Large Light",
    "btn_large btn_type5" => "Large Colored",
    "btn_large btn_type6" => "Large Sea Blue",
    "btn_large btn_type7" => "Large Green",
    "btn_large btn_type8" => "Large Lime",
    "btn_large btn_type9" => "Large Yellow",
    "btn_large btn_type10" => "Large Orange",
    "btn_large btn_type11" => "Large Red",
    "btn_large btn_type12" => "Large Pink",
    "btn_large btn_type13" => "Large Magenta",
    "btn_large btn_type14" => "Large Purple",
    "btn_large btn_type15" => "Large Violet",
	"btn_large btn_type16" => "Large Blue",
	"btn_large btn_type17" => "Large Light Blue"
);

#all available custom buttons positions
$GLOBALS["pbconfig"]['all_available_positions_for_custom_buttons'] = array(
    "" => "Default",
    "btnpos_left" => "Left",
    "btnpos_right" => "Right",
    "btnpos_center" => "Center"
);

#all available custom buttons
$GLOBALS["pbconfig"]['all_available_target_for_custom_buttons'] = array(
    "_blank" => "Blank",
    "_self" => "Self"
);

#all available dropcaps
$GLOBALS["pbconfig"]['all_available_dropcaps'] = array(
    "" => "Type1",
    "type1" => "Type2",
    "type2" => "Type3",
    "type3" => "Type4",
    "type4" => "Type5",
    "type5" => "Type6"
);

#all available messageboxes
$GLOBALS["pbconfig"]['messagebox_available_types'] = array(
    "box_type1" => "Type 1",
    "box_type2" => "Type 2",
    "box_type3" => "Type 3",
    "box_type4" => "Type 4",
    "box_type5" => "Type 5"
);

#all available highlighters
$GLOBALS["pbconfig"]['all_available_highlighters'] = array(
    "colored" => "Colored",
    "dark" => "Dark",
    "light" => "Light"
);

#all available dividers
$GLOBALS["pbconfig"]['all_available_dividers'] = array(
    "" => "Default",
    "type1" => "Type1",
    "type2" => "Type2",
    "type3" => "Type3"
);

#all available tabs types
$GLOBALS["pbconfig"]['available_tabs_types'] = array(
    "type1" => "Horizontal",
    "type2" => "Vertical"
);

#all available social icons
$GLOBALS["pbconfig"]['all_available_social_icons'] = array(
);

#all available social icon type
$GLOBALS["pbconfig"]['all_available_social_icons_type'] = array(
    "type1" => "Square",
	"type2" => "Rounded",
	"type3" => "Circle",
	"type4" => "Empty",
);

#partners number
$GLOBALS["pbconfig"]['partners_default_number'] = 6;

#Padding top for bg start
$GLOBALS["pbconfig"]['available_padding_top_for_bg_start'] = array(
    "top_padding_normal" => "Default (45px)",
    "top_padding_medium" => "20px",
    "top_padding_small" => "15px",
    "top_padding_none" => "0px",
);

#Padding after modules
$GLOBALS["pbconfig"]['default_padding_after_module'] = "30px";

#View type for Meta module
$GLOBALS["pbconfig"]['available_postinfo_module_view_types'] = array(
    "portfolio_type1" => "Vertical",
    "portfolio_type2" => "Horizontal"
);

#how many images from media library show on one page
$GLOBALS["pbconfig"]['images_from_media_library'] = 30;

#How many items in OUR TEAM per line
$GLOBALS["pbconfig"]['available_workers_per_line'] = array(
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4",
);

#How many items in FEATURED POSTS per line
$GLOBALS["pbconfig"]['available_posts_per_line'] = array(
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4",
);

#How many images in a row (in gallery)
$GLOBALS["pbconfig"]['gallery_images_in_a_row'] = array(
    "1" => "1",
    "2" => "2",
    "3" => "3",
    "4" => "4"
);

#How many images in a row (in wall)
$GLOBALS["pbconfig"]['wall_images_in_a_row'] = array(
    "3" => "3",
    "4" => "4",
    "5" => "5",
    "6" => "6",
    "7" => "7"
);

#All font icons
$GLOBALS["pbconfig"]['all_available_font_icons'] = array(
    "icon-adjust",
    "icon-anchor",
    "icon-archive",
    "icon-asterisk",
    "icon-ban-circle",
    "icon-bar-chart",
    "icon-barcode",
    "icon-beaker",
    "icon-beer",
    "icon-bell",
    "icon-bell-alt",
    "icon-bolt",
    "icon-book",
    "icon-bookmark",
    "icon-bookmark-empty",
    "icon-briefcase",
    "icon-bug",
    "icon-building",
    "icon-bullhorn",
    "icon-bullseye",
    "icon-calendar",
    "icon-calendar-empty",
    "icon-camera",
    "icon-camera-retro",
    "icon-certificate",
    "icon-check",
    "icon-check-empty",
    "icon-check-minus",
    "icon-check-sign",
    "icon-circle",
    "icon-circle-blank",
    "icon-cloud",
    "icon-cloud-download",
    "icon-cloud-upload",
    "icon-code",
    "icon-code-fork",
    "icon-coffee",
    "icon-cog",
    "icon-cogs",
    "icon-collapse",
    "icon-collapse-alt",
    "icon-collapse-top",
    "icon-comment",
    "icon-comment-alt",
    "icon-comments",
    "icon-comments-alt",
    "icon-compass",
    "icon-credit-card",
    "icon-crop",
    "icon-dashboard",
    "icon-desktop",
    "icon-download",
    "icon-download-alt",
    "icon-edit",
    "icon-edit-sign",
    "icon-ellipsis-horizontal",
    "icon-ellipsis-vertical",
    "icon-envelope",
    "icon-envelope-alt",
    "icon-eraser",
    "icon-exchange",
    "icon-exclamation",
    "icon-exclamation-sign",
    "icon-expand",
    "icon-expand-alt",
    "icon-external-link",
    "icon-external-link-sign",
    "icon-eye-close",
    "icon-eye-open",
    "icon-facetime-video",
    "icon-female",
    "icon-fighter-jet",
    "icon-film",
    "icon-filter",
    "icon-fire",
    "icon-fire-extinguisher",
    "icon-flag",
    "icon-flag-alt",
    "icon-flag-checkered",
    "icon-folder-close",
    "icon-folder-close-alt",
    "icon-folder-open",
    "icon-folder-open-alt",
    "icon-food",
    "icon-frown",
    "icon-gamepad",
    "icon-gear",
    "icon-gears",
    "icon-gift",
    "icon-glass",
    "icon-globe",
    "icon-group",
    "icon-hdd",
    "icon-headphones",
    "icon-heart",
    "icon-heart-empty",
    "icon-home",
    "icon-inbox",
    "icon-info",
    "icon-info-sign",
    "icon-key",
    "icon-keyboard",
    "icon-laptop",
    "icon-leaf",
    "icon-legal",
    "icon-lemon",
    "icon-level-down",
    "icon-level-up",
    "icon-lightbulb",
    "icon-location-arrow",
    "icon-lock",
    "icon-magic",
    "icon-magnet",
    "icon-mail-forward",
    "icon-mail-reply",
    "icon-mail-reply-all",
    "icon-male",
    "icon-map-marker",
    "icon-meh",
    "icon-microphone",
    "icon-microphone-off",
    "icon-minus",
    "icon-minus-sign",
    "icon-minus-sign-alt",
    "icon-mobile-phone",
    "icon-money",
    "icon-moon",
    "icon-move",
    "icon-music",
    "icon-off",
    "icon-ok",
    "icon-ok-circle",
    "icon-ok-sign",
    "icon-pencil",
    "icon-phone",
    "icon-phone-sign",
    "icon-picture",
    "icon-plane",
    "icon-plus",
    "icon-plus-sign",
    "icon-plus-sign-alt",
    "icon-power-off",
    "icon-print",
    "icon-pushpin",
    "icon-puzzle-piece",
    "icon-qrcode",
    "icon-question",
    "icon-question-sign",
    "icon-quote-left",
    "icon-quote-right",
    "icon-random",
    "icon-refresh",
    "icon-remove",
    "icon-remove-circle",
    "icon-remove-sign",
    "icon-reorder",
    "icon-reply",
    "icon-reply-all",
    "icon-resize-horizontal",
    "icon-resize-vertical",
    "icon-retweet",
    "icon-road",
    "icon-rocket",
    "icon-rss",
    "icon-rss-sign",
    "icon-screenshot",
    "icon-search",
    "icon-share",
    "icon-share-alt",
    "icon-share-sign",
    "icon-shield",
    "icon-shopping-cart",
    "icon-sign-blank",
    "icon-signal",
    "icon-signin",
    "icon-signout",
    "icon-sitemap",
    "icon-smile",
    "icon-sort",
    "icon-sort-by-alphabet",
    "icon-sort-by-alphabet-alt",
    "icon-sort-by-attributes",
    "icon-sort-by-attributes-alt",
    "icon-sort-by-order",
    "icon-sort-by-order-alt",
    "icon-sort-down",
    "icon-sort-up",
    "icon-spinner",
    "icon-star",
    "icon-star-empty",
    "icon-star-half",
    "icon-star-half-empty",
    "icon-star-half-full",
    "icon-subscript",
    "icon-suitcase",
    "icon-sun",
    "icon-superscript",
    "icon-tablet",
    "icon-tag",
    "icon-tags",
    "icon-tasks",
    "icon-terminal",
    "icon-thumbs-down",
    "icon-thumbs-down-alt",
    "icon-thumbs-up",
    "icon-thumbs-up-alt",
    "icon-ticket",
    "icon-time",
    "icon-tint",
    "icon-trash",
    "icon-trophy",
    "icon-truck",
    "icon-umbrella",
    "icon-unchecked",
    "icon-unlock",
    "icon-unlock-alt",
    "icon-upload",
    "icon-upload-alt",
    "icon-user",
    "icon-volume-down",
    "icon-volume-off",
    "icon-volume-up",
    "icon-warning-sign",
    "icon-wrench",
    "icon-zoom-in",
    "icon-zoom-out",
    "icon-bitcoin",
    "icon-btc",
    "icon-cny",
    "icon-dollar",
    "icon-eur",
    "icon-euro",
    "icon-gbp",
    "icon-inr",
    "icon-jpy",
    "icon-krw",
    "icon-renminbi",
    "icon-rupee",
    "icon-usd",
    "icon-won",
    "icon-yen",
    "icon-align-center",
    "icon-align-justify",
    "icon-align-left",
    "icon-align-right",
    "icon-bold",
    "icon-columns",
    "icon-copy",
    "icon-cut",
    "icon-eraser",
    "icon-file",
    "icon-file-alt",
    "icon-file-text",
    "icon-file-text-alt",
    "icon-font",
    "icon-indent-left",
    "icon-indent-right",
    "icon-italic",
    "icon-link",
    "icon-list",
    "icon-list-alt",
    "icon-list-ol",
    "icon-list-ul",
    "icon-paper-clip",
    "icon-paperclip",
    "icon-paste",
    "icon-repeat",
    "icon-rotate-left",
    "icon-rotate-right",
    "icon-save",
    "icon-strikethrough",
    "icon-table",
    "icon-text-height",
    "icon-text-width",
    "icon-th",
    "icon-th-large",
    "icon-th-list",
    "icon-underline",
    "icon-undo",
    "icon-unlink",
    "icon-angle-down",
    "icon-angle-left",
    "icon-angle-right",
    "icon-angle-up",
    "icon-arrow-down",
    "icon-arrow-left",
    "icon-arrow-right",
    "icon-arrow-up",
    "icon-caret-down",
    "icon-caret-left",
    "icon-caret-right",
    "icon-caret-up",
    "icon-chevron-down",
    "icon-chevron-left",
    "icon-chevron-right",
    "icon-chevron-sign-down",
    "icon-chevron-sign-left",
    "icon-chevron-sign-right",
    "icon-chevron-sign-up",
    "icon-chevron-up",
    "icon-circle-arrow-down",
    "icon-circle-arrow-left",
    "icon-circle-arrow-right",
    "icon-circle-arrow-up",
    "icon-double-angle-down",
    "icon-double-angle-left",
    "icon-double-angle-right",
    "icon-double-angle-up",
    "icon-hand-down",
    "icon-hand-left",
    "icon-hand-right",
    "icon-hand-up",
    "icon-long-arrow-down",
    "icon-long-arrow-left",
    "icon-long-arrow-right",
    "icon-long-arrow-up",
    "icon-backward",
    "icon-eject",
    "icon-fast-backward",
    "icon-fast-forward",
    "icon-forward",
    "icon-fullscreen",
    "icon-pause",
    "icon-play",
    "icon-play-circle",
    "icon-play-sign",
    "icon-resize-full",
    "icon-resize-small",
    "icon-step-backward",
    "icon-step-forward",
    "icon-stop",
    "icon-youtube-play",
    "icon-adn",
    "icon-android",
    "icon-apple",
    "icon-bitbucket",
    "icon-bitbucket-sign",
    "icon-bitcoin",
    "icon-btc",
    "icon-css3",
    "icon-dribbble",
    "icon-dropbox",
    "icon-facebook",
    "icon-facebook-sign",
    "icon-flickr",
    "icon-foursquare",
    "icon-github",
    "icon-github-alt",
    "icon-github-sign",
    "icon-gittip",
    "icon-google-plus",
    "icon-google-plus-sign",
    "icon-html5",
    "icon-instagram",
    "icon-linkedin",
    "icon-linkedin-sign",
    "icon-linux",
    "icon-maxcdn",
    "icon-pinterest",
    "icon-pinterest-sign",
    "icon-renren",
    "icon-skype",
    "icon-stackexchange",
    "icon-trello",
    "icon-tumblr",
    "icon-tumblr-sign",
    "icon-twitter",
    "icon-twitter-sign",
    "icon-vk",
    "icon-weibo",
    "icon-windows",
    "icon-xing",
    "icon-xing-sign",
    "icon-youtube",
    "icon-youtube-play",
    "icon-youtube-sign",
    "icon-ambulance",
    "icon-h-sign",
    "icon-hospital",
    "icon-medkit",
    "icon-plus-sign-alt",
    "icon-stethoscope",
    "icon-user-md"
);

$GLOBALS["pbconfig"]['featured_port_default_number_of_posts'] = 2;
$GLOBALS["pbconfig"]['featured_port_default_posts_per_line'] = 2;

$GLOBALS["pbconfig"]['featured_portfolio_default_number_of_posts'] = 2;

global $compileShortcodeUI, $defaultUI;
$compileShortcodeUI = "";
$defaultUI = "";

?>