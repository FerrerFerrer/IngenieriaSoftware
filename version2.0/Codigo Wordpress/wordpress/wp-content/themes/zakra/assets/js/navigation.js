/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 *
 * @package Zakra
 */

(
	function () {
		var container, menu, links, i, len;

		container = document.getElementById( 'site-navigation' );

		if ( ! container ) {
			return;
		}

		menu = container.getElementsByTagName( 'ul' )[0];

		menu.setAttribute( 'aria-expanded', 'false' );

		if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
			menu.className += ' nav-menu';
		}

		// Get all the link elements within the menu.
		links = menu.getElementsByTagName( 'a' );

		// Each time a menu link is focused or blurred, toggle focus.
		for ( i = 0, len = links.length; i < len; i++ ) {
			links[i].addEventListener( 'focus', toggleFocus, true );
			links[i].addEventListener( 'blur', toggleFocus, true );
		}

		/**
		 * Sets or removes .focus class on an element.
		 */
		function toggleFocus() {
			var self = this;

			// Move up through the ancestors of the current link until we hit .nav-menu.
			while ( - 1 === self.className.indexOf( 'nav-menu' ) ) {

				// On li elements toggle the class .focus.
				if ( 'li' === self.tagName.toLowerCase() ) {
					if ( - 1 !== self.className.indexOf( 'focus' ) ) {
						self.className = self.className.replace( ' focus', '' );
					} else {
						self.className += ' focus';
					}
				}

				self = self.parentElement;
			}
		}

		/**
		 * Toggles `focus` class to allow submenu access on tablets.
		 */
		(
			function ( container ) {
				var touchStartFn, i,
				    parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

				if ( 'ontouchstart' in window ) {
					touchStartFn = function ( e ) {
						var i,
						    menuItem = this.parentNode;

						if ( ! menuItem.classList.contains( 'focus' ) ) {
							e.preventDefault();

							for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
								if ( menuItem === menuItem.parentNode.children[i] ) {
									continue;
								}

								menuItem.parentNode.children[i].classList.remove( 'focus' );
							}
							menuItem.classList.add( 'focus' );
						} else {
							menuItem.classList.remove( 'focus' );
						}
					};

					for ( i = 0; i < parentLink.length; ++i ) {
						parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
					}
				}
			}( container )
		);
	}()
);


/**
 * Fixes menu out of viewport
 */
(
	function () {
		var i;

		var elWithChildren = document.querySelectorAll( '.tg-primary-menu li.menu-item-has-children, .tg-primary-menu li.page_item_has_children' ),
		    elCount        = elWithChildren.length;

		/**
		 * @see https://stackoverflow.com/questions/123999/how-can-i-tell-if-a-dom-element-is-visible-in-the-current-viewport/7557433#7557433
		 */
		function isElementInViewport( el ) {
			var rect = el.getBoundingClientRect();

			return (
				rect.left >= 0 &&
				rect.right <= (	window.innerWidth || document.documentElement.clientWidth )
			);
		}

		// Loop through li having sub menu.
		for ( i = 0; i < elCount; i++ ) {

			// On mouse enter.
			elWithChildren[i].addEventListener( 'mouseenter', function ( ev ) {
				var li = ev.currentTarget;

				if ( li ) {

					var subMenu = li.querySelectorAll( '.sub-menu, .children' )[0];

					if ( subMenu ) {
						if ( ! isElementInViewport( subMenu ) ) {
							subMenu.classList.add( 'tg-edge' );
						}
					}
				}
			}, false );

			// On mouse leave.
			elWithChildren[i].addEventListener( 'mouseleave', function ( ev ) {
				var li = ev.currentTarget;

				if ( li ) {
					var sub = li.querySelectorAll( '.sub-menu, .children' )[0];

					sub.classList.remove( 'tg-edge' );

					if ( sub.classList.contains( 'tg-edge' ) ) {
						sub.classList.remove( 'tg-edge' );
					}
				}
			}, false );
		} // End: for ( i in elWithChildren ) {

	}
)();

/**
 * Keep menu items on one line.
 */
(
	function () {

		// Get required elements.
		var header, mainWrapper, branding, navigation, mainWidth, brandWidth, navWidth, isExtra, more;

		navigation = document.getElementById('site-navigation');

		if ( null === navigation ) {
			return;
		}

		header      = document.querySelector('.tg-site-header');
		mainWrapper = header.querySelector('.tg-header-container');
		branding    = header.querySelector('.site-branding');
		mainWidth   = mainWrapper.offsetWidth;
		brandWidth  = ( null !== branding ) ? branding.offsetWidth : 0;
		navWidth    = ( null !== navigation ) ? navigation.offsetWidth : 0;
		isExtra     = (brandWidth + navWidth) > mainWidth;
		more        = navigation.getElementsByClassName('tg-menu-extras-wrap')[0];

		// Return if no excess menu items.
		if ( ! navigation.classList.contains( 'tg-extra-menus' ) ) {
			return;
		}

		// Calculate the dimension of an element with margin, padding and content.
		var dimension = function ( el ) {
			return parseInt( document.defaultView.getComputedStyle( el, '' ).getPropertyValue( 'width' ) ) + parseInt( document.defaultView.getComputedStyle( el, '' ).getPropertyValue( 'margin-left' ) ) + parseInt( document.defaultView.getComputedStyle( el, '' ).getPropertyValue( 'padding-left' ) ) + parseInt( document.defaultView.getComputedStyle( el, '' ).getPropertyValue( 'padding-right' ) ) + parseInt( document.defaultView.getComputedStyle( el, '' ).getPropertyValue( 'margin-right' ) );
		};

		if ( ! isExtra ) {
			more.parentNode.removeChild( more );
		} else {
			var widthToBe, search, cart, button, button2, searchWidth, cartWidth, buttonWidth, moreWidth;

			widthToBe   = mainWidth - brandWidth;
			search      = navigation.getElementsByClassName( 'tg-menu-item-search' )[0];
			cart        = navigation.getElementsByClassName( 'tg-menu-item-cart' )[0];
			button      = navigation.getElementsByClassName( 'tg-header-button-wrap' )[0];
			button2     = navigation.getElementsByClassName( 'tg-header-button-wrap' )[1];
			searchWidth = search ? dimension( search ) : 0;
			cartWidth   = cart ? dimension( cart ) : 0;
			buttonWidth = button ? dimension( button ) : 0;
			buttonWidth += button2 ? dimension( button2 ) : 0;
			moreWidth   = more ? dimension( more ) : 0;
			newNavWidth = widthToBe - ( searchWidth + cartWidth + buttonWidth + moreWidth );

			navigation.style.visibility = 'none';
			navigation.style.width      = newNavWidth + 'px';

			// Returns first children of a node.
			function getChildNodes( node ) {
				var children = [];

				for ( var child in node.childNodes ) {
					if ( node.childNodes.hasOwnProperty( child ) && 1 === node.childNodes[child].nodeType ) {
						children.push( node.childNodes[child] );
					}
				}
				return children;
			}

			var navUl = navigation.getElementsByClassName( 'nav-menu' )[0],
			    navLi = getChildNodes( navUl ); // Get lis.

			function offset( el ) {
				var rect       = el.getBoundingClientRect(),
				    scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
				    scrollTop  = window.pageYOffset || document.documentElement.scrollTop;

				return {top: rect.top + scrollTop, left: rect.left + scrollLeft}
			}

			var extraLi = [];

			for ( var liCount = 0; liCount < navLi.length; liCount ++ ) {
				var initialPos, li, posTop;

				li     = navLi[liCount];
				posTop = offset( li ).top;

				if ( 0 === liCount ) {
					initialPos = posTop;
				}

				if ( posTop > initialPos ) {
					if ( ! li.classList.contains( 'tg-menu-item-search' ) && ! li.classList.contains( 'tg-menu-item-cart' ) && ! li.classList.contains( 'tg-header-button-wrap' ) && ! li.classList.contains( 'tg-menu-extras-wrap' ) ) {
						extraLi.push( li );
					}
				}
			}

			var newNavWidth = newNavWidth + ( searchWidth + cartWidth + buttonWidth + moreWidth ) - 2,
			    extraWrap   = document.getElementById( 'tg-menu-extras' );

			if ( header.classList.contains( 'tg-site-header--left' ) || header.classList.contains( 'tg-site-header--right' ) ) {
				navigation.style.width = newNavWidth + 'px';
			} else {
				navigation.style.width = '100%';
			}

			if ( null !== extraWrap ) {
				extraLi.forEach(
					function ( item ) {
						extraWrap.appendChild( item );
					}
				);
			}

		}

	}()
);

/**
 * Close mobile menu on clicking menu items.
 */
(
	function () {
		var mobMenuItems      = document.querySelectorAll( '#mobile-navigation li a' ),
		    toggleButton      = document.querySelector( '.tg-mobile-toggle' ),
		    mobMenuItemsCount = mobMenuItems.length,
		    item;

		for ( var i = 0; i < mobMenuItemsCount; i++ ) {
			item = mobMenuItems[i];

			item.addEventListener(
				'click',
				function () {
					toggleButton.click();
				}
			);
		}
	}()
);


