<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_post_thumbnail('featured-full'); ?>
	<div id="post-content">
		<span id="post-comment-total"><?php comments_number('0', '1', '% '); ?></span>	
		<?php the_title('<h1 id="post-title">', '</h1>'); ?>
		<?php the_content() ?>							
	</div>
	<?php wp_link_pages('before=<div id="post-links">&after=</div>'); ?>
</article>	