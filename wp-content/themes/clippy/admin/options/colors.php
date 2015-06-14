<?php
    $options[] = array( "name" => "Color Settings",
    					"sicon" => "colors.png",
						"type" => "heading");

	$options[] = array( "name" => "CUSTOMIZE MAIN COLORS",
						"desc" => "You can set main colors below. Leave the fields blank to restore the defaults",
						"type" => "info");

	$options[] = array( "name" => "Main Headings Color (H2,H3...)",
						"id" => SN."main_h_color",
						"std" => "#A1B1B3",
						"type" => "color");

?>