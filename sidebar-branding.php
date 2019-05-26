<?php
/**
 * The sidebar containing the branding widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

if ( ! is_active_sidebar( 'branding' ) ) {
	return;
}
?>

<span class="branding-widget-area">
	<?php dynamic_sidebar( 'branding' ); ?>
</span>
