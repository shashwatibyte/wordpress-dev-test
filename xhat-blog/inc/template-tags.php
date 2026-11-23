<?php
/**
 * Custom template tags and helper functions for Xhat Blog.
 *
 * @package Xhat_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a safe inline SVG icon.
 *
 * All icons use a 24x24 viewBox and `currentColor` so they inherit text colour.
 *
 * @param string $name Icon slug.
 * @return string Inline SVG markup (already safe), or empty string.
 */
function xhat_get_icon( $name ) {

	$stroke = 'xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"';
	$fill   = 'xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"';

	$icons = array(
		'calendar' => '<svg ' . $stroke . '><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>',
		'clock'    => '<svg ' . $stroke . '><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>',
		'arrow'    => '<svg ' . $stroke . '><path d="M5 12h14M13 6l6 6-6 6"/></svg>',
		'search'   => '<svg ' . $stroke . '><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>',
		'image'    => '<svg ' . $stroke . '><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-5-5L5 21"/></svg>',
		'chevron'  => '<svg ' . $stroke . '><path d="m6 9 6 6 6-6"/></svg>',
		// lucide "building-2" and "list-checks" — the exact icons used on the live site.
		'building' => '<svg ' . $stroke . '><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>',
		'checks'   => '<svg ' . $stroke . '><path d="m3 17 2 2 4-4"/><path d="m3 7 2 2 4-4"/><path d="M13 6h8"/><path d="M13 12h8"/><path d="M13 18h8"/></svg>',

		// Social — used by the share buttons on single posts.
		'facebook'  => '<svg ' . $fill . '><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.88 3.77-3.88 1.09 0 2.23.19 2.23.19v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.77l-.44 2.89h-2.33v6.99A10 10 0 0 0 22 12z"/></svg>',
		'x'         => '<svg ' . $fill . '><path d="M18.9 2H22l-6.8 7.8L23 22h-6.1l-4.8-6.2L6.7 22H3.6l7.3-8.4L1 2h6.2l4.3 5.7L18.9 2zm-1.1 18h1.7L7.1 4H5.3l12.5 16z"/></svg>',
		'linkedin'  => '<svg ' . $fill . '><path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM3 9h4v12H3zM9 9h3.8v1.7h.05A4.2 4.2 0 0 1 16.6 8.7c3.2 0 4.4 2 4.4 5.2V21h-4v-6c0-1.5-.5-2.5-1.9-2.5-1.1 0-1.8.75-2.1 1.5-.1.25-.1.6-.1 1V21H9z"/></svg>',
		'whatsapp'  => '<svg ' . $fill . '><path d="M12 2a10 10 0 0 0-8.5 15.2L2 22l4.9-1.4A10 10 0 1 0 12 2zm0 2a8 8 0 0 1 0 16 8 8 0 0 1-4.2-1.2l-.4-.2-2.5.7.7-2.4-.2-.4A8 8 0 0 1 12 4zm-2.6 3.9c-.2 0-.5.1-.7.3-.3.3-.8.9-.8 1.8 0 1 .7 2.1 1 2.5.3.4 1.4 2.2 3.5 3 1.7.7 2.1.6 2.5.5.5 0 1.3-.5 1.5-1.1.2-.5.2-1 .1-1.1 0-.1-.2-.2-.4-.3l-1.4-.7c-.2-.1-.4-.1-.5.1l-.6.7c-.1.2-.3.2-.5.1-.5-.2-1.2-.5-1.8-1.1-.5-.5-.9-1.1-1-1.4-.1-.2 0-.3.1-.4l.4-.5c.1-.2.1-.3 0-.5l-.6-1.4c-.1-.2-.2-.2-.4-.2z"/></svg>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Echo an inline SVG icon.
 *
 * @param string $name Icon slug.
 */
function xhat_icon( $name ) {
	echo xhat_get_icon( $name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Hard-coded safe SVG markup.
}

/**
 * Output the site logo: the Customizer custom logo if set, otherwise the
 * bundled Xhat logo, otherwise the site title as text.
 *
 * @param string $class Extra wrapper class.
 */
function xhat_site_logo( $class = '' ) {

	// The live site uses the xhat mark in the header.
	$src    = get_template_directory_uri() . '/assets/images/xhat-logo.png';
	$width  = 394;
	$height = 378;

	// Honour a logo set in the Customizer, if there is one.
	if ( has_custom_logo() ) {

		$logo_id    = get_theme_mod( 'custom_logo' );
		$logo_image = wp_get_attachment_image_src( $logo_id, 'full' );

		if ( $logo_image ) {
			$src    = $logo_image[0];
			$width  = $logo_image[1];
			$height = $logo_image[2];
		}
	}

	printf(
		'<div class="xhat-branding %1$s"><a href="%2$s"><img src="%3$s" alt="%4$s" width="%5$d" height="%6$d" /></a></div>',
		esc_attr( $class ),
		esc_url( xhat_home_url() ),
		esc_url( $src ),
		esc_attr( get_bloginfo( 'name', 'display' ) ),
		(int) $width,
		(int) $height
	);
}

/**
 * Featured image for a listing card, with a graceful placeholder.
 *
 * @param string $size Registered image size.
 */
function xhat_card_thumbnail( $size = 'xhat-card', $eager = false ) {

	if ( has_post_thumbnail() ) {

		// The featured card is the page's main image, so load it immediately
		// rather than lazily.
		$attr = $eager
			? array( 'loading' => 'eager', 'fetchpriority' => 'high' )
			: array( 'loading' => 'lazy' );

		$attr['alt'] = the_title_attribute( array( 'echo' => false ) );

		printf( '<a class="xhat-card__media" href="%s" aria-hidden="true" tabindex="-1">', esc_url( get_permalink() ) );
		the_post_thumbnail( $size, $attr );
		echo '</a>';
		return;
	}

	printf(
		'<a class="xhat-card__media xhat-card__media--placeholder" href="%s" aria-hidden="true" tabindex="-1">%s</a>',
		esc_url( get_permalink() ),
		xhat_get_icon( 'image' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe SVG.
	);
}

/**
 * Estimated reading time in minutes, based on the post content.
 *
 * @param int|WP_Post|null $post Post to measure.
 * @return int Minutes (minimum 1).
 */
function xhat_reading_time( $post = null ) {

	$post    = get_post( $post );
	$content = $post ? $post->post_content : '';
	$words   = str_word_count( wp_strip_all_tags( strip_shortcodes( $content ) ) );

	return max( 1, (int) ceil( $words / 200 ) );
}

/**
 * Meta row for a listing card: date, category, reading time.
 */
function xhat_card_meta() {
	?>
	<div class="xhat-card__meta">
		<span>
			<?php xhat_icon( 'calendar' ); ?>
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</span>
		<span>
			<?php xhat_icon( 'clock' ); ?>
			<?php
			printf(
				/* translators: %s: number of minutes. */
				esc_html__( '%s min read', 'xhat-blog' ),
				esc_html( xhat_reading_time() )
			);
			?>
		</span>
	</div>
	<?php
}

/**
 * Full meta row for a single post: author, date, reading time, comments.
 */
function xhat_single_meta() {
	?>
	<div class="xhat-single__meta">
		<span>
			<?php xhat_icon( 'calendar' ); ?>
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</span>
		<span>
			<?php xhat_icon( 'clock' ); ?>
			<?php
			printf(
				/* translators: %s: number of minutes. */
				esc_html__( '%s min read', 'xhat-blog' ),
				esc_html( xhat_reading_time() )
			);
			?>
		</span>
	</div>
	<?php
}

/**
 * Simple, accessible breadcrumb trail.
 */
function xhat_breadcrumbs() {

	if ( is_front_page() ) {
		return;
	}

	$sep = '<span aria-hidden="true">/</span>';

	echo '<nav class="xhat-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'xhat-blog' ) . '">';

	printf(
		'<a href="%1$s">%2$s</a>',
		esc_url( home_url( '/' ) ),
		esc_html__( 'Home', 'xhat-blog' )
	);

	$posts_page_id = (int) get_option( 'page_for_posts' );

	if ( is_singular( 'post' ) ) {

		if ( $posts_page_id ) {
			echo $sep; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe literal.
			printf(
				'<a href="%1$s">%2$s</a>',
				esc_url( get_permalink( $posts_page_id ) ),
				esc_html( get_the_title( $posts_page_id ) )
			);
		}

		// Show the category, but skip the default "Uncategorized" one.
		$default_category = (int) get_option( 'default_category' );
		$categories       = array_values(
			array_filter(
				get_the_category(),
				function ( $category ) use ( $default_category ) {
					return (int) $category->term_id !== $default_category;
				}
			)
		);

		if ( ! empty( $categories ) ) {
			echo $sep; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe literal.
			printf(
				'<a href="%1$s">%2$s</a>',
				esc_url( get_category_link( $categories[0]->term_id ) ),
				esc_html( $categories[0]->name )
			);
		}

		echo $sep; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe literal.
		echo '<span aria-current="page">' . esc_html( wp_trim_words( get_the_title(), 8, '&hellip;' ) ) . '</span>';

	} elseif ( is_category() || is_tag() || is_tax() ) {

		echo $sep; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe literal.
		echo '<span aria-current="page">' . esc_html( single_term_title( '', false ) ) . '</span>';

	} elseif ( is_search() ) {

		echo $sep; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe literal.
		echo '<span aria-current="page">' . esc_html__( 'Search results', 'xhat-blog' ) . '</span>';

	} elseif ( is_404() ) {

		echo $sep; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe literal.
		echo '<span aria-current="page">' . esc_html__( 'Not found', 'xhat-blog' ) . '</span>';

	} elseif ( is_page() ) {

		echo $sep; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe literal.
		echo '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>';
	}

	echo '</nav>';
}

/**
 * Themed numeric pagination.
 */
function xhat_pagination() {

	$links = paginate_links(
		array(
			'mid_size'  => 1,
			'end_size'  => 2,
			'prev_text' => esc_html__( 'Previous', 'xhat-blog' ),
			'next_text' => esc_html__( 'Next', 'xhat-blog' ),
		)
	);

	if ( empty( $links ) ) {
		return;
	}

	printf(
		'<nav class="xhat-pagination" aria-label="%1$s"><div class="nav-links">%2$s</div></nav>',
		esc_attr__( 'Posts navigation', 'xhat-blog' ),
		wp_kses_post( $links )
	);
}

/**
 * Social share links for the current post.
 */
function xhat_share_links() {

	$url   = rawurlencode( get_permalink() );
	$title = rawurlencode( get_the_title() );

	$networks = array(
		'facebook' => array(
			'label' => __( 'Share on Facebook', 'xhat-blog' ),
			'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
		),
		'x'        => array(
			'label' => __( 'Share on X', 'xhat-blog' ),
			'url'   => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title,
		),
		'linkedin' => array(
			'label' => __( 'Share on LinkedIn', 'xhat-blog' ),
			'url'   => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url,
		),
		'whatsapp' => array(
			'label' => __( 'Share on WhatsApp', 'xhat-blog' ),
			'url'   => 'https://api.whatsapp.com/send?text=' . $title . '%20' . $url,
		),
	);

	echo '<div class="xhat-share">';
	echo '<span class="xhat-share__label">' . esc_html__( 'Share', 'xhat-blog' ) . '</span>';

	foreach ( $networks as $slug => $network ) {
		printf(
			'<a href="%1$s" target="_blank" rel="noopener noreferrer nofollow" aria-label="%2$s">%3$s</a>',
			esc_url( $network['url'] ),
			esc_attr( $network['label'] ),
			xhat_get_icon( $slug ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe SVG.
		);
	}

	echo '</div>';
}

/**
 * Query the posts related to the current one (same categories).
 *
 * @param int $limit Number of posts.
 * @return WP_Query
 */
function xhat_get_related_posts( $limit = 3 ) {

	$category_ids = wp_list_pluck( get_the_category(), 'term_id' );

	$args = array(
		'post__not_in'        => array( get_the_ID() ),
		'posts_per_page'      => (int) $limit,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);

	if ( ! empty( $category_ids ) ) {
		$args['category__in'] = $category_ids;
	}

	return new WP_Query( $args );
}

/**
 * Base URL of the main (Next.js) Xhat website.
 *
 * Used by the default menus so the blog links back to the live site sections
 * that do not exist inside WordPress. Filter `xhat_main_site_url` to change it.
 *
 * @return string
 */
function xhat_main_site_url() {
	return untrailingslashit( apply_filters( 'xhat_main_site_url', 'https://xhat.com' ) );
}

/**
 * URL the "Launch Now" buttons point at.
 *
 * Defaults to the main Xhat app. Filter `xhat_launch_url` to send it
 * somewhere else without editing the theme.
 *
 * @return string
 */
function xhat_launch_url() {
	return apply_filters( 'xhat_launch_url', xhat_main_site_url() . '/' );
}

/**
 * Destination for the header logo and the "Home" link.
 *
 * These point at the main Xhat website rather than this WordPress
 * install, matching the live header. Filter `xhat_home_url` to send them to
 * the WordPress home instead:
 *
 *     add_filter( 'xhat_home_url', function () { return home_url( '/' ); } );
 *
 * @return string
 */
function xhat_home_url() {
	return apply_filters( 'xhat_home_url', xhat_main_site_url() . '/' );
}

/**
 * The default header navigation, used when no menu is assigned to the
 * "primary" location.
 *
 * Mirrors the live site: Home points at the main Xhat app, Blog is this
 * WordPress install. Add anything else from Appearance -> Menus — sub-menus
 * are supported and render as a dropdown.
 *
 * @return array
 */
function xhat_get_default_nav_items() {

	$posts_page_id = (int) get_option( 'page_for_posts' );
	$blog_url      = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
	$blog_label    = $posts_page_id ? get_the_title( $posts_page_id ) : __( 'Blog', 'xhat-blog' );

	$items = array(
		array(
			'url'      => xhat_home_url(),
			'label'    => __( 'Home', 'xhat-blog' ),
			'current'  => false,
			'external' => false,
		),
		// Blog is this WordPress site.
		array(
			'url'      => $blog_url,
			'label'    => $blog_label,
			'current'  => is_home() || is_singular( 'post' ) || is_category() || is_tag(),
			'external' => false,
		),
	);

	return apply_filters( 'xhat_default_nav_items', $items );
}

/**
 * Render the header navigation.
 *
 * Uses the menu assigned to the "primary" location when there is one, so the
 * administrator stays in control from Appearance -> Menus. Otherwise it falls
 * back to the default navigation above.
 *
 * @param bool $mobile Render the mobile variant.
 */
function xhat_primary_menu( $mobile = false ) {

	$list_class = $mobile ? 'xhat-mobile-menu__list' : 'xhat-nav__list';

	if ( has_nav_menu( 'primary' ) ) {

		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_id'        => $mobile ? 'xhat-mobile-primary-menu' : 'primary-menu',
				'menu_class'     => $list_class,
				'container'      => false,
				'depth'          => 2,
			)
		);

		return;
	}

	printf(
		'<ul id="%1$s" class="%2$s">',
		esc_attr( $mobile ? 'xhat-mobile-primary-menu' : 'primary-menu' ),
		esc_attr( $list_class )
	);

	foreach ( xhat_get_default_nav_items() as $index => $item ) {

		$has_children = ! empty( $item['children'] );
		$li_classes   = array();

		if ( ! empty( $item['current'] ) ) {
			$li_classes[] = 'current-menu-item';
		}

		if ( $has_children ) {
			$li_classes[] = 'menu-item-has-children';
		}

		printf( '<li class="%s">', esc_attr( implode( ' ', $li_classes ) ) );

		if ( $has_children ) {

			$panel_id = 'xhat-submenu-' . ( $mobile ? 'm' : 'd' ) . $index;

			printf(
				'<button type="button" class="xhat-nav__toggle" aria-expanded="false" aria-controls="%1$s">%2$s%3$s</button>',
				esc_attr( $panel_id ),
				esc_html( $item['label'] ),
				xhat_get_icon( 'chevron' ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe SVG.
			);

			printf( '<ul id="%s" class="sub-menu" hidden>', esc_attr( $panel_id ) );

			foreach ( $item['children'] as $child ) {
				printf(
					'<li><a href="%1$s"%2$s>%3$s<span class="xhat-nav__sublabel"><span class="xhat-nav__subtitle">%4$s</span><span class="xhat-nav__subdesc">%5$s</span></span></a></li>',
					esc_url( $child['url'] ),
					! empty( $child['external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '',
					'<span class="xhat-nav__subicon">' . xhat_get_icon( $child['icon'] ) . '</span>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Safe SVG.
					esc_html( $child['label'] ),
					esc_html( $child['description'] )
				);
			}

			echo '</ul>';

		} else {

			printf(
				'<a href="%1$s"%2$s>%3$s</a>',
				esc_url( $item['url'] ),
				! empty( $item['external'] ) ? ' target="_blank" rel="noopener noreferrer"' : '',
				esc_html( $item['label'] )
			);
		}

		echo '</li>';
	}

	echo '</ul>';
}
