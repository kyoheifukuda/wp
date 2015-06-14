<?php

require_once("meta-box-class.php");

if (is_admin()){

	//All meta boxes prefix, inherited from theme Shortname
	$prefix = SN;

	$configDefaults = array(
		'pages' => array('post'),      		 // post types, accept custom post types as well, default is array('post'); optional
		'context' => 'normal',            		// where the meta box appear: normal (default), advanced, side; optional
		'priority' => 'high',            		// order of meta box: high (default), low; optional
		'fields' => array(),            		// list of meta fields (can be added by field arrays)
		'local_images' => true,          		// Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => true          		//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false)
		);



	//Post Formats Meta Boxes

	//ASIDE
	//$post_aside_meta =  new AT_Meta_Box(array_merge($configDefaults, array('id' => SN.'post_format_aside', 'title' => 'Aside')));
	//$post_aside_meta->addTextarea ($prefix.'aside_post',array('name'=> 'The Aside ','desc' => 'Input your aside.'));
	//$post_aside_meta->Finish();

	//GALLERY
	$post_gallery_meta = new AT_Meta_Box(array_merge($configDefaults, array('id' => SN.'post_format_gallery', 'title' => 'Gallery')));
	$repeater_fields[] = $post_gallery_meta->addText ($prefix.'gallery_post_title',array('name'=> 'Title','desc' => 'Enter the title for the gallery image.'), true);
	$repeater_fields[] = $post_gallery_meta->addImage($prefix.'gallery_post_image', array('name'=> 'Gallery Image ','desc' => 'Click to upload image to this gallery post.'), true);
	$post_gallery_meta->addRepeaterBlock($prefix.'gallery_post_images_', array('inline' => true, 'name' => 'Gallery Images','fields' => $repeater_fields));
	$post_gallery_meta->Finish();
	
	
	//IMAGE
	$post_image_meta =  new AT_Meta_Box(array_merge($configDefaults, array('id' => SN.'post_format_image', 'title' => 'Image')));
	$post_image_meta->addImage($prefix.'image_post_upload',array('name'=> 'Image Post ','desc' => 'Click to upload image to this post.'));
	$post_image_meta->Finish();


	//LINK
	$post_link_meta =  new AT_Meta_Box(array_merge($configDefaults, array('id' => SN.'post_format_link', 'title' => 'Link')));
	$post_link_meta->addText ($prefix.'link_post_url',array('name'=> 'Link URL ','desc' => 'Enter the URL to be used for this Link post. for example: http://www.site5.com'));
	$post_link_meta->addText ($prefix.'link_post_description',array('name'=> 'Link Description ','desc' => 'Enter the description to be used for this link. for example: Site5 WordPress Hosting'));
	$post_link_meta->Finish();


	//QUOTE
	$post_quote_meta =  new AT_Meta_Box(array_merge($configDefaults, array('id' => SN.'post_format_quote', 'title' => 'Quote')));
	$post_quote_meta->addText ($prefix.'quote_post',array('name'=> 'The Quote ','desc' => 'Input your quote.'));
	$post_quote_meta->addText ($prefix.'quote_author',array('name'=> 'Quote Author ','desc' => 'Enter the quote author name.'));
	$post_quote_meta->Finish();


	//VIDEO

	$post_video_meta =  new AT_Meta_Box(array_merge($configDefaults, array('id' => SN.'post_format_video', 'title' => 'Video')));
	//$post_video_meta->addText ($prefix.'video_post_m4v',array('name'=> 'M4V File URL ','desc' => 'Enter the URL to the .m4v video file url.'));
	//$post_video_meta->addText ($prefix.'video_post_ogv',array('name'=> 'OGV File URL ','desc' => 'Enter the URL to the .ogv video file url.'));
	//$post_video_meta->addImage($prefix.'video_post_poster',array('name'=> 'Video Poster Image ','desc' => 'The preview image. The preview image should be min 500px wide.'));
	$post_video_meta->addText ($prefix.'video_post_embed',array('name'=> 'Embedded Video Code ','desc' => 'If you are using something like Youtube or Vimeo, paste the embed code here'));
	$post_video_meta->Finish();


	//AUDIO
	$post_audio_meta =  new AT_Meta_Box(array_merge($configDefaults, array('id' => SN.'post_format_audio', 'title' => 'Audio')));
	$post_audio_meta->addText ($prefix.'audio_post_mp3',array('name'=> 'MP3 File URL ','desc' => 'Enter the URL to the .mp3 audio file url.'));
	$post_audio_meta->addText ($prefix.'audio_post_ogg',array('name'=> 'OGG File URL ','desc' => 'Enter the URL to the .oga, .ogg audio file url'));
	//$post_audio_meta->addImage($prefix.'audio_post_poster', array('name'=> 'Audio Poster Image ','desc' => 'The preview image for this audio track. Image width should be min 500px.'));
	$post_audio_meta->Finish();

	

}