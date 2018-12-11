<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package _s
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function _s_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
}
add_filter( 'body_class', '_s_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function _s_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', '_s_pingback_header' );

/**
 * Adds the default sidebar class to the <body> element.
 * If the sidebar is not active, instead adds the 'no-sidebar' class;
 */
function _s_add_body_class_default_sidebar_location() {
	// Change this function call to set the default location of the sidebar
	_s_add_body_class_right_sidebar();
	// _s_add_body_class_left_sidebar();
}

/**
 * Adds the 'sidebar' and 'content-sidebar' classes to the <body> element.
 * If the sidebar is not active, instead adds the 'no-sidebar' class;
 */
function _s_add_body_class_right_sidebar() {
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		add_filter( 'body_class', function( $classes ) {
			$classes[] = 'sidebar';
			$classes[] = 'content-sidebar';
			return $classes;
		} );
	} else {
		_s_add_body_class_no_sidebar();
	}
}

/**
 * Adds the 'sidebar' and 'sidebar-content' classes to the <body> element.
 * If the sidebar is not active, instead adds the 'no-sidebar' class;
 */
function _s_add_body_class_left_sidebar() {
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		add_filter( 'body_class', function( $classes ) {
			$classes[] = 'sidebar';
			$classes[] = 'sidebar-content';
			return $classes;
		} );
	} else {
		_s_add_body_class_no_sidebar();
	}
}

/**
 * Adds the 'no-sidebar' class to the <body> element
 */
function _s_add_body_class_no_sidebar() {
	add_filter( 'body_class', function( $classes ) {
		$classes[] = 'no-sidebar';
		return $classes;
	} );
}