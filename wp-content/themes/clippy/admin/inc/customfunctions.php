<?php
/*********************************************************************************************

Set Max Content Width

*********************************************************************************************/
if ( ! isset( $content_width ) ) $content_width = 625;

/*********************************************************************************************

If 3.1 isn't installed display a notice that post type archives will not work

*********************************************************************************************/
function site5framework_archive_nag(){
    global $pagenow;
    if ( $pagenow == 'themes.php' ) {
         echo '<div class="updated"><p>';
		 _e('Portfolio archive pages will only display in WordPress 3.1 or above.  Please upgrade.', 'site5framework');
		 echo '</p></div>';
    }
}

if ( get_bloginfo('version') < 3.1 ) {
	add_action('admin_notices', 'site5framework_archive_nag');
}

/*********************************************************************************************

Add Theme Support

*********************************************************************************************/
add_theme_support( 'automatic-feed-links' );

/*********************************************************************************************

Custom Admin Login Logo

*********************************************************************************************/
function custom_login_logo() {
    if ( !of_get_option('logo')== '') {
    echo '<style type="text/css">
    #login h1 a {background-image: url('.of_get_option('logo').') !important; background-size: auto !important;  }
    </style>';
    }
}
add_action('login_head', 'custom_login_logo');


/*********************************************************************************************

Default Wordpress Gallery With PrettyPhoto

*********************************************************************************************/
add_filter( 'wp_get_attachment_link', 'site5framework_prettyphoto');

function site5framework_prettyphoto ($content) {
    $content = preg_replace("/<a/","<a class=\"prettyPhoto[mixed]\"",$content,1);
    return $content;
}


/*********************************************************************************************

Remove and Reformat Admin Footer

*********************************************************************************************/
function remove_footer_admin () {

    $theme    = of_get_theme_info();
    if($theme->parent()) {
      $theme = $theme->parent();
    }

    $themeName = $theme['Name'];
    $themeVersion = $theme['Version'];
    $themeDescription = $theme['Description'];

    echo "<b><a href=http://www.s5themes.com>$themeName - $themeVersion</a></b> - $themeDescription | <a href=www.s5themes.com/>Designed by S5themes.com</a> ";
}
add_filter('admin_footer_text', 'remove_footer_admin');



/*********************************************************************************************

Catch First Image

*********************************************************************************************/
function wp_catch_first_image($image_size = '',$return_empty = false) {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $first_img = $matches [1] [0];
      if(empty($first_img) && $return_empty == false){
            if($image_size == 's') {
                    $first_img = get_template_directory_uri()."/images/thumb_small.jpg";
            }
            else if($image_size == 'm') {
                    $first_img = get_template_directory_uri()."/images/thumb_medium.jpg";
            }
            else if($image_size == 'l') {
                    $first_img = get_template_directory_uri()."/images/thumb_large.jpg";
            }
            else {
                    $first_img = get_template_directory_uri()."/images/default.jpg";
            }
    }

    return $first_img;
}


/*********************************************************************************************

Author Related Posts

*********************************************************************************************/
function get_related_author_posts() {
    global $authordata, $post;
    $authors_posts = get_posts( array( 'author' => $authordata->ID, 'post_not_in' => array( $post->ID ), 'posts_per_page' => 10 ) );
    $output = '<ul>';
    foreach ( $authors_posts as $authors_post ) {
        $output .= '<li> <a href="' . get_permalink( $authors_post->ID ) . '">' . apply_filters( 'the_title', $authors_post->post_title, $authors_post->ID ) . '</a></li>';
    }
    $output .= '</ul>';
    return $output;
}

/*********************************************************************************************

Enable Threaded Comments

*********************************************************************************************/
function enable_threaded_comments(){
if (!is_admin()) {
     if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
          wp_enqueue_script('comment-reply');
     }
}

add_action('get_header', 'enable_threaded_comments');



function wpthemess_content_nav() {
	global $wp_query;
	if (  $wp_query->max_num_pages > 1 ) :
		if (function_exists('wp_pagenavi') ) {
			wp_pagenavi();
		} else { ?>
        	<nav id="nav-below">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'site5framework' ); ?></h1>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'site5framework' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'site5framework' ) ); ?></div>
			</nav><!-- #nav-below -->
    	<?php }
	endif;
}

/*********************************************************************************************

WP MU IMAGE SUPPORT

*********************************************************************************************/
function get_image_url() {
    $theImageSrc = wp_get_attachment_url(get_post_thumbnail_id($post_id));
    global $blog_id;
    if (isset($blog_id) && $blog_id > 0) {
        $imageParts = explode('/files/', $theImageSrc);
        if (isset($imageParts[1])) {
            $theImageSrc = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
        }
    }
    echo $theImageSrc;
}

/*********************************************************************************************

WP MU CUSTOM META IMAGE SUPPORT

*********************************************************************************************/
function get_image_path($cutommeta_image) {
$theImageSrc1 = $cutommeta_image;
global $blog_id;
if (isset($blog_id) && $blog_id > 0) {
    $imageParts = explode('/files/', $theImageSrc1);
    if (isset($imageParts[1])) {
        $theImageSrc1 = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
    }
}
return $theImageSrc1;
}


/*********************************************************************************************

COMMENT LAYOUT

*********************************************************************************************/
function site5framework_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class(); ?>>
    <article id="comment-<?php comment_ID(); ?>">
      <header class="comment-author vcard">
        <?php echo get_avatar($comment,$size='50',$default='<path_to_url>' ); ?>
        <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>  
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('F jS, Y'); ?> </a></time>
        <?php edit_comment_link(__('(Edit)'),'  ','') ?>
      </header>
      
      <section class="comment_content">
        <?php comment_text() ?>
      </section>
      <?php if ($comment->comment_approved == '0') : ?>
      <em style="display:block;margin-left:40px"><?php _e('Your comment is awaiting moderation.','site5framework') ?></em>
      <?php endif; ?>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
    <!-- </li> is added by wordpress automatically -->
<?php
} // don't remove this bracket!



/*******************************
 Video player
********************************/

function player_video($postid){

$m4v = get_post_meta($postid, SN.'video_post_m4v', $single = true);
$ogv = get_post_meta($postid, SN.'video_post_ogv', $single = true);
$poster = get_post_meta($postid, SN.'video_post_poster',true);
?>
<script type="text/javascript">
(function($) {
  $(document).ready(function($){
    if($().jPlayer) {
      $("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
        ready: function () {
          $(this).jPlayer("setMedia", {
            <?php if($m4v != '') : ?>
            m4v: "<?php echo $m4v; ?>",
            <?php endif; ?>
            <?php if($ogv != '') : ?>
            ogv: "<?php echo $ogv; ?>",
            <?php endif; ?>
            end: ""
          });
           $("article").fitVids();
        },
        ended: function () {

        },
        play: function () {
           $(this).jPlayer("pauseOthers");
        },
       size: {
          width: "320",
          height: "240",
          cssClass: "jp-video-rP"
        },
        swfPath: "<?php echo get_template_directory_uri(); ?>/lib/jplayer",
        cssSelectorAncestor: "#jp_interface_<?php echo $postid; ?>",
        supplied: "<?php if($m4v != '') : ?>m4v, <?php endif; ?><?php if($ogv != '') : ?>ogv, <?php endif; ?> all",
        solution: "html,flash"
      });
    }
  });
})(jQuery);
</script>

<div id="jquery_jplayer_<?php global $post; echo $postid; ?>" class="jp-jplayer jp-jplayer-video"></div>
  <div class="jp-video-container">
      <div class="jp-video">
           <div class="jp-type-single">
               <div id="jp_interface_<?php echo $postid; ?>" class="jp-interface">
                   <ul class="jp-controls">
                    <li><div class="seperator-first"></div></li>
                       <li><div class="seperator-second"></div></li>
                       <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                       <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                       <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                       <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                   </ul>
                   <div class="jp-progress-container">
                       <div class="jp-progress">
                           <div class="jp-seek-bar">
                               <div class="jp-play-bar"></div>
                           </div>
                       </div>
                   </div>
                   <div class="jp-volume-bar-container">
                       <div class="jp-volume-bar">
                           <div class="jp-volume-bar-value"></div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
</div>
<?php }

/*******************************
 Audio player
********************************/
function player_audio($postid){

$mp3 = get_post_meta($postid, SN.'audio_post_mp3', $single = true);
$ogg = get_post_meta($postid, SN.'audio_post_ogg', $single = true);
$poster = get_post_meta($postid, SN.'audio_post_poster',true);
?>
<script type="text/javascript">
(function($) {
  $(document).ready(function($){

    if($().jPlayer) {
      $("#jquery_jplayer_<?php echo $postid; ?>").jPlayer({
        ready: function () {
          $(this).jPlayer("setMedia", {
            <?php if($mp3 != '') : ?>
            mp3: "<?php echo $mp3; ?>",
            <?php endif; ?>
            <?php if($ogg != '') : ?>
            oga: "<?php echo $ogg; ?>",
            <?php endif; ?>
            end: ""
          });
        },
        size: {
          width: "100%",
          height: "auto",
          cssClass: "jp-video-rP"
        },
        swfPath: "<?php echo get_template_directory_uri(); ?>/lib/jplayer",
        cssSelectorAncestor: "#jp_interface_<?php echo $postid; ?>",
        supplied: "<?php if($ogg != '') : ?>oga,<?php endif; ?><?php if($mp3 != '') : ?>mp3, <?php endif; ?> all"
      });
    }
  });
})(jQuery);
</script>

<div id="jquery_jplayer_<?php echo $postid; ?>" class="jp-jplayer jp-jplayer-audio"></div>
  <div class="jp-audio-container">
      <div class="jp-audio">
           <div class="jp-type-single">
               <div id="jp_interface_<?php echo $postid; ?>" class="jp-interface">
                   <ul class="jp-controls">
                    <li><div class="seperator-first"></div></li>
                       <li><div class="seperator-second"></div></li>
                       <li><a href="#" class="jp-play" tabindex="1">play</a></li>
                       <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
                       <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
                       <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
                   </ul>
                   <div class="jp-progress-container">
                       <div class="jp-progress">
                           <div class="jp-seek-bar">
                               <div class="jp-play-bar"></div>
                           </div>
                       </div>
                   </div>
                   <div class="jp-volume-bar-container">
                       <div class="jp-volume-bar">
                           <div class="jp-volume-bar-value"></div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
</div>
<?php


 }?>