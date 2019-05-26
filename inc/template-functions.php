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
	return $classes;
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
function _s_add_body_class_sidebar() {
	// Change this function call to set the default location of the sidebar
	_s_add_body_class_sidebar_right();
	// _s_add_body_class_sidebar_left();
}

/**
 * Adds the 'sidebar' and 'content-sidebar' classes to the <body> element.
 * If the sidebar is not active, instead adds the 'no-sidebar' class;
 */
function _s_add_body_class_sidebar_right() {
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
function _s_add_body_class_sidebar_left() {
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

/**
 * Returns true if a header image is set, or if the page/post has a featured image set
 * 
 * Uses the featured image as page-specific override of the header image
 *
 * @return bool
 */
function _s_has_header_image() {
	return (bool) has_header_image() || (bool) has_post_thumbnail();
}

/**
 * Returns the markup for the header image, or the featured image if set.
 * Returns an empty string if no header image or featured image is found.
 *
 * Uses the featured image as page-specific override of the header image
 * 
 * @return string
 */
function _s_get_header_image() {
	if (has_post_thumbnail()) {
		return get_the_post_thumbnail();
	} else if (has_header_image()) {
		return get_header_image_tag();
	}
	return "";
}

/**
 * Renders the header image, or the featured image if set.
 *
 * Uses the featured image as page-specific override of the header image
 * 
 * @return void
 */
function _s_the_header_image_tag() {
	echo _s_get_header_image();
}