<?php get_header(); ?>

		
		<div class="column-one">
			
			<header>
				<h2 class="post-title">
					<?php if (is_category()) { ?>
							<?php _e("Posts Categorized", "site5framework"); ?> / <span><?php single_cat_title(); ?></span> 
					<?php } elseif (is_tag()) { ?> 
							<?php _e("Posts Tagged", "site5framework"); ?> / <span><?php single_cat_title(); ?></span>
					<?php } elseif (is_author()) { ?>
							<?php _e("Posts By", "site5framework"); ?> / <span><?php the_author_meta('display_name', $post->post_author) ?> </span> 
					<?php } elseif (is_day()) { ?>
							<?php _e("Daily Archives", "site5framework"); ?> / <span><?php the_time('l, F j, Y'); ?></span>
					<?php } elseif (is_month()) { ?>
					    	<?php _e("Monthly Archives", "site5framework"); ?> / <span><?php the_time('F Y'); ?></span>
					<?php } elseif (is_year()) { ?>
					    	<?php _e("Yearly Archives", "site5framework"); ?> / <span><?php the_time('Y'); ?></span> 
					<?php } elseif (is_Search()) { ?>
					    	<?php _e("Search Results", "site5framework"); ?> / <span><?php echo esc_attr(get_search_query()); ?></span> 
					<?php } ?>
				</h2>
			</header>

			<div id="" class="clearfix">
			
				<?php
				// WP 3.0 PAGED BUG FIX
				if ( get_query_var('paged') )
				$paged = get_query_var('paged');
				elseif ( get_query_var('page') )
				$paged = get_query_var('page');
				else
				$paged = 1;

				$args = array(
				'post_type' => 'post',
				'paged' => $paged );

				global $wp_query;
				$args = array_merge( $wp_query->query_vars, $args );
				query_posts($args);
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


				<article id="post-<?php the_ID(); ?>" <?php post_class(	array('clearfix', 'box full-width' ) ); ?> role="article">

					<header>
						<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					</header>

					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>

					<?php get_template_part( '/lib/post-formats/content-meta' ); ?>

				</article>

				<?php endwhile; ?>

			</div><!-- //posts -->


			<!-- begin #pagination -->
			<?php if (function_exists("emm_paginate")) { 
				emm_paginate();  
			} else { ?>
			<div class="navigation">
			    <div class="alignleft"><?php next_posts_link('Older') ?></div>
			     <div class="alignright"><?php previous_posts_link('Newer') ?></div>
			</div>
		    <?php } ?>
		    <!-- end #pagination -->

			<?php else: ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(	array('clearfix', 'box full-width' ) ); ?> role="article">

					<header>
						<h2 class="post-title"><?php _e("No results found")?></h2>
					</header>

				</article>
			<?php endif;?>

			<?php wp_reset_query(); ?>

		</div><!-- end #column-one -->


		<div class="column-two">
		<?php get_sidebar('primary'); ?>
		</div><!-- end #column-two -->


<?php get_footer(); ?>