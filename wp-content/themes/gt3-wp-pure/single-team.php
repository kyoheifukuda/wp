<?php get_header();
the_post();

/* LOAD PAGE BUILDER ARRAY */
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
$gt3_current_page_sidebar = $gt3_theme_pagebuilder['settings']['layout-sidebars'];
?>

<div class="content_wrapper">
    <?php if ($gt3_theme_pagebuilder['settings']['show_page_title'] !== "no") { ?>
        <div class="page_title_block">
            <div class="container">
                <h1 class="title"><?php the_title(); ?></h1>
            </div>
        </div>
    <?php } ?>
    <div class="container">
        <div class="content_block <?php echo ((isset($gt3_theme_pagebuilder['settings']['layout-sidebars']) && strlen($gt3_theme_pagebuilder['settings']['layout-sidebars'])>0) ? $gt3_theme_pagebuilder['settings']['layout-sidebars'] : "no-sidebar"); ?> row">
            <div class="fl-container <?php echo (($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "span9" : "span12"); ?>">
                <div class="row">
                    <div class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "span9" : "span12"); ?>">
                        <div class="contentarea">

                                            <?php
												$terms = get_the_terms( get_the_ID(), 'portcat' );
												if ( $terms && ! is_wp_error( $terms ) ) {
													$draught_links = array();
													foreach ( $terms as $term ) {
														$draught_links[] = '<a href="'.get_term_link($term->slug, "portcat").'">'.$term->name.'</a>';
													}
													$on_draught = join( ", ", $draught_links );
													$show_cat = true;
												}
                                            ?>

                                        </div>

                                        <article class="contentarea">
                                            <?php
                                            global $contentAlreadyPrinted;
                                            if ($contentAlreadyPrinted !== true) {
                                                echo '<div class="row"><div class="span12">';
                                                the_content(__('Read more!','theme_localization'));
                                                echo '</div><div class="clear"></div></div>';
                                            }
                                            wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __('Pages','theme_localization') . ': </span>', 'after' => '</div>' ) );
                                            ?>
                                        </article>
                                    </div><!--.blog_post_page -->
                                </div>
                            </div>
<?php

                                if ($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "no-sidebar") {
                                    $item_per_line = 4;
                                } else {
                                    $item_per_line = 3;
                                }

                                echo '<div class="row"><div class="gt3_col12 module_cont module_gallery module_gallery_page">';

                                $new_term_list = get_the_terms(get_the_id(), "portcat");
                                $echoallterm = '';
                                $echoterm = array();
                                if (is_array($new_term_list)) {
                                    foreach ($new_term_list as $term) {
                                        $echoterm[] = $term->term_id;
                                    }
                                }
								
								echo do_shortcode("[show_gallery
								heading_alignment=''
								heading_color=''
								heading_size=''
								heading_text=\"\"
								galleryid='".get_the_id()."'
								images_in_a_row='".$item_per_line."'
								][/show_gallery]");

								echo '</div></div>';								
                            ?>

                        </div><!-- .contentarea -->
                    </div>
                    <?php get_sidebar('left'); ?>
                </div>
                <div class="clear"><!-- ClearFix --></div>
            </div><!-- .fl-container -->
            <?php get_sidebar('right'); ?>
            <div class="clear"><!-- ClearFix --></div>
        </div>
    </div><!-- .container -->
</div><!-- .content_wrapper -->

<?php get_footer() ?>