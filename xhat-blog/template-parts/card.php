<?php
/**
 * A single post card used by the blog listing, archives, search and
 * related-posts sections.
 *
 * Accepts an optional `eager` argument (bool) so the first card on a page
 * can load its image immediately instead of lazily.
 *
 * @package Xhat_Blog
 */

$xhat_eager = ! empty( $args['eager'] );
$xhat_class = 'xhat-card';

if ( is_sticky() && ! is_paged() ) {
	$xhat_class .= ' xhat-card--sticky';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $xhat_class ); ?>>

	<?php xhat_card_thumbnail( 'xhat-card', $xhat_eager ); ?>

	<div class="xhat-card__body">

		<?php xhat_card_meta(); ?>

		<h2 class="xhat-card__title">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>

		<p class="xhat-card__excerpt">
			<?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '&hellip;' ) ); ?>
		</p>

		<div class="xhat-card__footer">
			<a class="xhat-card__more" href="<?php the_permalink(); ?>">
				<?php esc_html_e( 'Read article', 'xhat-blog' ); ?>
				<?php xhat_icon( 'arrow' ); ?>
				<span class="screen-reader-text">
					<?php
					printf(
						/* translators: %s: post title. */
						esc_html__( 'about %s', 'xhat-blog' ),
						esc_html( get_the_title() )
					);
					?>
				</span>
			</a>
		</div>

	</div>
</article>
