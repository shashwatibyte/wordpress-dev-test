<?php
/**
 * The 404 (not found) template.
 *
 * @package Xhat_Blog
 */

get_header();
?>

<div class="xhat-container">
	<section class="xhat-empty">
		<p class="xhat-empty__code">404</p>

		<h1 class="xhat-empty__title"><?php esc_html_e( 'This page is off the grid', 'xhat-blog' ); ?></h1>

		<p>
			<?php esc_html_e( 'The page you are looking for has been moved or no longer exists. Try a search, or head back to the latest articles.', 'xhat-blog' ); ?>
		</p>

		<?php get_search_form(); ?>

		<div class="xhat-empty__actions">
			<a class="xhat-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Back to home', 'xhat-blog' ); ?>
			</a>
			<a class="xhat-btn xhat-btn--ghost" href="<?php echo esc_url( xhat_launch_url() ); ?>">
				<?php esc_html_e( 'Launch Xhat', 'xhat-blog' ); ?>
			</a>
		</div>
	</section>
</div>

<?php
get_footer();
