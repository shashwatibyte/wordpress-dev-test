<?php
/**
 * The main template file — the blog listing.
 *
 * Shows every published WordPress post with its featured image, title,
 * excerpt, date, categories and numeric pagination.
 *
 * @package Xhat_Blog
 */

get_header();
?>

<div class="xhat-pagehead">
	<div class="xhat-container">
		<?php xhat_breadcrumbs(); ?>

		<span class="xhat-eyebrow"><?php esc_html_e( 'Blog', 'xhat-blog' ); ?></span>

		<h1 class="xhat-pagehead__title">
			<?php
			if ( is_home() && ! is_front_page() && get_option( 'page_for_posts' ) ) {
				echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) );
			} else {
				esc_html_e( 'The Xhat Blog', 'xhat-blog' );
			}
			?>
		</h1>

		<p class="xhat-pagehead__sub">
			<?php esc_html_e( 'Guides, product updates and ideas on private, unrestricted AI — from the team building Xhat.', 'xhat-blog' ); ?>
		</p>
	</div>
</div>

<div class="xhat-container xhat-layout">

	<main id="primary" class="xhat-main">

		<?php if ( have_posts() ) : ?>

			<div class="xhat-grid">
				<?php
				$xhat_index = 0;

				while ( have_posts() ) :
					the_post();

					// Load the first card's image eagerly - it is above the fold.
					get_template_part(
						'template-parts/card',
						null,
						array( 'eager' => ( 0 === $xhat_index && ! is_paged() ) )
					);

					++$xhat_index;
				endwhile;
				?>
			</div>

			<?php xhat_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content-none' ); ?>

		<?php endif; ?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php
get_footer();
