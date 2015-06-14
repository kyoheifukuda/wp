<?php
// Portfolio Custom Post
$labels = array(
    'name' => _x('Portfolio', 'post type general name', 'site5framework'),
    'singular_name' => _x('Portfolio', 'post type singular name', 'site5framework'),
    'add_new' => _x('Add New', 'portfolio', 'site5framework'),
    'add_new_item' => __('Add New portfolio', 'site5framework'),
    'edit_item' => __('Edit Portfolio', 'site5framework'),
    'new_item' => __('New portfolio', 'site5framework'),
    'view_item' => __('View Portfolio', 'site5framework'),
    'search_items' => __('Search Portfolios', 'site5framework'),
    'not_found' =>  __('No portfolio found', 'site5framework'),
    'not_found_in_trash' => __('No portfolio found in Trash', 'site5framework'),
    'parent_item_colon' => ''
  );
register_post_type('portfolio', array(
     'labels' => $labels,
     'singular_label' => __('portfolio'),
     'public' => true,
     'show_ui' => true, // UI in admin panel
     '_builtin' => false, // It's a custom post type, not built in!
     '_edit_link' => 'post.php?post=%d',
     'capability_type' => 'post',
     'hierarchical' => false,
     'rewrite' => array("slug" => "portfolio"), // Permalinks format
     'supports' => array('title','editor','excerpt','thumbnail')
));

register_taxonomy("portfoliocat", array("portfolio"), array("hierarchical" => true, "label" => "Portfolio Category", "singular_label" => "Portfolio Category", "rewrite" => true));

//  Add Columns to Portfolio Edit Screen


function portfolio_edit_columns($portfolio_columns){
	$portfolio_columns = array(
		"cb" 				=> "<input type=\"checkbox\" />",
		"title" 			=> __('Title', 'site5framework'),
		"portfolio-tags" 	=> __('Tags', 'site5framework'),
		"author" 			=> __('Author', 'site5framework'),
		"comments" 			=> __('Comments', 'site5framework'),
		"date" 				=> __('Date', 'site5framework'),
	);
	$portfolio_columns['comments'] = '<div class="vers"><img alt="Comments" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>';
	return $portfolio_columns;
}



// Styling for the custom post type icon

add_action( 'admin_head', 'wpt_portfolio_icons' );

function wpt_portfolio_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-portfolio .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/admin/images/portfolio-icon.png) no-repeat 6px 6px !important;
        }
		#menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-has-current-submenu .wp-menu-image {
            background-position:6px -16px !important;
        }
		#icon-edit.icon32-posts-portfolio {background: url(<?php echo get_template_directory_uri(); ?>/admin/images/portfolio-32x32.png) no-repeat;}
    </style>

<?php }?>