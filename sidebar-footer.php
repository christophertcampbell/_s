<?php
/**
 * The sidebar containing the footer widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

if ( ! is_active_sidebar( 'footer' ) ) {
	return;
}
?>

<div id="footer-content" class="widget-area">
	<div class="inner">
		<?php dynamic_sidebar( 'footer' ); ?>
	</div>
</div><!-- #footer-content -->
