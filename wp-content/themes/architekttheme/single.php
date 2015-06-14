<?php get_header(); ?>

    <div id="single_container">
    
      <div id="single_left">
      
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
          <h1><?php the_title(); ?></h1>
          
          <?php the_content(); ?>
          
          <br /><br />
          
          <?php comments_template(); ?>
          
          <?php endwhile; else: ?>
          
              <h3>Sorry, no posts matched your criteria.</h3>
          
        <?php endif; ?>
      
      </div><!--//single_left-->
      
      <?php get_sidebar(); ?>
      
      <div class="clear"></div>
      
    </div><!--//single_container-->
    
<?php get_footer(); ?>    