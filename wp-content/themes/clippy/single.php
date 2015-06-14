<?php get_header(); ?>

		
		<div class="column-one">
			
			
			

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(	array('clearfix ' ) ); ?> role="article">

				<header>
					<h2 class="post-title"><?php the_title(); ?></h2>
				</header>

				<div class="meta clearfix">
					<div class="icon icon-<?php echo get_post_format(get_the_ID()) ?>"></div>
					<span class="post-date"><?php echo get_the_date(); ?></span>
					<span class="post-category"><?php echo the_category((', ')); ?></span>
					<span class="post-comments">
							<?php comments_popup_link( '0', '1', '%' ); ?>
					</span>
				</div>

				<!-- Post Formats-->
				<?php 
				$post_format = get_post_format();
				?>
				
				<?php
				switch($post_format):

					/* ---------------------------------------
					AUDIO
					------------------------------------------*/
				    case 'audio'; ?>

				    <?php
					wp_enqueue_script( 'jplayer-js' );
					wp_enqueue_style( 'jplayer-css' );
					?>
					<?php
					$postid = $post->ID;
					?>

					<div class="entry-audio">
					<?php
					   player_audio($postid);
					?>	
					</div>

				<?php
					break;
					/* ---------------------------------------
					GALLERY
					------------------------------------------*/
				    case 'gallery'; ?>

				    <?php 
				    wp_enqueue_script( 'flexslider-js' );
					wp_enqueue_style ( 'flexslider-css' );
					?>
					<script type="text/javascript">
					(function($) {
						jQuery(document).ready(function($){

						/*  Flex Slider */
						      $('.flexslider').flexslider({
						        animation: "fade",
						        easing:"swing",
						        smoothHeight: false,
						        slideshow: true,
						      });
						});
					})(jQuery);
					</script>
					<div class="entry-gallery">
						<div class="flexslider clearfix">
						  <ul class="slides">
						  	<?php
							//Pull gallery images from custom meta
							$gallery_images = get_post_meta($post->ID, SN.'gallery_post_images_',true);
							if($gallery_images !=  ''){ 
								foreach ($gallery_images as $gallery_image){
									$thumb = wp_get_attachment_image_src($gallery_image[SN.'gallery_post_image']['id'], 'large', false);
									?>
									<li><a class="prettyPhoto[mixed]" href="<?php echo $gallery_image[SN.'gallery_post_image']['src'] ?>"><img src="<?php echo $thumb[0] ?>" alt="<?php echo $gallery_image[SN.'gallery_post_title'] ?>" /></a>
									<?php if($gallery_image[SN.'gallery_post_title']!='') { ?><p class="flex-caption"><?php echo $gallery_image[SN.'gallery_post_title'] ?></p><?php } ?>
									</li>
							<?php
								} 
							}
							?>
						  </ul>
						</div>
					</div>

				<?php 
					break;
					/* ---------------------------------------
					Video
					------------------------------------------*/
				    case 'video'; ?>
				      
				    <?php
					wp_enqueue_script( 'fitvids-js' );
					wp_enqueue_script( 'jplayer-js' );
					wp_enqueue_style( 'jplayer-css' );
					?>
					<?php
					$postid = $post->ID;
					$embed = get_post_meta($post->ID, SN.'video_post_embed', $single = true);
					?>

					<div class="entry-video">
					<?php
					    if( !empty( $embed ) ) {
					    	$embed = stripslashes(htmlspecialchars_decode($embed));
					        echo add_youtube_video_wmode_transparent($embed); 
					    } else {
					    	player_video($postid);
						}
					?>
					</div>
				<?php 
					break;
					/* ---------------------------------------
					Link
					------------------------------------------*/
				    case 'link'; ?>
				      
					<div class="entry-link">
						<h3><a href="<?php echo get_post_meta($post->ID, SN.'link_post_url', true); ?>"><?php the_title(); ?></a></h3>
						<span><?php echo get_post_meta($post->ID, SN.'link_post_description', true); ?></span>
					</div>


				<?php 
					break;
					/* ---------------------------------------
					Image
					------------------------------------------*/
					case 'image'; ?>
					<?php 
					$image_post = get_post_meta($post->ID, SN.'image_post_upload',true);
					if($image_post !=''){ ?>
					<div class="entry-image">
					<?php
				    	$thumb = wp_get_attachment_image_src($image_post['id'], 'large', false);
				   		echo '<a class="prettyPhoto[mixed]" href="'.$image_post['src'].'"><img src="'.$thumb[0].'"></a>';
					?>
					
					</div>
					<?php }?>

				<?php
					break;
					case 'quote';
				?>
					<div class="entry-quote">
						<?php //the_content(); ?>
						<blockquote><?php echo get_post_meta($post->ID, SN.'quote_post', true); ?></blockquote>
						<span class="quote-author">~ <?php echo get_post_meta($post->ID, SN.'quote_author', true); ?> ~</span>
					</div>

				<?php
				endswitch;
				?>



				<div class="entry-content">
					<?php the_content(); ?>

					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'site5framework' ), 'after' => '</div>' ) ); ?>
				</div>

				<div class="entry-tags">
					<?php the_tags('', ' ', ' '); ?> 
				</div>

			</article>

			<?php endwhile; ?>



			<!-- begin #pagination -->
			<div class="navigation">
			<?php if (function_exists("emm_paginate")) { 
					emm_paginate();  
				 } else { ?>

		    <?php } ?>

		     	<div class="next alignleft"><?php next_posts_link('Older') ?></div>
		        <div class="prev alignright"><?php previous_posts_link('Newer') ?></div>
		    </div>
		    <!-- end #pagination -->



		    <?php

		    // Prev/Next Post with Thumbnails
			global $post;
			$post = get_post($post_id);

			$next_post = get_next_post();
			$previous_post = get_previous_post();

        	?>
        	<?php if($previous_post) : ?>
	        	<div class="prev-post">
	        		<div class="preview">
	        			<a href="<?php echo get_permalink( $previous_post->ID ) ?>">
	        				<?php echo get_the_post_thumbnail( $previous_post->ID,  'post-thumbnail'); ?> 
	        				<?php echo get_the_title( $previous_post->ID ) ?>
	        			</a> 
	        			<div class="meta clearfix">
							<span class="post-date icon icon-<?php echo get_post_format( $previous_post->ID ) ?>"><?php echo get_the_date("d M", $previous_post->ID); ?></span>
						</div>
					</div>
	        		<a href="<?php echo get_permalink( $previous_post->ID ) ?>"><span class="arrow"><span></a>
	        	</div>
            <?php endif; ?>
            <?php if($next_post) : ?>
	        	<div class="next-post">
	        		<div class="preview">
	        			<a href="<?php echo get_permalink( $next_post->ID ) ?>">
	        				<?php echo get_the_post_thumbnail( $next_post->ID,  'post-thumbnail'); ?> 
	        				<?php echo get_the_title( $next_post->ID ) ?>
	        			</a> 
	        			<div class="meta clearfix">
							<span class="post-date icon icon-<?php echo get_post_format( $next_post->ID ) ?>"><?php echo get_the_date("d M", $next_post->ID); ?></span>
						</div>
					</div>
	        		<a href="<?php echo get_permalink( $next_post->ID ) ?>"><span class="arrow"><span></a>
	        	</div>
            <?php endif; ?>
        	
            <?php comments_template(); ?>

			<?php endif;?>

			<?php wp_reset_query(); ?>

		</div><!-- end #column-one -->

		<div class="column-two">
		<?php get_sidebar('primary'); ?>
		</div><!-- end #column-two -->

<?php get_footer(); ?>