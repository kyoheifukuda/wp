<?php
    $options[] = array( "name" => "Typography",
    					"sicon" => "font.png",
						"type" => "heading");
						
	$options[] = array( "name" => "Custom Headings Font",
					"desc" => "This theme uses Google Web Font for headings. You can change it by entering the font details in the fields below.",
					"id" => SN."customfontsinfo",
					"std" => "",
					"type" => "info");
						
	$options[] = array( "name" => "Enable Google Font",
						"desc" => "By unchecking this the theme will use default font for headings, Arial.",
						"id" => SN."customtypography",
						"std" => "1",
						"type" => "checkbox");
						
    $options[] = array( "name" => "Headings Google Font Link",
                        "desc" => "Ex: &lt;link href='http://fonts.googleapis.com/css?family=Rancho' rel='stylesheet' type='text/css'&gt;",
                        "id" => SN."headingfontlink",
                        "std" => "&lt;link href='http://fonts.googleapis.com/css?family=Rancho' rel='stylesheet' type='text/css'&gt;",
                        "type" => "textarea");

    $options[] = array( "name" => "Headings Google Font Family",
                        "desc" => "Ex: font-family: 'Rancho', serif",
                        "id" => SN."headingfontface",
                        "std" => "font-family: 'Rancho', serif",
                        "type" => "text");	

    $options[] = array( "name" => "Body Google Font Link",
                        "desc" => "Ex: &lt;link href='http://fonts.googleapis.com/css?family=Sanchez' rel='stylesheet' type='text/css'&gt;",
                        "id" => SN."bodyfontlink",
                        "std" => "&lt;link href='http://fonts.googleapis.com/css?family=Sanchez' rel='stylesheet' type='text/css'&gt;",
                        "type" => "textarea");

    $options[] = array( "name" => "Body Google Font Family",
                        "desc" => "Ex: font-family: 'Sanchez', serif",
                        "id" => SN."bodyfontface",
                        "std" => "font-family: 'Sanchez', serif",
                        "type" => "text");				

?>