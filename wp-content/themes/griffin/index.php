<?php get_header(); ?>
<?php if (is_search()) : ?>
    <h1><?php _e('Search results:', 'griffin'); echo ' "' . get_search_query() . '"'; ?></h1>
<?php endif; ?>
<div class="spinner">
  <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div>
</div>
<div id="teaser-holder" class="row">	
	<?php
		if (have_posts()) :				
			while (have_posts()) : the_post();					
				get_template_part('content', get_post_format());
			endwhile;
		else :
			get_template_part('content', 'none');
		endif;
	?>	
</div>
<?php griffin_pagination(); ?>
<?php get_footer(); ?>