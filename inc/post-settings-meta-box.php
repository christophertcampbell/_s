<?php

/**
 * Settings for configuring appearance on a post-by-post basis
 */
function _s_add_post_settings_meta_box()
{
	$screens = ['page', 'post'];
	foreach ($screens as $screen) {
		add_meta_box(
			'_s_post_settings',						// Unique ID
			'Theme Settings', 						// Box title
			'_s_render_post_settings_meta_box',   	// Content callback, must be of type callable
			$screen,                  				// Post type
			'side',									// Context (normal, side or advanced)
			'high'									// Priority (high, low, default)
		);
	}
}

function _s_render_post_settings_meta_box( $post ) {

	$meta = get_post_meta( $post->ID );

	// Collect saved values
	$_s_hide_post_title = ( isset( $meta['_s_hide_post_title'][0] ) &&  '1' === $meta['_s_hide_post_title'][0] ) ? 1 : 0;
	$_s_collapse_header_and_content = ( isset( $meta['_s_collapse_header_and_content'][0] ) &&  '1' === $meta['_s_collapse_header_and_content'][0] ) ? 1 : 0;

	wp_nonce_field( '_s_post_settings_meta_box', '_s_post_settings_meta_box_nonce' );

	?>
		<p>
			<label>
				<input type="checkbox" name="_s_hide_post_title" value="1" <?php checked( $_s_hide_post_title, 1 ); ?> />
				Hide title
			</label>
		</p>

		<table>
			<tr>
				<td><input type="checkbox" name="_s_collapse_header_and_content" id="_s_collapse_header_and_content" value="1" <?php checked( $_s_collapse_header_and_content, 1 ); ?> /></td>
				<td><label for="_s_collapse_header_and_content">Collapse space between header and content</label></td>
			</tr>
		</table>
	<?php
}

function _s_save_post_settings_meta_box( $post_id ) {

	if ( ! isset( $_POST['_s_post_settings_meta_box_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['_s_post_settings_meta_box_nonce'] ), '_s_post_settings_meta_box' ) ) {
		return $post_id;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	}

	/*
	 * If this is an autosave, our form has not been submitted,
	 * so we don't want to do anything.
	 */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	/* Ok to save */

	$_s_hide_post_title = ( isset( $_POST['_s_hide_post_title'] ) && '1' === $_POST['_s_hide_post_title'] ) ? 1 : 0;
	update_post_meta( $post_id, '_s_hide_post_title', esc_attr( $_s_hide_post_title ) );

	$_s_hide_post_title = ( isset( $_POST['_s_collapse_header_and_content'] ) && '1' === $_POST['_s_collapse_header_and_content'] ) ? 1 : 0;
	update_post_meta( $post_id, '_s_collapse_header_and_content', esc_attr( $_s_hide_post_title ) );
}

function _s_add_post_settings_body_classes( $classes ) {

	if ( get_post_meta( get_the_id(), '_s_hide_post_title', true ) ) {
		$classes[] = 'no-post-title';
	}

	if ( get_post_meta( get_the_id(), '_s_collapse_header_and_content', true ) ) {
		$classes[] = 'collapse-header-margin';
	}

	return $classes;

}

add_action( 'add_meta_boxes', '_s_add_post_settings_meta_box' );
add_action( 'save_post', '_s_save_post_settings_meta_box' );
add_filter( 'body_class', '_s_add_post_settings_body_classes' );