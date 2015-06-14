/**
 * Functionality specific to Bushwick.
 *
 * Provides helper functions to enhance the theme experience.
 */

( function( $ ) {

	/**
	 * Masonry.
	 */
	$( window ).load( function() {

		var widgets_area = $( '.widget-container' );

		$( '.widget-handle' ).on( 'click.bushwick', function( event ) {
			event.preventDefault();
			$( this ).toggleClass( 'open' );
			if( $( this ).hasClass( 'open' ) ) {
				$( '#secondary' ).slideDown( 300 );
				// Trigger resize to make sure widgets fit prefectly.
				$( this ).trigger( 'resize' );
				// Masonry blocks
				widgets_area.imagesLoaded( function() {
					widgets_area.masonry( {
						itemSelector: '.widget',
						gutterWidth: 0,
						transitionDuration: 0,
						isRTL: $( 'body' ).is( '.rtl' )
					} );
				} );
			} else {
				$( '#secondary' ).slideUp( 300 );
			}
		} );

		$( '#404-widgets' ).masonry( {
			itemSelector: '.widget',
			gutterWidth: 0,
			transitionDuration: 0,
			isRTL: $( 'body' ).is( '.rtl' )
		} );

		$( window ).resize( function () {

			// Force layout correction after 1500 milliseconds
			setTimeout( function () {
				widgets_area.masonry();
			}, 1500 );

		} );

	} );

	/**
	 * Wrap entry title if too many characters.
	 */
	$( window ).load( function() {
		var count = $( '.single .entry-title' ).text().length;
		if ( count > 150 ) {
			$( '.single .entry-title' ).wrapInner( '<small />' );
		}
	} );

	/**
	 * Enables menu toggle for small screens.
	 */
	( function() {
		var container, button, menu;

		container = document.getElementById( 'site-navigation' );
		if ( ! container )
			return;

		button = container.getElementsByTagName( 'h1' )[0];
		if ( 'undefined' === typeof button )
			return;

		menu = container.getElementsByTagName( 'ul' )[0];

		// Hide menu toggle button if menu is empty and return early.
		if ( 'undefined' === typeof menu ) {
			button.style.display = 'none';
			return;
		}

		if ( -1 === menu.className.indexOf( 'nav-menu' ) )
			menu.className += ' nav-menu';

		button.onclick = function() {
			if ( -1 !== container.className.indexOf( 'toggled' ) )
				container.className = container.className.replace( ' toggled', '' );
			else
				container.className += ' toggled';
		};
	} )();

	/**
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	$( window ).on( 'hashchange.bushwick', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) )
				element.tabIndex = -1;

			element.focus();
		}
	} );

	/**
	 * Adds a class .home-link class to the navigation list item containing the home link.
	 */
	$( '.navigation-main a[href="' + bushwick_functions_vars.home_url + '"]' ).closest( 'li').addClass( 'home-link' );

} )( jQuery );
