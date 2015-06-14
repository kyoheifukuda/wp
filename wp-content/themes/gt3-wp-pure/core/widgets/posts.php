<?php
class posts extends WP_Widget
{

    function posts()
    {
        parent::__construct(false, 'Posts (current theme)');
    }

    function widget($args, $instance)
    {
        extract($args);

        echo $before_widget;
        echo $before_title;
        echo $instance['widget_title'];
        echo $after_title;


        $args = array(
            'numberposts' => $instance['posts_widget_number'],
            'offset' => 0,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish',
            'suppress_filters' => true);

        $recent_posts = wp_get_recent_posts($args);
        $compilepopular = '';

        foreach ($recent_posts as $recent) {
            $compilepopular .= '
            <li>
                <div class="recent_posts_content">
                    <a class="post_title" href="' . get_permalink($recent["ID"]) . '">' . esc_attr($recent["post_title"]) . '</a>
                    <div class="meta">
                        <span>' . mysql2date("M d, Y", $recent["post_date"]) . '</span>
                        <span class="del">/</span>
                        <a class="read_more" href="' . get_permalink($recent["ID"]) . '">Read more!</a>
                    </div>
                </div>
			</li>
		    ';
        }

        echo '
			<ul class="recent_posts">
				' . $compilepopular . '
			</ul>
		';

        #END OUTPUT

        echo $after_widget;
    }


    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['widget_title'] = strip_tags($new_instance['widget_title']);
        $instance['posts_widget_number'] = strip_tags($new_instance['posts_widget_number']);

        return $instance;
    }

    function form($instance)
    {
        $defaultValues = array(
            'widget_title' => 'Posts',
            'posts_widget_number' => '3'
        );
        $instance = wp_parse_args((array)$instance, $defaultValues);
        ?>
        <table class="fullwidth">
            <tr>
                <td>Title:</td>
                <td><input type='text' class="fullwidth" name='<?php echo $this->get_field_name('widget_title'); ?>'
                           value='<?php echo $instance['widget_title']; ?>'/></td>
            </tr>
            <tr>
                <td>Number:</td>
                <td><input type='text' class="fullwidth"
                           name='<?php echo $this->get_field_name('posts_widget_number'); ?>'
                           value='<?php echo $instance['posts_widget_number']; ?>'/></td>
            </tr>
        </table>
    <?php
    }
}

function posts_register_widgets()
{
    register_widget('posts');
}

add_action('widgets_init', 'posts_register_widgets');

?>