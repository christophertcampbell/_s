<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php get_sidebar( 'footer' ); ?>
		<?php if ( get_theme_mod('hide_footer_credits') !== true ) : ?>
			<div class="site-info">
				<div class="inner">
					<?php
						$custom_credits = get_theme_mod( 'custom_footer_credits' );
						if ($custom_credits) :
							echo $custom_credits;
						else:
					?>
						<a href="<?php echo esc_url( __( 'https://wordpress.org/', '_s' ) ); ?>">
							<?php
							/* translators: %s: CMS name, i.e. WordPress. */
							printf( esc_html__( 'Proudly powered by %s', '_s' ), 'WordPress' );
							?>
						</a>
						<span class="sep"> | </span>
						<?php
							/* translators: 1: Theme name, 2: Theme author. */
							printf( esc_html__( 'Theme: %1$s by %2$s.', '_s' ), '_s', '<a href="https://automattic.com/">Automattic</a>' );
						?>
					<?php endif; ?>
				</div><!-- .inner -->
			</div><!-- .site-info -->
		<?php endif; ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
