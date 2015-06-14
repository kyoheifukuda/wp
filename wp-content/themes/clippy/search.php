<?php get_header(); ?>

		
		<div class="column-one">
			
			<header>
				<h2 class="post-title">
					   <?php _e("Search Results", "site5framework"); ?> / <span><?php echo esc_attr(get_search_query()); ?></span> 
				</h2>
			</header>

			<div id="" class="clearfix">
			
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