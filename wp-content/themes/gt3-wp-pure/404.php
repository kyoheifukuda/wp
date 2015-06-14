<?php get_header();
$gt3_theme_pagebuilder = gt3_get_default_pb_settings();
?>

    <div class="row <?php echo ((isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) && strlen($gt3_theme_pagebuilder['settings']['layout-sidebars'])>0) ? $gt3_theme_pagebuilder['settings']['layout-sidebars'] : "no-sidebar"); ?>">
        <div
            class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "span9" : "span12"); ?>">
            <div class="row">
                <div
                    class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "span9" : "span12"); ?>">
                    <div class="contentarea">
                        <div class="block404">
                            <h1><?php echo __('404 Error', 'theme_localization'); ?></h1>
                            <h4><?php echo __('Oops! Not found!', 'theme_localization'); ?></h4>
                            <p><?php echo __('Apologies, but we were unable to find what you were looking for.', 'theme_localization'); ?></p>
                            <?php get_search_form( true ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>