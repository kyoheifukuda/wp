<?php
/*********************************************************************************************

Register Global Sidebars

*********************************************************************************************/
function site5framework_widgets_init() {
	
	register_sidebar( array (
    'name' => __( 'Sidebar Widgets', 'site5framework' ),
    'id' => 'primary',
    'before_widget' => '<div id="%1$s" class="widget_sidebar %2$s" ><div class="widget_inner">',
    'after_widget' => "</div></div>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
	) );

    register_sidebar( array (
    'name' => __( 'Footer Widgets', 'site5framework' ),
    'id' => 'footer',
    'before_widget' => '<div id="%1$s" class="widget_footer %2$s" ><div class="widget_inner">',
    'after_widget' => "</div></div>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    ) );

}

add_action( 'init', 'site5framework_widgets_init' );



/*********************************************************************************************

Register Twitter Widget

*********************************************************************************************/
class site5framework_twitter_widget extends WP_Widget {
    function __construct() {
        parent::__construct(false, $name = 'Site5 Framework Twitter Widget', array( 'description' => 'Site5 Framework Twitter profile widget for your site.' ) );
    }

    /*
     * Displays the widget form in the admin panel
     */
    function form( $instance ) {
    	$widget_title = esc_attr( $instance['widget_title'] );
        $screen_name = esc_attr( $instance['screen_name'] );
        $num_tweets = esc_attr( $instance['num_tweets'] );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e('Widget Title:', 'site5framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" type="text" value="<?php echo $widget_title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'screen_name' ); ?>"><?php _e('Screen name:', 'site5framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'screen_name' ); ?>" name="<?php echo $this->get_field_name( 'screen_name' ); ?>" type="text" value="<?php echo $screen_name; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'num_tweets' ); ?>"><?php _e('Number of Tweets:', 'site5framework') ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'num_tweets' ); ?>" name="<?php echo $this->get_field_name( 'num_tweets' ); ?>" type="text" value="<?php echo $num_tweets; ?>" />
        </p>

<?php
    }
/*
 * Renders the widget in the sidebar
 */
function widget( $args, $instance ) {
echo $args['before_widget'];
?>


        <!-- start twitter widget -->
         <?php echo $args['before_title']; ?><?php echo $instance['widget_title']; ?><?php echo $args['after_title']; ?>

     	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/lib/tweets/jquery.jtweets-1.2.1.js"></script>

        <div id="jTweets"> </div>
        <script type="text/javascript">
			$j = jQuery.noConflict();
	        $j('#jTweets').jTweetsAnywhere({
	        username: '<?php echo $instance['screen_name']; ?>',
	        count: <?php echo $instance['num_tweets']; ?>,
	        showTweetFeed: {
			showInReplyTo: false,
	        paging: { mode: 'none' }
	        }
	        });
        </script>
        <!-- end twitter widget -->
		<a class="twitter-action" href="http://twitter.com/<?php echo $instance['screen_name']; ?>"><?php _e('Follow Us on Twitter! ', 'site5framework') ?> &raquo; </a>


        <?php
        echo $args['after_widget'];
    }
};

// Initialize the widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "site5framework_twitter_widget" );' ) );
?>