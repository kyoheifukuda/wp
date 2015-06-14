<?php get_header(); ?>

    <div id="single_container">
    
      <div id="single_left">
      
        <?php if (have_posts()) : ?>
        <?php $x = 0; ?>
        <?php while (have_posts()) : the_post(); ?>
      
        <div class="blog_box">
          <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-blog-listing'); ?></a>
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p><?php echo substr(strip_tags(get_the_content()),0,250); ?></p>
        </div><!--//blog_box-->
        
        <?php endwhile; ?>
        
        <?php else : ?>
      
        <h3>No posts found. Try a different search?</h2>
        <?php get_search_form(); ?>
  
      <?php endif; ?>
        
        <div class="navigation">
          <div class="left"><?php previous_posts_link('&laquo; Previous') ?></div>
          <div class="right"><?php next_posts_link('Next &raquo;') ?></div>
          <div class="clear"></div>
        </div><!--//nagivation-->        
        
      
      </div><!--//single_left-->
      
      <?php get_sidebar(); ?>
      
      <div class="clear"></div>
      
    </div><!--//single_container-->
    
<?php get_footer(); ?>    