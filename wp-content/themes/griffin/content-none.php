<article>		
	<div id="post-content">
	<h1><?php _e('Nothing Found','griffin'); ?></h1>
		<?php if (is_home() && current_user_can('publish_posts')) : ?>
			<p><?php printf( __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'griffin'), admin_url('post-new.php')); ?></p>
		<?php elseif (is_search()) : ?>
			<h5><?php _e('Search results:', 'griffin'); echo ' "' . get_search_query() . '"'; ?></h5>
			<p><?php _e('Sorry, but nothing matched your search terms. <br />Try again with some different keywords.', 'griffin'); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php _e('It seems we cannot find what you&rsquo;re looking for. Perhaps searching can help.', 'griffin'); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>							
	</div>		
</article>	