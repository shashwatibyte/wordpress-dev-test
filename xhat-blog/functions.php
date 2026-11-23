<?php
/**
 * Xhat Blog — theme functions and definitions.
 *
 * @package Xhat_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

if ( ! defined( 'XHAT_THEME_VERSION' ) ) {
	define( 'XHAT_THEME_VERSION', '1.9.1' );
}

/**
 * Theme setup.
 */
function xhat_setup() {

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Featured images.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 750, true );
	add_image_size( 'xhat-card', 800, 500, true );       // Blog listing cards.
	add_image_size( 'xhat-thumb', 160, 120, true );      // Sidebar mini posts.

	// Custom logo (defaults to the bundled Xhat logo).
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
			'unlink-homepage-logo' => false,
		)
	);

	// HTML5 markup.
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	// Feed links, editor styles, responsive embeds.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Navigation menus.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu (header) - Home, Blog', 'xhat-blog' ),
		)
	);

	// Brand colours for the block editor palette.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Mint', 'xhat-blog' ),
				'slug'  => 'xhat-accent',
				'color' => '#00FFC6',
			),
			array(
				'name'  => __( 'Mint Deep', 'xhat-blog' ),
				'slug'  => 'xhat-accent-dark',
				'color' => '#04BA93',
			),
			array(
				'name'  => __( 'Heading', 'xhat-blog' ),
				'slug'  => 'xhat-heading',
				'color' => '#FFFFFF',
			),
			array(
				'name'  => __( 'Ink', 'xhat-blog' ),
				'slug'  => 'xhat-ink',
				'color' => '#F2F5F4',
			),
			array(
				'name'  => __( 'Body Text', 'xhat-blog' ),
				'slug'  => 'xhat-body',
				'color' => '#B2BAB8',
			),
			array(
				'name'  => __( 'Muted', 'xhat-blog' ),
				'slug'  => 'xhat-muted',
				'color' => '#8C9693',
			),
			array(
				'name'  => __( 'Surface', 'xhat-blog' ),
				'slug'  => 'xhat-surface',
				'color' => '#101312',
			),
			array(
				'name'  => __( 'Black', 'xhat-blog' ),
				'slug'  => 'xhat-dark',
				'color' => '#0A0A0A',
			),
		)
	);

	// Translation ready.
	load_theme_textdomain( 'xhat-blog', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'xhat_setup' );

/**
 * Content width.
 */
function xhat_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'xhat_content_width', 1200 );
}
add_action( 'after_setup_theme', 'xhat_content_width', 0 );

/**
 * Enqueue styles and scripts.
 */
function xhat_enqueue_assets() {

	// Inter — the typeface used on xhat.com.
	wp_enqueue_style(
		'xhat-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap',
		array(),
		null
	);

	// Main stylesheet.
	wp_enqueue_style(
		'xhat-style',
		get_stylesheet_uri(),
		array( 'xhat-fonts' ),
		XHAT_THEME_VERSION
	);

	// Theme JavaScript (mobile menu, dropdowns, reading progress, reveal).
	wp_enqueue_script(
		'xhat-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		XHAT_THEME_VERSION,
		true
	);

	wp_localize_script(
		'xhat-main',
		'xhatSettings',
		array(
			'menuOpen'  => __( 'Open menu', 'xhat-blog' ),
			'menuClose' => __( 'Close menu', 'xhat-blog' ),
		)
	);

}
add_action( 'wp_enqueue_scripts', 'xhat_enqueue_assets' );

/**
 * Preconnect to Google Fonts for faster font loading.
 *
 * @param array  $urls           URLs to print.
 * @param string $relation_type  Relation type.
 * @return array
 */
function xhat_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'xhat_resource_hints', 10, 2 );

/**
 * Register widget areas.
 */
function xhat_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Blog Sidebar', 'xhat-blog' ),
			'id'            => 'sidebar-blog',
			'description'   => __( 'Appears beside the blog listing and single posts.', 'xhat-blog' ),
			'before_widget' => '<section id="%1$s" class="xhat-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="xhat-widget__title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'xhat_widgets_init' );

/**
 * Excerpt length.
 *
 * @param int $length Current length.
 * @return int
 */
function xhat_excerpt_length( $length ) {
	return is_admin() ? $length : 28;
}
add_filter( 'excerpt_length', 'xhat_excerpt_length', 999 );

/**
 * Excerpt "read more" string.
 *
 * @param string $more Current more string.
 * @return string
 */
function xhat_excerpt_more( $more ) {
	return is_admin() ? $more : '&hellip;';
}
add_filter( 'excerpt_more', 'xhat_excerpt_more' );

/**
 * Add helpful body classes.
 *
 * @param array $classes Body classes.
 * @return array
 */
function xhat_body_classes( $classes ) {

	if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
		$classes[] = 'xhat-no-sidebar';
	}

	if ( is_singular() && has_post_thumbnail() ) {
		$classes[] = 'xhat-has-thumbnail';
	}

	if ( is_admin_bar_showing() ) {
		$classes[] = 'admin-bar';
	}

	return $classes;
}
add_filter( 'body_class', 'xhat_body_classes' );

/**
 * Wrap the <!--more--> link in a button class.
 *
 * @param string $link Read more link.
 * @return string
 */
function xhat_content_more_link( $link ) {
	return str_replace( 'more-link', 'more-link xhat-btn xhat-btn--sm', $link );
}
add_filter( 'the_content_more_link', 'xhat_content_more_link' );

/**
 * Output the Xhat favicon.
 *
 * Uses the bundled xhat.com logo mark. If an administrator sets a Site Icon
 * under Appearance -> Customize -> Site Identity, that one wins and WordPress
 * prints its own tags instead.
 */
function xhat_favicons() {

	if ( has_site_icon() ) {
		return;
	}

	$logo = get_template_directory_uri() . '/assets/images/xhat-logo.png';

	printf( '<link rel="icon" href="%s" type="image/png" />' . "
", esc_url( $logo ) );
	printf( '<link rel="apple-touch-icon" href="%s" />' . "
", esc_url( $logo ) );
	printf( '<meta name="msapplication-TileImage" content="%s" />' . "
", esc_url( $logo ) );
	echo '<meta name="theme-color" content="#0a0a0a" />' . "
";
}
add_action( 'wp_head', 'xhat_favicons', 5 );
add_action( 'admin_head', 'xhat_favicons' );
add_action( 'login_head', 'xhat_favicons' );

/* =========================================================================
   Comments are disabled site-wide.

   This is a business blog, so comments are turned off everywhere rather than
   relying on Settings -> Discussion (which only affects newly created posts
   and leaves older ones open). To bring comments back, delete this block.
   ========================================================================= */

/**
 * Drop comment support from every post type.
 */
function xhat_disable_comment_support() {

	foreach ( get_post_types() as $post_type ) {

		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}
add_action( 'init', 'xhat_disable_comment_support' );

// Report every post as closed to comments, with none to show.
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'comments_array', '__return_empty_array', 20 );

/**
 * Hide the comment admin screens, dashboard widget and toolbar item.
 */
function xhat_hide_comments_admin() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'xhat_hide_comments_admin' );

/**
 * Remove the "Recent Comments" dashboard widget.
 */
function xhat_hide_comments_dashboard() {
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'xhat_hide_comments_dashboard' );

/**
 * Remove the comments bubble from the admin toolbar.
 *
 * @param WP_Admin_Bar $wp_admin_bar Toolbar instance.
 */
function xhat_hide_comments_toolbar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'comments' );
}
add_action( 'admin_bar_menu', 'xhat_hide_comments_toolbar', 999 );

/**
 * Load template tags and helper functions.
 */
require_once get_template_directory() . '/inc/template-tags.php';
