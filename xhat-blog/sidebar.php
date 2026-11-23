<?php
/**
 * The blog sidebar.
 *
 * Shows the "Blog Sidebar" widget area if the administrator has added
 * widgets; otherwise falls back to a useful default set (search, recent
 * posts, categories and a call to action).
 *
 * @package Xhat_Blog
 */

?>
<aside id="secondary" class="xhat-sidebar" aria-label="<?php esc_attr_e( 'Blog sidebar', 'xhat-blog' ); ?>">

	<?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>

		<?php dynamic_sidebar( 'sidebar-blog' ); ?>

	<?php else : ?>

		<section class="xhat-widget">
			<h2 class="xhat-widget__title"><?php esc_html_e( 'Search', 'xhat-blog' ); ?></h2>
			<?php get_search_form(); ?>
		</section>

		<?php
		$xhat_recent = new WP_Query(
			array(
				'posts_per_page'      => 5,
				'post__not_in'        => is_singular() ? array( get_the_ID() ) : array(),
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);

		if ( $xhat_recent->have_posts() ) :
			?>
			<section class="xhat-widget">
				<h2 class="xhat-widget__title"><?php esc_html_e( 'Latest Updates', 'xhat-blog' ); ?></h2>
				<ul>
					<?php
					while ( $xhat_recent->have_posts() ) :
						$xhat_recent->the_post();
						?>
						<li>
							<div class="xhat-minipost">
								<?php if ( has_post_thumbnail() ) : ?>
									<a class="xhat-minipost__thumb" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
										<?php the_post_thumbnail( 'xhat-thumb', array( 'loading' => 'lazy', 'alt' => '' ) ); ?>
									</a>
								<?php endif; ?>

								<div>
									<h3 class="xhat-minipost__title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<span class="xhat-minipost__date"><?php echo esc_html( get_the_date() ); ?></span>
								</div>
							</div>
						</li>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</section>
		<?php endif; ?>

		<?php
		$xhat_cats = get_categories(
			array(
				'hide_empty' => true,
				'number'     => 10,
				// Skip the default "Uncategorized" category - it is not a real topic.
				'exclude'    => array( (int) get_option( 'default_category' ) ),
			)
		);

		if ( ! empty( $xhat_cats ) ) :
			?>
			<section class="xhat-widget">
				<h2 class="xhat-widget__title"><?php esc_html_e( 'Topics', 'xhat-blog' ); ?></h2>
				<ul>
					<?php foreach ( $xhat_cats as $xhat_cat ) : ?>
						<li>
							<a href="<?php echo esc_url( get_category_link( $xhat_cat->term_id ) ); ?>">
								<?php echo esc_html( $xhat_cat->name ); ?>
								<span>(<?php echo esc_html( number_format_i18n( $xhat_cat->count ) ); ?>)</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>

		<section class="xhat-widget xhat-widget--cta">
			<h2 class="xhat-widget__title"><?php esc_html_e( 'Try Xhat free', 'xhat-blog' ); ?></h2>
			<p>
				<?php esc_html_e( 'Private &amp; unrestricted AI chat — no surveillance, no limits. Start a conversation in seconds.', 'xhat-blog' ); ?>
			</p>
			<a class="xhat-btn" href="<?php echo esc_url( xhat_launch_url() ); ?>">
				<?php esc_html_e( 'Launch Now', 'xhat-blog' ); ?>
			</a>
		</section>

	<?php endif; ?>

</aside>
