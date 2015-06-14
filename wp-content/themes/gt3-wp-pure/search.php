<?php get_header();
#Emulate default settings for page without personal ID
$gt3_theme_pagebuilder = gt3_get_default_pb_settings();
$gt3_current_page_sidebar = $gt3_theme_pagebuilder['settings']['layout-sidebars'];

?>

    <div class="content_wrapper">
        <?php if (gt3_get_theme_option("show_breadcrumb_area") !== "no") { ?>
            <div class="page_title_block">
                <div class="container">

                </div>
            </div>
        <?php } ?>
        <div class="container">
            <div class="content_block <?php echo $gt3_theme_pagebuilder['settings']['layout-sidebars'] ?> row">
                <div
                    class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "span9" : "span12"); ?>">
                    <div class="row">
                        <div
                            class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "span9" : "span12"); ?>">
                            <div class="contentarea">
                                <?php
                                echo '<div class="row-fluid"><div class="span12">';

                                global $paged;
                                $foundSomething = false;

                                if ($paged < 1) {
                                    $args = array(
                                        'numberposts' => -1,
                                        'post_type' => 'any',
                                        'meta_query' => array(
                                            array(
                                                'key' => 'pagebuilder',
                                                'value' => get_search_query(),
                                                'compare' => 'LIKE',
                                                'type' => 'CHAR'
                                            )
                                        )
                                    );
                                    $query = new WP_Query($args);
                                    while ($query->have_posts()) : $query->the_post();
                                        ?>
                                        <div <?php post_class("blog_post_preview theme_blog_listing search_page"); ?>>
                                            <div class="preview_wrapper">
                                                <div class="preview_topblock">
                                                    <h1 class="entry-title blogpost_title"><a class="blogpost_title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                                    <div class="preview_meta">
                                                    <span class="preview_meta_author">
                                                        by <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name'); ?></a>
                                                    </span>
                                                    <span><?php the_time("d M Y"); ?></span>

                                                    </div>
                                                    <article class="contentarea">
                                                        <?php
                                                        the_excerpt();
                                                        ?>
                                                    </article>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $foundSomething = true;
                                    endwhile;
                                    wp_reset_query();
                                }

                                $defaults = array('numberposts' => 10, 'post_type' => 'any', 'post_status' => 'publish', 'post_password' => '', 'suppress_filters' => false, 's' => get_search_query(), 'paged' => $paged);
                                $query = http_build_query($defaults);
                                $posts = get_posts($query);

                                foreach ($posts as $post) {
                                    setup_postdata($post);
                                    ?>
                                    <div <?php post_class("blog_post_preview theme_blog_listing search_page"); ?>>
                                        <div class="preview_wrapper">
                                            <div class="preview_topblock">
                                                <h1 class="entry-title blogpost_title"><a class="blogpost_title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                                <div class="preview_meta">
                                                    <span class="preview_meta_author">
                                                        by <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name'); ?></a>
                                                    </span>
                                                    <span><?php the_time("d M Y"); ?></span>

                                                </div>
                                                <article class="contentarea">
                                                    <?php
                                                    the_excerpt();
                                                    ?>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                    $foundSomething = true;
                                }
                                gt3_get_theme_pagination();

                                if ($foundSomething == false) {
                                    ?>
                                    <div class="block404" style="width:100%; text-align: center;">
                                        <h1 class="title404"><?php echo __('Oops!', 'theme_localization'); ?> <?php echo __('Not Found!', 'theme_localization'); ?></h1>

                                        <div
                                            class="text404"><?php echo __('Apologies, but we were unable to find what you were looking for.', 'theme_localization'); ?></div>
                                        <div class="search_form_wrap">
                                            <form name="search_field" method="get" action="<?php echo home_url(); ?>"
                                                  class="search_form" style="margin-top: 14px; margin-bottom: 40px;">
                                                <input type="text" name="s"
                                                       value="<?php _e('Search the site...', 'theme_localization'); ?>"
                                                       title="<?php _e('Search the site...', 'theme_localization'); ?>"
                                                       class="field_search">
                                            </form>
                                        </div>
                                    </div>
                                <?php
                                }

                                echo '</div><div class="clear"></div></div>';
                                ?>
                            </div>
                        </div>
                        <?php get_sidebar('left'); ?>
                    </div>
                </div>
                <?php get_sidebar('right'); ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>