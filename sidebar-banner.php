<?php
/**
 * The sidebar containing the banner widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

if ( ! is_active_sidebar( 'banner' ) ) {
	return;
}
?>

<span class="banner-widget-area">
	<?php dynamic_sidebar( 'banner' ); ?>
</span>
