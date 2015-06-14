<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div class="container clearfix">
		<?php do_action( 'before' ); ?>
		<div id="navigation" class="site-nav">
			<div class="site-nav-inner">
				<div class="container">
					<header id="masthead" class="site-header" role="banner">
						<?php dw_minion_logo(); ?>
					</header>
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
        <?php do_action( 'after_navigation' ); ?>
		<div id="main" class="site-main">
			<div class="site-main-inner">
				<div class="container clearfix">
					<?php if ( is_active_sidebar( 'top-sidebar' ) ) do_action( 'dw_minion_top_sidebar' ); ?>