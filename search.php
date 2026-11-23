<?php
/**
 * The search results template.
 *
 * @package Xhat_Blog
 */

get_header();
?>

<div class="xhat-pagehead">
	<div class="xhat-container">
		<?php xhat_breadcrumbs(); ?>

		<span class="xhat-eyebrow"><?php esc_html_e( 'Search', 'xhat-blog' ); ?></span>

		<h1 class="xhat-pagehead__title">
			<?php
			printf(
				/* translators: %s: search query. */
				esc_html__( 'Results for %s', 'xhat-blog' ),
				'<span class="xhat-accent">&ldquo;' . esc_html( get_search_query() ) . '&rdquo;</span>'
			);
			?>
		</h1>

		<p class="xhat-pagehead__sub">
			<?php
			printf(
				/* translators: %s: number of results. */
				esc_html( _n( '%s matching article.', '%s matching articles.', (int) $GLOBALS['wp_query']->found_posts, 'xhat-blog' ) ),
				esc_html( number_format_i18n( $GLOBALS['wp_query']->found_posts ) )
			);
			?>
		</p>
	</div>
</div>

<div class="xhat-container xhat-layout">

	<main id="primary" class="xhat-main">

		<?php if ( have_posts() ) : ?>

			<div class="xhat-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card' );
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
