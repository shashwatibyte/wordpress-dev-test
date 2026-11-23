<?php
/**
 * The archive template — category, tag, author and date archives.
 *
 * @package Xhat_Blog
 */

get_header();
?>

<div class="xhat-pagehead">
	<div class="xhat-container">
		<?php xhat_breadcrumbs(); ?>

		<span class="xhat-eyebrow">
			<?php
			if ( is_category() ) {
				esc_html_e( 'Category', 'xhat-blog' );
			} elseif ( is_tag() ) {
				esc_html_e( 'Tag', 'xhat-blog' );
			} elseif ( is_author() ) {
				esc_html_e( 'Author', 'xhat-blog' );
			} else {
				esc_html_e( 'Archive', 'xhat-blog' );
			}
			?>
		</span>

		<h1 class="xhat-pagehead__title"><?php the_archive_title(); ?></h1>

		<?php
		$xhat_description = get_the_archive_description();

		if ( $xhat_description ) :
			?>
			<div class="xhat-pagehead__sub"><?php echo wp_kses_post( $xhat_description ); ?></div>
			<?php
		else :
			?>
			<p class="xhat-pagehead__sub">
				<?php
				printf(
					/* translators: %s: number of posts. */
					esc_html( _n( '%s article in this collection.', '%s articles in this collection.', (int) $GLOBALS['wp_query']->found_posts, 'xhat-blog' ) ),
					esc_html( number_format_i18n( $GLOBALS['wp_query']->found_posts ) )
				);
				?>
			</p>
		<?php endif; ?>
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
