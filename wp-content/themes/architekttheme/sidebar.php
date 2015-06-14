      <div id="sidebar">
      
        <?php
        $args = array(
                     'category_name' => 'portfolio',
                     'post_type' => 'post',
                     'posts_per_page' => 3,
					 'orderby' => 'rand'
                     //'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                     );
        query_posts($args);
        while (have_posts()) : the_post(); ?>      
      
          <div class="side_box">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-side'); ?></a>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          </div><!--//side_box-->
          
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>          
        
      
      </div><!--//sidebar-->