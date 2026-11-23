/**
 * Xhat Blog — theme interactions.
 *
 * - Mobile menu toggle (accessible, Esc + outside click to close)
 * - "About Us" dropdown, on desktop and as a mobile accordion
 * - Reading progress bar on single posts
 * - Scroll reveal for cards
 *
 * @package Xhat_Blog
 */
( function () {
	'use strict';

	var settings = window.xhatSettings || {};
	var DESKTOP  = 1024;

	/* ---------------------------------------------------------------
	 * Helpers
	 * ------------------------------------------------------------- */
	function each( list, callback ) {
		Array.prototype.forEach.call( list, callback );
	}

	/* ---------------------------------------------------------------
	 * Mobile menu
	 * ------------------------------------------------------------- */
	function initMobileMenu() {
		var burger = document.getElementById( 'xhat-burger' );
		var panel  = document.getElementById( 'xhat-mobile-menu' );

		if ( ! burger || ! panel ) {
			return;
		}

		function setOpen( open ) {
			panel.hidden = ! open;
			burger.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			burger.setAttribute(
				'aria-label',
				open ? ( settings.menuClose || 'Close menu' ) : ( settings.menuOpen || 'Open menu' )
			);
		}

		burger.addEventListener( 'click', function ( event ) {
			event.stopPropagation();
			setOpen( burger.getAttribute( 'aria-expanded' ) !== 'true' );
		} );

		// Close when a link inside the panel is followed.
		each( panel.querySelectorAll( 'a' ), function ( link ) {
			link.addEventListener( 'click', function () {
				setOpen( false );
			} );
		} );

		// Escape closes and returns focus to the burger.
		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' === event.key && ! panel.hidden ) {
				setOpen( false );
				burger.focus();
			}
		} );

		// Click outside the header closes it.
		document.addEventListener( 'click', function ( event ) {
			if ( ! panel.hidden && ! panel.contains( event.target ) && ! burger.contains( event.target ) ) {
				setOpen( false );
			}
		} );

		// Reset when resizing up to desktop.
		var resizeTimer;
		window.addEventListener( 'resize', function () {
			window.clearTimeout( resizeTimer );
			resizeTimer = window.setTimeout( function () {
				if ( window.innerWidth >= DESKTOP && ! panel.hidden ) {
					setOpen( false );
				}
			}, 150 );
		} );
	}

	/* ---------------------------------------------------------------
	 * Dropdown sub-menus
	 *
	 * Works with the theme's default navigation (which already ships a
	 * <button class="xhat-nav__toggle">) and with any menu the admin
	 * assigns in Appearance -> Menus, where a toggle is injected.
	 * ------------------------------------------------------------- */
	function chevronSvg() {
		var svg = document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' );

		svg.setAttribute( 'viewBox', '0 0 24 24' );
		svg.setAttribute( 'fill', 'none' );
		svg.setAttribute( 'stroke', 'currentColor' );
		svg.setAttribute( 'stroke-width', '2' );
		svg.setAttribute( 'stroke-linecap', 'round' );
		svg.setAttribute( 'stroke-linejoin', 'round' );
		svg.setAttribute( 'aria-hidden', 'true' );
		svg.setAttribute( 'focusable', 'false' );

		var path = document.createElementNS( 'http://www.w3.org/2000/svg', 'path' );
		path.setAttribute( 'd', 'm6 9 6 6 6-6' );
		svg.appendChild( path );

		return svg;
	}

	/**
	 * Give WordPress-generated sub-menus the same toggle button the
	 * theme's own navigation uses.
	 */
	function enhanceWpSubmenus() {
		var parents = document.querySelectorAll(
			'.xhat-nav__list .menu-item-has-children, .xhat-mobile-menu__list .menu-item-has-children'
		);

		each( parents, function ( parent, index ) {
			var submenu = parent.querySelector( '.sub-menu' );
			var link    = parent.querySelector( 'a' );

			if ( ! submenu || parent.querySelector( '.xhat-nav__toggle' ) ) {
				return;
			}

			var panelId = submenu.id || 'xhat-wp-submenu-' + index;
			submenu.id  = panelId;
			submenu.hidden = true;

			var button = document.createElement( 'button' );
			button.type = 'button';
			button.className = 'xhat-nav__toggle';
			button.setAttribute( 'aria-expanded', 'false' );
			button.setAttribute( 'aria-controls', panelId );
			button.appendChild( document.createTextNode( link ? link.textContent : '' ) );
			button.appendChild( chevronSvg() );

			// Replace the parent link with the toggle; the same destination
			// stays reachable as the first item of the dropdown.
			if ( link ) {
				parent.insertBefore( button, link );
				link.hidden = true;
			} else {
				parent.insertBefore( button, submenu );
			}
		} );
	}

	function initDropdowns() {
		enhanceWpSubmenus();

		var toggles = document.querySelectorAll( '.xhat-nav__toggle' );

		if ( ! toggles.length ) {
			return;
		}

		function closeAll( except ) {
			each( toggles, function ( toggle ) {
				if ( toggle === except ) {
					return;
				}

				var panel = document.getElementById( toggle.getAttribute( 'aria-controls' ) );

				toggle.setAttribute( 'aria-expanded', 'false' );

				if ( panel ) {
					panel.hidden = true;
				}
			} );
		}

		each( toggles, function ( toggle ) {
			toggle.addEventListener( 'click', function ( event ) {
				event.stopPropagation();

				var panel = document.getElementById( toggle.getAttribute( 'aria-controls' ) );

				if ( ! panel ) {
					return;
				}

				var isOpen = toggle.getAttribute( 'aria-expanded' ) === 'true';

				closeAll( toggle );

				toggle.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
				panel.hidden = isOpen;
			} );
		} );

		// Outside click closes open dropdowns.
		document.addEventListener( 'click', function ( event ) {
			if ( ! event.target.closest || ! event.target.closest( '.sub-menu' ) ) {
				closeAll( null );
			}
		} );

		// Escape closes the dropdown and refocuses its toggle.
		document.addEventListener( 'keydown', function ( event ) {
			if ( 'Escape' !== event.key ) {
				return;
			}

			each( toggles, function ( toggle ) {
				if ( toggle.getAttribute( 'aria-expanded' ) === 'true' ) {
					toggle.focus();
				}
			} );

			closeAll( null );
		} );
	}

	/* ---------------------------------------------------------------
	 * Reading progress bar
	 * ------------------------------------------------------------- */
	function initProgress() {
		var bar     = document.getElementById( 'xhat-progress' );
		var article = document.querySelector( '.xhat-content' );

		if ( ! bar || ! article ) {
			return;
		}

		function update() {
			var rect     = article.getBoundingClientRect();
			var total    = rect.height - window.innerHeight;
			var scrolled = -rect.top;
			var percent  = total > 0 ? ( scrolled / total ) * 100 : 0;

			bar.style.width = Math.min( 100, Math.max( 0, percent ) ) + '%';
		}

		update();
		window.addEventListener( 'scroll', update, { passive: true } );
		window.addEventListener( 'resize', update );
	}

	/* ---------------------------------------------------------------
	 * Scroll reveal
	 * ------------------------------------------------------------- */
	function initReveal() {
		var targets = document.querySelectorAll( '.xhat-card, .xhat-sectionhead' );

		if ( ! targets.length ) {
			return;
		}

		var reduced = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		if ( reduced || ! ( 'IntersectionObserver' in window ) ) {
			return;
		}

		each( targets, function ( element ) {
			element.classList.add( 'xhat-reveal' );
		} );

		var observer = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-visible' );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
		);

		each( targets, function ( element ) {
			observer.observe( element );
		} );
	}

	function init() {
		initMobileMenu();
		initDropdowns();
		initProgress();
		initReveal();
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
}() );
