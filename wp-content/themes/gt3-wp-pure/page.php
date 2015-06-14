<?php get_header();
the_post();
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
?>

    <div class="row <?php echo ((isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) && strlen($gt3_theme_pagebuilder['settings']['layout-sidebars'])>0) ? $gt3_theme_pagebuilder['settings']['layout-sidebars'] : "no-sidebar"); ?>">
        <div
            class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "span9" : "span12"); ?>">
            <div class="row">
                <div
                    class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "span9" : "span12"); ?>">
                    <div class="contentarea">
                        <?php
                        if (!isset($gt3_theme_pagebuilder['settings']['show_title']) || $gt3_theme_pagebuilder['settings']['show_title'] !== "no") {
                            echo '<h1 class="entry-title">' . get_the_title() . '</h1>';
                        }
                        the_content(__('Read more!', 'theme_localization'));
                        wp_link_pages(array('before' => '<div class="page-link">' . __('Pages', 'theme_localization') . ': ', 'after' => '</div>'));
                        if ( comments_open() && gt3_get_theme_option("page_comments") == "enabled" ) {
                        ?>
                            <div class="row">
                                <div class="span12">
                                    <?php comments_template(); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php get_sidebar('left'); ?>
            </div>
        </div>
        <?php get_sidebar('right'); ?>
    </div>

<?php get_footer(); ?>