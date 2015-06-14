<?php
	$options[] = array( "name" => "Footer",
   						"sicon" => "footer.png",
						"type" => "heading");

    $options[] = array( "name" => "Footer Copyright Area",
    					"desc" => "You can change the footer copyright area.",
						"id" => SN."footer_copyright",
						"std" => "You can edit this copyright text from Theme Options > Footer",
						"type" => "textarea");

    $options[] = array( "name" => "Stats",
    					"sicon" => "stats.png",
						"type" => "heading");

    $options[] = array( "name" => "Stat Code",
    					"desc" => "You can use google analytics or other stats code in this area it will appear in the source.",
						"id" => SN."stats",
						"std" => "",
						"type" => "textarea");
?>