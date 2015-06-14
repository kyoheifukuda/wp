<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <?php echo((gt3_get_theme_option("responsive") == "on") ? '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' : ''); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="shortcut icon" href="<?php echo gt3_get_theme_option('favicon'); ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo gt3_get_theme_option('apple_touch_57'); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo gt3_get_theme_option('apple_touch_72'); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo gt3_get_theme_option('apple_touch_114'); ?>">
    <title><?php bloginfo('name');
        echo(strlen(wp_title("&raquo;", false)) > 0 ? wp_title("&raquo;", false) : ""); ?></title>
    <script type="text/javascript">
        var gt3_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php echo gt3_get_if_strlen(gt3_get_theme_option("custom_css"), "<style>", "</style>") . gt3_get_if_strlen(gt3_get_theme_option("code_before_head"));
    globalJsMessage::getInstance()->render();
    wp_head(); ?>
</head>

<body <?php body_class(gt3_the_pb_custom_bg_and_color(gt3_get_theme_pagebuilder(@get_the_ID()), array("classes_for_body" => true)).gt3_the_check_fw_state(gt3_get_theme_pagebuilder(@get_the_ID()))." gt3_preloader"); ?>>
<div class="bbody op0">
<header class="clearfix <?php gt3_the_header_type(); ?>">
    <div class="show_mobile_menu"><?php echo __('MENU', 'theme_localization'); ?></div>
    <?php wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'menu_mobile', 'depth' => '3')); ?>

    <?php if (gt3_get_theme_option("header_type") == "type1") { ?>
    <nav class="clearfix desktop_menu">
        <?php wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'menu', 'depth' => '3', 'walker' => new gt3_menu_walker($showtitles = false))); ?>
    </nav>
    <?php } ?>

    <?php if (gt3_get_theme_option("header_type") == "type1" || gt3_get_theme_option("header_type") == "type2") {
        echo gt3_get_logo();
    } ?>

    <?php if (gt3_get_theme_option("header_type") == "type2") { ?>
        <nav class="clearfix desktop_menu">
            <?php wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'menu', 'depth' => '3', 'walker' => new gt3_menu_walker($showtitles = false))); ?>
        </nav>
    <?php } ?>

    <?php if (gt3_get_theme_option("header_type") == "type3") { ?>
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="fl">
                        <?php echo gt3_get_logo(); ?>
                    </div>
                    <div class="fr desktop_menu">
                        <?php if (gt3_get_theme_option("show_socials_in_header") == "true") {echo gt3_show_social_icons($GLOBALS['available_socials']);} ?>
                        <?php echo wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'menu', 'depth' => '3', 'walker' => new gt3_menu_walker($showtitles = false))); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (gt3_get_theme_option("header_type") == "type4") { ?>
        <div class="fw_header">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div class="left_part">
                            <?php if (strlen(gt3_get_theme_option("phone")) > 0) { ?><div class="thisitem"><i class="icon-phone"></i> <?php echo gt3_get_theme_option("phone"); ?></div><?php } ?>
                            <?php if (strlen(gt3_get_theme_option("public_email")) > 0) { ?><div class="thisitem"><i class="icon-envelope-alt"></i>
                                <a href="mailto:<?php echo gt3_get_theme_option("public_email"); ?>"><?php echo gt3_get_theme_option("public_email"); ?></a></div><?php } ?>
                        </div>
                        <div class="header_socials">
                            <?php if (gt3_get_theme_option("show_socials_in_header") == "true") {echo gt3_show_social_icons($GLOBALS['available_socials']);} ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="fl">
                        <?php echo gt3_get_logo(); ?>
                    </div>
                    <div class="fr desktop_menu">
                        <?php echo wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'menu', 'depth' => '3', 'walker' => new gt3_menu_walker($showtitles = false))); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php if (gt3_get_theme_option("header_type") == "type5") { ?>
        <div class="fw_header">
            <div class="fl">
                <?php echo gt3_get_logo(); ?>
            </div>
            <div class="fr desktop_menu">
                <?php echo wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'menu', 'depth' => '3', 'walker' => new gt3_menu_walker($showtitles = false))); ?>
            </div>
        </div>
    <?php } ?>
</header>

<div class="wrapper container">