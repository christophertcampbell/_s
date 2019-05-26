<?php
/**
 * _s Theme Customizer
 *
 * @package _s
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function _s_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => '_s_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => '_s_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', '_s_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function _s_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function _s_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function _s_customize_preview_js() {
	wp_enqueue_script( '_s-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', '_s_customize_preview_js' );

/**
 * Add header settings
 */
function _s_add_header_section( $wp_customize ) {
	$wp_customize->add_section( 'header' , array(
		'title'      => __('Header','_s'),
		'priority'   => 40,
	) );

	// Setting: show_login_link

	$wp_customize->add_setting( 'show_login_link', array(
	   'capability' => 'edit_theme_options',
	   'sanitize_callback' => '_s_sanitize_checkbox',
	 ) );
	 
	 $wp_customize->add_control( 'show_login_link', array(
	   'type' => 'checkbox',
	   'section' => 'header',
	   'label' => __( 'Show login/logout link' ),
	   'description' => __( 'Show a login/logout link in the header' ),
	 ) );
}
add_action( 'customize_register', '_s_add_header_section' );

/**
 * Add footer settings
 */
function _s_add_footer_section( $wp_customize ) {
	$wp_customize->add_section( 'footer' , array(
		'title'      => __('Footer','_s'),
		'priority'   => 80,
	) );

	// Setting: hide_footer_credits

	$wp_customize->add_setting( 'hide_footer_credits', array(
	   'capability' => 'edit_theme_options',
	   'sanitize_callback' => '_s_sanitize_checkbox',
	 ) );
	 
	 $wp_customize->add_control( 'hide_footer_credits', array(
	   'type' => 'checkbox',
	   'section' => 'footer',
	   'label' => __( 'Hide footer credits' ),
	   'description' => __( 'Hide the footer credits' ),
	 ) );

	 // Setting: custom_footer_credits

	 $wp_customize->add_setting( 'custom_footer_credits', array(
		'capability' => 'edit_theme_options',
		'default' => '',
	  ) );
	  
	  $wp_customize->add_control( 'custom_footer_credits', array(
		'type' => 'textarea',
		'section' => 'footer',
		'label' => __( 'Custom Footer Credits' ),
		'description' => __( 'Will replace the default Wordpress / Underscores credits' ),
	  ) );
	 
 }
 add_action( 'customize_register', '_s_add_footer_section' );

function _s_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

