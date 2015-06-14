<?php

include('settings.php');

if (function_exists('add_theme_support')) {
	add_theme_support('menus');
}

if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
  add_theme_support( 'post-thumbnails' );
  add_image_size('featured-slideshow',959,349,true);
  add_image_size('featured-big',369,408,true);
  add_image_size('featured-medium',369,196,true);
  add_image_size('featured-small',60,58,true);
  add_image_size('featured-blog',306,215,true);
  add_image_size('featured-portfolio',306,387,true);
  add_image_size('featured-side',306,215,true);
  add_image_size('featured-blog-listing',625,152,true);
  add_image_size('featured-port-listing',306,387,true);
}

if ( function_exists('register_sidebar') ) {
        register_sidebar(array(
                'name'=>'Footer First Box',
		'before_widget' => '<div class="footer_box">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
        
        register_sidebar(array(
                'name'=>'Footer Second Box',
		'before_widget' => '<div class="footer_box">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

        register_sidebar(array(
                'name'=>'Footer Third Box',
		'before_widget' => '<div class="footer_box">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
        
        register_sidebar(array(
                'name'=>'Footer Fourth Box',
		'before_widget' => '<div class="footer_box footer_box_last">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));        
}

function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = "/images/post_default.png";
  }
  return $first_img;
}

function kriesi_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}


// EX POST CUSTOM FIELD START

$prefix = 'ex_';

$meta_box = array(
    'id' => 'my-meta-box',
    'title' => 'Custom meta box',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
/*        array(
            'name' => 'Text box',
            'desc' => 'Enter something here',
            'id' => $prefix . 'text',
            'type' => 'text',
            'std' => 'Default value 1'
        ),
        array(
            'name' => 'Textarea',
            'desc' => 'Enter big text here',
            'id' => $prefix . 'textarea',
            'type' => 'textarea',
            'std' => 'Default value 2'
        ),
        array(
            'name' => 'Select box',
            'id' => $prefix . 'select',
            'type' => 'select',
            'options' => array('Option 1', 'Option 2', 'Option 3')
        ),
        array(
            'name' => 'Radio',
            'id' => $prefix . 'radio',
            'type' => 'radio',
            'options' => array(
                array('name' => 'Name 1', 'value' => 'Value 1'),
                array('name' => 'Name 2', 'value' => 'Value 2')
            )
        ),*/
        array(
            'name' => 'Show in slideshow',
            'id' => $prefix . 'show_in_slideshow',
            'type' => 'checkbox'
        )
    )
);

add_action('admin_menu', 'mytheme_add_box');

// Add meta box
function mytheme_add_box() {
    global $meta_box;

    add_meta_box($meta_box['id'], $meta_box['title'], 'mytheme_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}


// Callback function to show fields in meta box
function mytheme_show_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
                '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" value="Yes" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo     '<td>',
            '</tr>';
    }

    echo '</table>';
}


add_action('save_post', 'mytheme_save_data');

// Save data from meta box
function mytheme_save_data($post_id) {
    global $meta_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

// EX POST CUSTOM FIELD END

// **** EX SOCIAL START ****

class ex_social extends WP_Widget {

	function ex_social() {
		parent::WP_Widget(false, 'Architekt - Social');
	}

	function widget($args, $instance) {
                $args['social_title'] = $instance['social_title'];
		$args['dribbble_link'] = $instance['dribbble_link'];
                $args['forrst_link'] = $instance['forrst_link'];
                $args['facebook_link'] = $instance['facebook_link'];
                $args['twitter_link'] = $instance['twitter_link'];
                $args['tumblr_link'] = $instance['tumblr_link'];
		ex_func_social($args);
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
                $social_title = esc_attr($instance['social_title']);
		$dribbble_link = esc_attr($instance['dribbble_link']);
                $forrst_link = esc_attr($instance['forrst_link']);
                $facebook_link = esc_attr($instance['facebook_link']);
                $twitter_link = esc_attr($instance['twitter_link']);
                $tumblr_link = esc_attr($instance['tumblr_link']);
?>
                <p><label for="<?php echo $this->get_field_id('social_title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('social_title'); ?>" name="<?php echo $this->get_field_name('social_title'); ?>" type="text" value="<?php echo $social_title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('dribbble_link'); ?>"><?php _e('Dribbble Link:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('dribbble_link'); ?>" name="<?php echo $this->get_field_name('dribbble_link'); ?>" type="text" value="<?php echo $dribbble_link; ?>" /></label></p>
                <p><label for="<?php echo $this->get_field_id('forrst_link'); ?>"><?php _e('Forrst Link:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('forrst_link'); ?>" name="<?php echo $this->get_field_name('forrst_link'); ?>" type="text" value="<?php echo $forrst_link; ?>" /></label></p>
                <p><label for="<?php echo $this->get_field_id('facebook_link'); ?>"><?php _e('Facebook Link:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('facebook_link'); ?>" name="<?php echo $this->get_field_name('facebook_link'); ?>" type="text" value="<?php echo $facebook_link; ?>" /></label></p>
                <p><label for="<?php echo $this->get_field_id('twitter_link'); ?>"><?php _e('Twitter Link:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('twitter_link'); ?>" name="<?php echo $this->get_field_name('twitter_link'); ?>" type="text" value="<?php echo $twitter_link; ?>" /></label></p>
                <p><label for="<?php echo $this->get_field_id('tumblr_link'); ?>"><?php _e('Tumblr Link:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('tumblr_link'); ?>" name="<?php echo $this->get_field_name('tumblr_link'); ?>" type="text" value="<?php echo $tumblr_link; ?>" /></label></p>
<?php
	}
 }
function ex_func_social($args = array(), $displayComments = TRUE, $interval = '') {

	global $wpdb;

        //echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
        echo $args['before_widget'] . $args['before_title'] . $args['social_title'] . $args['after_title'];
        ?>
        <ul>
          <?php if($args['facebook_link'] != "") { ?>
          <li><a href="<?php echo $args['facebook_link']; ?>">Facebook</a></li>
          <?php } ?>
          
          <?php if($args['twitter_link'] != "") { ?>
          <li><a href="<?php echo $args['twitter_link']; ?>">Twitter</a></li>
          <?php } ?>
          
          <?php if($args['tumblr_link'] != "") { ?>
          <li><a href="<?php echo $args['tumblr_link']; ?>">Tumblr</a></li>          
          <?php } ?>
          
          <?php if($args['dribbble_link'] != "") { ?>
          <li><a href="<?php echo $args['dribbble_link']; ?>">Dribbble</a></li>
          <?php } ?>
          
          <?php if($args['forrst_link'] != "") { ?>
          <li><a href="<?php echo $args['forrst_link']; ?>">Forrst</a></li>
          <?php } ?>
        </ul>
        <?php
        
        echo $args['after_widget'];

}
register_widget('ex_social');  

// **** EX SOCIAL END ****


// **** PRODUCTION - PORTFOLIO LIST START ****

class prod_portfolio extends WP_Widget {

	function prod_portfolio() {
		parent::WP_Widget(false, 'Architekt - Portfolio');
	}

	function widget($args, $instance) {
                $args['portfolio_title'] = $instance['portfolio_title'];
		prod_func_portfolio($args);
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
                $portfolio_title = esc_attr($instance['portfolio_title']);
?>
                <p><label for="<?php echo $this->get_field_id('portfolio_title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('portfolio_title'); ?>" name="<?php echo $this->get_field_name('portfolio_title'); ?>" type="text" value="<?php echo $portfolio_title; ?>" /></label></p>
<?php
	}
 }
function prod_func_portfolio($args = array(), $displayComments = TRUE, $interval = '') {

	global $wpdb;

        //echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
        echo $args['before_widget'] . $args['before_title'] . $args['portfolio_title'] . $args['after_title'];
        $port_args = array(
                     'category_name' => 'portfolio',
                     'post_type' => 'post',
                     'posts_per_page' => 5
                     //'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                     );
        query_posts($port_args);
        echo '<ul>';
        while (have_posts()) : the_post(); ?>        
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; ?>
        <?php
        echo '</ul>';
        echo $args['after_widget'];
        wp_reset_query();
        

}
register_widget('prod_portfolio');  

// **** PRODUCTION - PORTFOLIO LIST END ****



// **** PRODUCTION - BLOG LIST START ****

class prod_blog extends WP_Widget {

	function prod_blog() {
		parent::WP_Widget(false, 'Architekt - Blog');
	}

	function widget($args, $instance) {
                $args['blog_title'] = $instance['blog_title'];
		prod_func_blog($args);
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
                $blog_title = esc_attr($instance['blog_title']);
?>
                <p><label for="<?php echo $this->get_field_id('blog_title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('blog_title'); ?>" name="<?php echo $this->get_field_name('blog_title'); ?>" type="text" value="<?php echo $blog_title; ?>" /></label></p>
<?php
	}
 }
function prod_func_blog($args = array(), $displayComments = TRUE, $interval = '') {

	global $wpdb;

        //echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
        echo $args['before_widget'] . $args['before_title'] . $args['blog_title'] . $args['after_title'];
        $port_args = array(
                     'category_name' => 'blog',
                     'post_type' => 'post',
                     'posts_per_page' => 5
                     //'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                     );
        query_posts($port_args);
        echo '<ul>';
        while (have_posts()) : the_post(); ?>        
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; ?>
        <?php
        echo '</ul>';
        echo $args['after_widget'];
        wp_reset_query();
        

}
register_widget('prod_blog');  

// **** PRODUCTION - BLOG LIST END ****




// **** PRODUCTION CONTACT START ****

class prod_contact extends WP_Widget {

	function prod_contact() {
		parent::WP_Widget(false, 'Architekt - Contact');
	}

	function widget($args, $instance) {
                $args['contact_title'] = $instance['contact_title'];
		$args['contact_name'] = $instance['contact_name'];
                $args['contact_tel'] = $instance['contact_tel'];
                $args['contact_fax'] = $instance['contact_fax'];
                $args['contact_email'] = $instance['contact_email'];
		prod_func_contact($args);
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
                $contact_title = esc_attr($instance['contact_title']);
		$contact_name = esc_attr($instance['contact_name']);
                $contact_tel = esc_attr($instance['contact_tel']);
                $contact_fax = esc_attr($instance['contact_fax']);
                $contact_email = esc_attr($instance['contact_email']);
?>
                <p><label for="<?php echo $this->get_field_id('contact_title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('contact_title'); ?>" name="<?php echo $this->get_field_name('contact_title'); ?>" type="text" value="<?php echo $contact_title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('contact_name'); ?>"><?php _e('Name:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('contact_name'); ?>" name="<?php echo $this->get_field_name('contact_name'); ?>" type="text" value="<?php echo $contact_name; ?>" /></label></p>
                <p><label for="<?php echo $this->get_field_id('contact_tel'); ?>"><?php _e('Telephone:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('contact_tel'); ?>" name="<?php echo $this->get_field_name('contact_tel'); ?>" type="text" value="<?php echo $contact_tel; ?>" /></label></p>
                <p><label for="<?php echo $this->get_field_id('contact_fax'); ?>"><?php _e('Fax:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('contact_fax'); ?>" name="<?php echo $this->get_field_name('contact_fax'); ?>" type="text" value="<?php echo $contact_fax; ?>" /></label></p>
                <p><label for="<?php echo $this->get_field_id('contact_email'); ?>"><?php _e('Email:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('contact_email'); ?>" name="<?php echo $this->get_field_name('contact_email'); ?>" type="text" value="<?php echo $contact_email; ?>" /></label></p>
<?php
	}
 }
function prod_func_contact($args = array(), $displayComments = TRUE, $interval = '') {

	global $wpdb;

        //echo $args['before_widget'] . $args['before_title'] . $args['title'] . $args['after_title'];
        echo $args['before_widget'] . $args['before_title'] . $args['contact_title'] . $args['after_title'];
        ?>
        <ul>
          <li><?php echo $args['contact_name']; ?></li>
          <li>Tel: <?php echo $args['contact_tel']; ?></li>
          <li>Fax: <?php echo $args['contact_fax']; ?></li>
          <li><?php echo $args['contact_email']; ?></li>
        </ul>
        <?php
        
        echo $args['after_widget'];

}
register_widget('prod_contact');  

// **** PRODUCTION CONTACT END ****

?>