<?php
/**
 * The static page template.
 *
 * @package Xhat_Blog
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'xhat-single' ); ?>>

		<header class="xhat-single__head">
			<div class="xhat-container xhat-container--reading">
				<?php xhat_breadcrumbs(); ?>
				<h1 class="xhat-single__title"><?php the_title(); ?></h1>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="xhat-container xhat-container--narrow">
				<figure class="xhat-single__media">
					<?php the_post_thumbnail( 'full', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
				</figure>
			</div>
		<?php endif; ?>

		<div class="xhat-container xhat-container--reading">
			<div class="xhat-content entry-content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<nav class="xhat-pagination"><div class="nav-links">',
						'after'  => '</div></nav>',
					)
				);
				?>
			</div>
		</div>

	</article>

	<?php
endwhile;

get_footer();
