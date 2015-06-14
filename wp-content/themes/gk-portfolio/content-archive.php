<?php
/**
 * The default template for displaying content
 * Used for index/archive/search.
 *
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(get_theme_mod('portfolio_frontpage_animation', '1') == '0' ? 'no-animation' : ''); ?> data-cols="<?php echo get_theme_mod('portfolio_article_column', '4')?>">
	<div class="article-helper notloaded">
		<div class="post-preview transition">
			<?php get_template_part('content', 'header'); ?>
		
			<?php if (is_home() || is_search() || is_archive() || is_tag()) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_excerpt(); ?></a>
				
			</div><!-- .entry-summary -->
		</div>
		<?php
			$tag_list = get_the_tag_list('<ul class="tags-links"><li>',', </li><li>','</li></ul>');
			if ($tag_list) {
				echo $tag_list;
			}
		?>
		<?php else : ?>
		<div class="entry-content">
			<?php the_content(__('Read more', 'portfolio')); ?>
			<?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'portfolio') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
			
			<?php
				$tag_list = get_the_tag_list('<ul class="tags-links"><li>',', </li><li>','</li></ul>');
				if ($tag_list) {
					echo $tag_list;
				}
			?>
		</div><!-- .entry-content -->
		<?php endif; ?>
	</div>
</article><!-- #post -->
