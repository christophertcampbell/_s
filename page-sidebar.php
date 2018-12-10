<?php
/**
 * Template for displaying single pages with a sidebar
 * 
 * Set the sidebar location (right or left) in inc/template-functions.php
 * 
 * Template Name: With Sidebar
 * 
 * @package _s
 */

_s_add_body_class_default_sidebar_location();

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
