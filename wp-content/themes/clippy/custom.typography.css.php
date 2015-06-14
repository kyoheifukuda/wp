<style type="text/css" media="all">
	
	/* Body Font face */
	body {
		<?php if(of_get_option('bodyfontlink') != '' and of_get_option('bodyfontface') != '') { ?>
   		<?php echo of_get_option('bodyfontface');?>
   		<?php } ?>;
    }

	/* Headings Font face */
	h1,h2,
	.main article h1,
	.widget_footer .widget-title,
	h2.post-title,
	.site-title {
		<?php if(of_get_option('headingfontlink') != '' and of_get_option('headingfontface') != '') { ?>
   		<?php echo of_get_option('headingfontface');?>
   		<?php } ?>;
    }

   	/* Headings Font colors */
	h1,h2,h3,h4,h5,h6  {
		<?php if(of_get_option('main_h_color') !='') { ?>color:<?php echo of_get_option('main_h_color')?><?php } ?>;
	}

	
</style>