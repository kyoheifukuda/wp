<?php get_header(); ?>

    <div id="slider_container">
      <div class="slider-wrapper theme-default">
          <div class="ribbon"></div>
          <div id="slider" class="nivoSlider">
          
          <?php
          $args = array(
                       //'category_name' => 'blog',
                       'post_type' => 'post',
                       'meta_key' => 'ex_show_in_slideshow',
                       'meta_value' => 'Yes',
                       'posts_per_page' => 10
                       //'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                       );
          query_posts($args);
          while (have_posts()) : the_post(); ?>
          
          <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-slideshow',array('alt' => '', 'class' => 'slide_img', 'title' => '')); ?></a>
          
          <?php endwhile; ?>
          <?php wp_reset_query(); ?>          
<!--            <img src="<?php //bloginfo('stylesheet_directory'); ?>/images/slide-image.png" />
            <img src="<?php //bloginfo('stylesheet_directory'); ?>/images/slide-image.png" />
            <img src="<?php //bloginfo('stylesheet_directory'); ?>/images/slide-image.png" />-->
          </div>
      </div>    
    </div><!--//slider_container-->            
    
    <?php
    $args = array(
                 'category_name' => 'blog',
                 'post_type' => 'post',
                 'posts_per_page' => 3
                 //'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                 );
    query_posts($args);
    $x = 0;
    while (have_posts()) : the_post(); ?>
    
    <?php if($x == 2) { ?>
    <div class="home_blog_box home_blog_box_last">
    <?php } else { ?>
    <div class="home_blog_box">
    <?php } ?>
      <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-blog'); ?></a>
      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    </div><!--//home_blog_box-->    

    <?php $x++; ?>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
    
    <div class="clear"></div>
    
    <div class="home_port_cont">
    
    <?php
    $args = array(
                 'category_name' => 'portfolio',
                 'post_type' => 'post',
                 'posts_per_page' => 3
                 //'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                 );
    query_posts($args);
    $x = 0;
    while (have_posts()) : the_post(); ?>
      
      <?php if($x == 2) { ?>
      <div class="home_port_box home_port_box_last">
      <?php } else { ?>
      <div class="home_port_box">
      <?php } ?>
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('featured-portfolio'); ?></a>
		 <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
      </div><!--//home_port_box-->
      
      <?php if($x == 2) { echo '<div class="clear"></div>'; $x = -1; } ?>

    <?php $x++; ?>
    <?php endwhile; ?>
    <?php wp_reset_query(); ?>    
      
      <div class="clear"></div>      
    </div><!--//home_port_cont-->
    
<?php get_footer(); ?>    