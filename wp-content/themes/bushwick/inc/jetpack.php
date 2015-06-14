<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Bushwick
 */

function bushwick_jetpack_setup() {
	/**
	 * Add theme support for Infinite Scroll.
	 * See: http://jetpack.me/support/infinite-scroll/
	 */
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'primary',
		'render'    => 'bushwick_render_content',
	) );

	/**
	 * Add theme support for Responsive Videos.
	 */
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'bushwick_jetpack_setup' );

function bushwick_render_content() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'content', 'preview' );
	}
}
