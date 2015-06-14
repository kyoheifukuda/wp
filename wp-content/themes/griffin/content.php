<?php if (is_single()) : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php the_post_thumbnail('featured-full'); ?>
		<div id="post-content">
			<?php 
			$comment_count = get_comment_count($post->ID);
			if ($comment_count['approved'] > 0) : 
			?>
			<span id="post-comment-total"><?php comments_number('0', '1', '% '); ?></span>			
			<?php endif; ?>			
			<?php the_title('<h1 id="post-title">', '</h1>'); ?>
			<?php the_content() ?>
			<?php
			$post_tags = get_the_tags();
				if ($post_tags) :					
					echo '<div id="post-tags">';
					    foreach($post_tags as $tag) {
					    	echo '<a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name.'</a>'; 
					  	}
				  	echo '</div>';					  	
				endif;
			?>					
		</div>
		<?php wp_link_pages('before=<div id="post-links">&after=</div>'); ?>		
		<div id="post-footer" class="clearfix">
			<p><?php echo get_avatar(get_the_author_meta( 'ID' ), 32); ?> <?php the_author(); ?> &bull; <?php the_time(get_option('date_format')); ?></p>
			<hr />
			<div id="post-nav">
				<?php previous_post_link('<div id="post-nav-prev"><p><span>&Larr;</span> Previous Post</span></p>%link</div>'); ?> 	
				<?php next_post_link('<div id="post-nav-next"><p>Next Post <span>&Rarr;</span></p>%link</div>'); ?> 	
			</div>	
		</div>	
	</article>	
<?php else : ?>
<div <?php post_class(); ?>>
	<div class="teaser">		
		<?php the_post_thumbnail('featured-teaser'); ?>
		<div class="teaser-text">
			<?php 
			$comment_count = get_comment_count($post->ID);
			if ($comment_count['approved'] > 0) : 
			?>
			<span class="teaser-comment-total"><?php comments_number('0', '1', '% '); ?></span>			
			<?php endif; ?>			
			<?php if (is_sticky()) : ?> 
				<?php the_title('<h3 class="teaser-title"><span>&bigstar;</span><a href="' . esc_url( get_permalink()) . '" rel="bookmark">', '</a></h3>'); ?>
			<?php else: ?>
				<?php the_title('<h3 class="teaser-title"><a href="' . esc_url( get_permalink()) . '" rel="bookmark">', '</a></h3>'); ?>
			<?php endif; ?>
			<?php the_excerpt(); ?>
		</div>
		<div class="teaser-footer">
			<p><?php echo get_avatar(get_the_author_meta('ID'), 20); ?> <span><?php the_author(); ?> &bull; <?php the_time(get_option('date_format')); ?></span></p>			
		</div>
	</div>
</div>
<?php endif; ?>