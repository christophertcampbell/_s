/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var body, container, button, menu, links, i, len;

	var expandableSubMenuConfig = {
		classOnExpanded: "expanded",
		classOnCollapseed: "collapsed"
	}

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}
	
	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}
	
	body = document.getElementsByTagName( 'body' )[0];
	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			collapseMenu();
		} else {
			expandMenu();
		}
	};
	
	function collapseMenu() {
		container.className = container.className.replace( ' toggled', '' );
		body.className = body.className.replace( ' menu-open', '' );
		button.setAttribute( 'aria-expanded', 'false' );
		menu.setAttribute( 'aria-expanded', 'false' );
		restoreScrollPosition();
	}
	
	function expandMenu() {
		recordScrollPosition();
		container.className += ' toggled';
		body.className += ' menu-open';
		button.setAttribute( 'aria-expanded', 'true' );
		menu.setAttribute( 'aria-expanded', 'true' );
	}

	var scrollPositionX;
	var scrollPositionY;

	/* Record the scroll position in case the theme hides page elements when the menu is open */
	/* Otherwise, hiding page elements (ie: display: none on <main> or <footer>) causes scroll position to be lost */
	function recordScrollPosition() {
		scrollPositionX = window.pageXOffset || document.documentElement.scrollLeft;
		scrollPositionY = window.pageYOffset || document.documentElement.scrollTop;
	}

	function restoreScrollPosition() {
		if (scrollPositionX) {
			document.documentElement.scrollLeft = scrollPositionX;
			scrollPositionX = undefined;
		}
		if (scrollPositionY) {
			document.documentElement.scrollTop = scrollPositionY;
			scrollPositionY = undefined;
		}
	}

	function menuIsOpen() {
		return container.classList.contains("toggled");
	}

	// Listen for escape key press and close menu
	document.onkeyup = function(event) {
		if ((event.key === 27 || event.key.toLowerCase() === 'escape') && menuIsOpen()) {
			collapseMenu();
		}
	}

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', handleFocus, true );
		links[i].addEventListener( 'blur', handleBlur, true );

		// Prevent focus and blur events from happening when using click events
		links[i].addEventListener( 'mousedown', handleMenuItemMouseDown, true );
	}

	function handleMenuItemMouseDown(e) {
		// Prevent focus and blur events from happening when using click events
		// Allows better behavior on desktop by allowing right-clicks on menu items
		e.preventDefault();
	}

	function handleFocus() {
		addFocus(this);
		addJustFocusedClass(this);
	}

	function handleBlur(e) {
		removeFocus(this);
	}

	/**
	 * Adds the .focus class to a menu item and its ancestors
	 * 
	 * @param {HTMLElement} el 
	 */
	function addFocus(el) {
		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === el.className.indexOf( 'nav-menu' ) ) {

			// On li elements add the class .focus if it doesn't already exist
			if ( 'li' === el.tagName.toLowerCase() ) {
				if ( -1 === el.className.indexOf( 'focus' ) ) {
					el.className += ' focus';
				}
			}

			el = el.parentElement;
		}
	}

	/**
	 * Removes the .focus class from a menu item and its descendents
	 * 
	 * @param {HTMLElement} el 
	 */
	function removeFocus(el) {
		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === el.className.indexOf( 'nav-menu' ) ) {

			// On li elements add the class .focus if it doesn't already exist
			if ( 'li' === el.tagName.toLowerCase() ) {
				el.className = el.className.replace( ' focus', '' );
			}

			el = el.parentElement;
		}
	}

	/**
	 * Change behavior of parent menu items to reveal/hide sub-menu on click
	 */
	var parentMenuItems = menu.querySelectorAll(".menu-item-has-children > a");
	for ( i = 0; i < parentMenuItems.length; i++ ) {
		parentMenuItems[i].addEventListener("click", function(e) {
			e.preventDefault();
			handleMenuItemClick(e.target.parentNode);
		})
	}
	
	function handleMenuItemClick(el) {
		if ( -1 !== el.className.indexOf(' just-focused') ) {
			// Just focused, don't toggle the 'focus' class again
			// Happens because initial click causes focus to happen
			// first and then the click event as well.
			return;
		}

		if ( -1 === el.className.indexOf(' focus') ) {
			// Smooth height transition if Expandable.js is present
			if (window.Expandable) {
				Expandable.expand(el.querySelector("ul"), expandableSubMenuConfig);
			}
			el.className += ' focus';
		} else {
			// Smooth height transition if Expandable.js is present
			if (window.Expandable) {
				Expandable.collapse(el.querySelector("ul"), expandableSubMenuConfig);
			}
			el.className = el.className.replace(' focus', '');
		}
	}

	/**
	 * Add a 'just-focused' class after focus to prevent a clicked parent menu item
	 * from immediately hiding itself (click also triggers focus, so both occur together
	 * during the first click of a parent menu item)
	 */
	function addJustFocusedClass(el) {
		if (el.nodeName == "A") {
			el = el.parentNode; // Make sure we are dealing with a parent <li> element
		}

		if ( -1 === el.className.indexOf('menu-item-has-children') ) {
			return;
		}

		if ( -1 === el.className.indexOf(' just-focused') ) {
			el.className = el.className += ' just-focused';

			setTimeout(function() {
				el.className = el.className.replace(' just-focused', '');
			}, 100);
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
					addJustFocusedClass(menuItem);
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();
