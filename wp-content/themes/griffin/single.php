<?php get_header(); ?>
<div id="post-holder" class="row">
	<div class="col-md-8">
		<?php				
			while (have_posts()) : the_post();					
				get_template_part('content', get_post_format());				
				comments_template();									
			endwhile;
		?>		
	</div>	
	<?php get_sidebar(); ?>	
</div>
<?php get_footer(); ?>				