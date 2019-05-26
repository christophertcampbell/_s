<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', '_s' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="inner">
			<div class="site-branding">
				<div class="inner">
					<?php if ( has_custom_logo() ) : ?>
						<div class="site-logo">
							<?php the_custom_logo(); ?>
						</div>
					<?php endif; ?>
					<div class="site-title-container">
						<?php
						if ( is_front_page() && is_home() ) :
							?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
						else :
							?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php
						endif;
						$_s_description = get_bloginfo( 'description', 'display' );
						if ( $_s_description || is_customize_preview() ) :
							?>
							<p class="site-description"><?php echo $_s_description; /* WPCS: xss ok. */ ?></p>
						<?php endif; ?>
					</div>
				</div><!-- .inner -->
			</div><!-- .site-branding -->

			<?php
				$show_login_link = get_theme_mod('show_login_link') === true;
				$show_account_link = get_theme_mod('show_account_link') === true;
				$show_welcome_text = get_theme_mod('show_welcome_text') === true;
			?>
			<?php if ( $show_login_link || $show_account_link || $show_welcome_text || is_active_sidebar( 'branding' ) ) : ?>
				<div class="site-login">
					<?php if ( $show_welcome_text && is_user_logged_in() ) : ?>
						<?php $user = wp_get_current_user(); ?>
						<span class="welcome-text">Welcome, <?php echo $user->first_name ?? $user->display_name ?? $user->login ?>!</span>
					<?php endif; ?>
					<?php if ( $show_login_link ) : ?>
						<?php global $wp; $current_url = home_url($wp->request); ?>
						<?php if (is_user_logged_in()) : ?>
							<span class="loginout-link logout-link"><a href="<?php echo wp_logout_url( $current_url ); ?>" title="Log Out"><span class="text">Sign Out</span></a></span>
						<?php else : ?>
							<span class="loginout-link login-link"><a href="<?php echo wp_login_url( $current_url ); ?>" title="Log In"><span class="text">Sign In</span></a></span>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( $show_account_link && is_user_logged_in() ) : ?>
						<span class="account-link"><a href="<?php echo get_edit_profile_url(); ?>" title="My Account"><span class="text">Account</span></a></span>
					<?php endif; ?>
					<?php get_sidebar( 'branding' ); ?>
				</div>
			<?php endif; ?>

			<nav id="site-navigation" class="main-navigation">
				<div class="inner">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="toggle-content"><?php esc_html_e( 'Primary Menu', '_s' ); ?></span></button>
					<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					) );
					?>
				</div><!-- .inner -->
			</nav><!-- #site-navigation -->

		</div><!-- .inner -->
	</header><!-- #masthead -->

	<?php //if ( has_header_image() ) : ?>
	<?php if ( _s_has_header_image() ) : ?>
		<div id="header-image" class="header-image">
			<div class="inner">
				<?php //the_header_image_tag() ?>
				<?php _s_the_header_image_tag() ?>
			</div>
		</div>
	<?php endif; ?>

	<div id="content" class="site-content">
