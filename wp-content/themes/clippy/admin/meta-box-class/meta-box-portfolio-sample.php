<?php

require_once("meta-box-class.php");

if (is_admin()){

	//All meta boxes prefix, inherited from theme Shortname
	$prefix = SN;


	//Meta box config
	$config = array(
	'id' => 'post_format_info',          			// meta box id, unique per meta box
	'title' => 'Portfolio Info',          		// meta box title
	'pages' => array('portfolio'),      		// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',            		// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',            		// order of meta box: high (default), low; optional
	'fields' => array(),            		// list of meta fields (can be added by field arrays)
	'local_images' => true,          		// Use local or hosted images (meta box images for add/remove)
	'use_with_theme' => true          		//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);


	//Initiate Meta box
	$my_meta =  new AT_Meta_Box($config);


	
	$my_meta->addText ($prefix.'portfolio_client',array('name'=> 'Client ','desc' => 'Name of the client'));

    //Finish Meta box declaration
	$my_meta->Finish();



}