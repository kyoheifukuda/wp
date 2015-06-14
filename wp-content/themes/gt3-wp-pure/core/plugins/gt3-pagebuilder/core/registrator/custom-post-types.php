<?php
#Register portfolio
function my_post_type_port()
{
    register_post_type('port', array(
            'label' => __('Portfolio', 'gt3_builder'),
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array(
                'slug' => 'portfolio',
                'with_front' => false
            ),
            'hierarchical' => true,
            'menu_position' => 5,
            'supports' => array(
                'title',
                'post-formats',
                'comments',
                'page-attributes',
                'editor',
                'excerpt',
                'thumbnail')
        )
    );
    register_taxonomy('portcat', 'port', array('hierarchical' => true, 'label' => __('Category', 'gt3_builder'), 'singular_name' => 'Category'));

    #ADD CUSTOM COLUMNS TO PORT CPT LIST (ADMIN)
    add_filter("manage_edit-port_columns", "show_portfolio_column");
    function show_portfolio_column($columns)
    {
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => __("Title", 'gt3_builder'),
            "author" => __("Author", 'gt3_builder'),
            "portfolio-category" => __("Categories", 'gt3_builder'),
            "date" => __("Date", 'gt3_builder'));
        return $columns;
    }

    add_action("manage_pages_custom_column", "port_custom_columns");
    function port_custom_columns($column)
    {
        global $post;

        switch ($column) {
            case "portfolio-category":
                echo get_the_term_list($post->ID, 'portcat', '', ', ', '');
                break;
        }
    }

    #Team
    register_post_type('team', array(
            'label' => __('Team', 'gt3_builder'),
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array(
                'slug' => 'team',
                'with_front' => false
            ),
            'hierarchical' => true,
            'menu_position' => 6,
            'supports' => array(
                'title',
                'editor',
                'thumbnail')
        )
    );

    #Gallery
    register_post_type('gallery', array(
            'label' => __('Gallery', 'gt3_builder'),
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array(
                'slug' => 'gallery',
                'with_front' => false
            ),
            'hierarchical' => true,
            'menu_position' => 4,
            'supports' => array(
                'title'
            )
        )
    );

    #Testimonials
    $labels = array(
        'name' => __('Testimonials', 'gt3_builder'),
        'add_new_item' => __('Add New', 'gt3_builder')
    );
    register_post_type('testimonials', array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array(
                'slug' => 'testimonials',
                'with_front' => false
            ),
            'hierarchical' => true,
            'menu_position' => 7,
            'supports' => array(
                'title',
                'editor',
                'thumbnail'
            )
        )
    );

    #Partners
    $labels = array(
        'name' => __('Partners', 'gt3_builder'),
        'add_new_item' => __('Add New', 'gt3_builder')
    );
    register_post_type('partners', array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array(
                'slug' => 'partners',
                'with_front' => false
            ),
            'hierarchical' => true,
            'menu_position' => 8,
            'supports' => array(
                'title',
                'thumbnail'
            )
        )
    );


}

add_action('init', 'my_post_type_port');
?>