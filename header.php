<?php
/**
 * The theme header.
 *
 * Reproduces the header of xhat.com: dark, sticky, subtle bottom border;
 * logo + nav on the left and a mint "Launch Now" pill on the right.
 *
 * @package Xhat_Blog
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content">
	<?php esc_html_e( 'Skip to content', 'xhat-blog' ); ?>
</a>

<div id="page" class="xhat-site">

	<header id="masthead" class="xhat-header">
		<div class="xhat-container xhat-header__inner">

			<div class="xhat-header__left">

				<?php xhat_site_logo(); ?>

				<nav
					id="site-navigation"
					class="xhat-nav"
					aria-label="<?php esc_attr_e( 'Primary menu', 'xhat-blog' ); ?>">
					<?php xhat_primary_menu(); ?>
				</nav>

			</div>

			<div class="xhat-header__actions">

				<a class="xhat-header__signup" href="<?php echo esc_url( xhat_launch_url() ); ?>">
					<?php esc_html_e( 'Launch Now', 'xhat-blog' ); ?>
				</a>

				<button
					class="xhat-burger"
					id="xhat-burger"
					type="button"
					aria-expanded="false"
					aria-controls="xhat-mobile-menu"
					aria-label="<?php esc_attr_e( 'Open menu', 'xhat-blog' ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
						stroke="currentColor" stroke-width="2" stroke-linecap="round"
						stroke-linejoin="round" aria-hidden="true" focusable="false">
						<path d="M4 6h16M4 12h16M4 18h16" />
					</svg>
				</button>

			</div>

		</div>

		<div class="xhat-mobile-menu" id="xhat-mobile-menu" hidden>
			<div class="xhat-mobile-menu__inner">

				<?php xhat_primary_menu( true ); ?>

				<div class="xhat-mobile-menu__actions">
					<a class="xhat-mobile-menu__signup" href="<?php echo esc_url( xhat_launch_url() ); ?>">
						<?php esc_html_e( 'Launch Now', 'xhat-blog' ); ?>
					</a>
				</div>

			</div>
		</div>
	</header>

	<div id="content" class="xhat-site-content">
