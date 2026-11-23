<?php
/**
 * The single post template.
 *
 * @package Xhat_Blog
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<div class="xhat-progress" id="xhat-progress" aria-hidden="true"></div>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'xhat-single' ); ?>>

		<header class="xhat-single__head">
			<div class="xhat-container xhat-container--reading">

				<?php xhat_breadcrumbs(); ?>

				<h1 class="xhat-single__title"><?php the_title(); ?></h1>

				<?php if ( has_excerpt() ) : ?>
					<p class="xhat-single__lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>

				<?php xhat_single_meta(); ?>

			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="xhat-container xhat-container--reading">
				<figure class="xhat-single__media">
					<?php
					the_post_thumbnail(
						'full',
						array(
							'alt'      => the_title_attribute( array( 'echo' => false ) ),
							'fetchpriority' => 'high',
						)
					);
					?>
					<?php if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) : ?>
						<figcaption><?php echo esc_html( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?></figcaption>
					<?php endif; ?>
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

			<footer class="xhat-single__footer">

				<?php
				$xhat_tags = get_the_tags();

				if ( $xhat_tags ) :
					?>
					<div class="xhat-tags">
						<span class="xhat-tags__label"><?php esc_html_e( 'Tags', 'xhat-blog' ); ?></span>
						<?php foreach ( $xhat_tags as $xhat_tag ) : ?>
							<a href="<?php echo esc_url( get_tag_link( $xhat_tag->term_id ) ); ?>">
								<?php echo esc_html( $xhat_tag->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php xhat_share_links(); ?>

			</footer>

			<?php
			$xhat_prev = get_previous_post();
			$xhat_next = get_next_post();

			if ( $xhat_prev || $xhat_next ) :
				?>
				<nav class="xhat-postnav" aria-label="<?php esc_attr_e( 'Post navigation', 'xhat-blog' ); ?>">
					<?php if ( $xhat_prev ) : ?>
						<a class="xhat-postnav__item xhat-postnav__item--prev" href="<?php echo esc_url( get_permalink( $xhat_prev ) ); ?>">
							<span class="xhat-postnav__label"><?php esc_html_e( 'Previous article', 'xhat-blog' ); ?></span>
							<span class="xhat-postnav__title"><?php echo esc_html( get_the_title( $xhat_prev ) ); ?></span>
						</a>
					<?php endif; ?>

					<?php if ( $xhat_next ) : ?>
						<a class="xhat-postnav__item xhat-postnav__item--next" href="<?php echo esc_url( get_permalink( $xhat_next ) ); ?>">
							<span class="xhat-postnav__label"><?php esc_html_e( 'Next article', 'xhat-blog' ); ?></span>
							<span class="xhat-postnav__title"><?php echo esc_html( get_the_title( $xhat_next ) ); ?></span>
						</a>
					<?php endif; ?>
				</nav>
			<?php endif; ?>

		</div>

		<?php
		$xhat_related = xhat_get_related_posts( 3 );

		if ( $xhat_related->have_posts() ) :
			?>
			<section class="xhat-related">
				<div class="xhat-container">
					<div class="xhat-sectionhead">
						<div>
							<span class="xhat-eyebrow"><?php esc_html_e( 'Keep reading', 'xhat-blog' ); ?></span>
							<h2 class="xhat-sectionhead__title"><?php esc_html_e( 'Related articles', 'xhat-blog' ); ?></h2>
						</div>
					</div>

					<div class="xhat-grid">
						<?php
						while ( $xhat_related->have_posts() ) :
							$xhat_related->the_post();
							get_template_part( 'template-parts/card' );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>

	</article>

	<?php
endwhile;

get_footer();
