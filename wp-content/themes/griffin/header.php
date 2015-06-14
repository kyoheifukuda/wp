<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php wp_title('|', true, 'right'); ?></title>
    <meta charset="<?php bloginfo('charset'); ?>" />           
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    <link rel="profile" href="http://gmpg.org/xfn/11" />        
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header style="background-image: url('<?php header_image(); ?>');">
    <a id="hamburger" href="#"><span></span><span></span><span></span></a>    
    <?php if (get_theme_mod('griffin_logo_setting')): ?>
        <a id="header-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src='<?php echo esc_url(get_theme_mod('griffin_logo_setting')); ?>' alt='<?php echo esc_attr(get_bloginfo('name', 'display')); ?>'></a>
    <?php else: ?>
        <a id="header-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
    <?php endif; ?> 
    <p id="header-description"><?php bloginfo('description'); ?></p> 
    <?php $header_img = get_header_image(); ?> 
    <?php if ($header_img) : ?>     
	  
    <?php endif; ?>   
     <?php
        $location = 'primary';
        if (has_nav_menu($location)) :
    ?>
    <nav id="primary-menu">         
        <?php wp_nav_menu(array('theme_location' => 'primary','depth' => 2,'container' => false)); ?>                    
    </nav>
    <?php endif; ?>  
</header>
   
<div id="content-holder" class="container">
