(function($) {
    "use strict"; 
    $(function() { 
    	// masonry
    	$(window).load(function() {
		    if($('body').hasClass('blog') || $('body').hasClass('search-results') || $('body').hasClass('archive')) {   	
				$('#teaser-holder').masonry({				
					itemSelector: '.teaser'
				});
				$('.spinner').hide();
				$('#teaser-holder').css('visibility','visible');				
				$('#teaser-holder').masonry('bindResize');
			}
		});
		// primary menu
		dropDown();	
		$(window).resize(function() {
			dropDown();
		});						
		function dropDown() {
			var winWidth = $(window).width();
			if (winWidth > 768) {
				$('#primary-menu .menu-item-has-children').hover(
					function() {
				    	$(this).find('ul').fadeIn('fast');
					}, function() {
				    	$(this).find('ul').hide();
				  }
				);	
			}	
		}
		// mobile nav
		$('#hamburger').click(function() {
		  $('header nav').toggle();
		});	
		// misc
		$('.wp-caption').removeAttr('style');	
		$('li.pingback:last').css('margin-bottom','45px');
 	}); 	
}(jQuery));