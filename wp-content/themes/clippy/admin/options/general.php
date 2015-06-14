<?php
$options[] = array("name" => "General",
			 "sicon" => "advancedsettings.png",
                   "type" => "heading");


$options[] = array("name" => "Your Logo",
                  "desc" => "You can use your own logo. Click to 'Upload' button and upload your own logo.",
                  "id" => SN."logo",
                  "std" => "",
                  "type" => "upload");

$options[] = array("name" => "Text as Logo",
                  "desc" => "If you don't upload your own company logo, this text will show up in it's place.",
                  "id" => SN."logo_text",
                  "std" => "Clippy",
                  "type" => "text");

$options[] = array( "name" => "Custom Favicon",
                  "desc" => "You can use your own custom favicon. Click to 'Upload Image' button and upload your own favicon.",
                  "id" => SN."favicon",
                  "std" => "",
                  "type" => "upload");

?>