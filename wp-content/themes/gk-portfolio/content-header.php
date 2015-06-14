<?php

	/*
		Template for the entry header
	*/

	$video_code = portfolio_video_code();

?>
<header class="entry-header<?php if(is_singular() && is_sticky()) :?> sticky<?php endif; ?><?php if(get_theme_mod('portfolio_full_width_images', '1') == '1') : ?> full-width-image<?php endif; ?><?php if(get_theme_mod('portfolio_post_show_title', '1') == '0') : ?> no-title<?php endif; ?>">
	<?php if (has_post_thumbnail() && ! post_password_required()) : ?>			
		<?php the_post_thumbnail(); ?>
	<?php elseif($video_code) : ?>
		<div class="video-wrapper">
			<?php echo $video_code; ?>
		</div>
	<?php endif; ?>

	<?php if(get_theme_mod('portfolio_post_show_title', '1') == '1') : ?>
	<h<?php echo is_single() ? '1' : '2'; ?> class="entry-title">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h<?php echo is_single() ? '1' : '2'; ?>>
	<?php endif; ?>
</header><!-- .entry-header -->