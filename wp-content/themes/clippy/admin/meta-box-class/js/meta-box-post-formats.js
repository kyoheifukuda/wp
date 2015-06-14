jQuery(function($) {


	function hidePostFormatMetaboxes() {
		//hide all post formats metaboxes.
		$('div[id*="post_format"]').hide();
	}

	function showSelectedPostFormatMetabox(elem) {
		if(elem) {
			post_format =$(this).val();
		} else {
			post_format = $('input[id*="post-format"]:checked').val();
		}
		//show post format metabox based on checked input
		$('div[id*="post_format_'+post_format+'"]').show();

	}
	$(document).ready(function(){


		
		hidePostFormatMetaboxes();
		showSelectedPostFormatMetabox();


		$('input[id*="post-format"]').click( function() {
			hidePostFormatMetaboxes();
			showSelectedPostFormatMetabox();
		});

	});


});