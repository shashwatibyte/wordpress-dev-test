<?php
/**
 * Shown when a query returns no posts.
 *
 * @package Xhat_Blog
 */

?>
<section class="xhat-empty">

	<?php if ( is_search() ) : ?>

		<h2 class="xhat-empty__title"><?php esc_html_e( 'No articles matched your search', 'xhat-blog' ); ?></h2>
		<p><?php esc_html_e( 'Try a different topic or keyword.', 'xhat-blog' ); ?></p>
		<?php get_search_form(); ?>

	<?php elseif ( current_user_can( 'publish_posts' ) ) : ?>

		<h2 class="xhat-empty__title"><?php esc_html_e( 'No posts published yet', 'xhat-blog' ); ?></h2>
		<p><?php esc_html_e( 'Write your first article from the WordPress dashboard and it will appear here automatically.', 'xhat-blog' ); ?></p>

		<div class="xhat-empty__actions">
			<a class="xhat-btn" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>">
				<?php esc_html_e( 'Add your first post', 'xhat-blog' ); ?>
			</a>
		</div>

	<?php else : ?>

		<h2 class="xhat-empty__title"><?php esc_html_e( 'Nothing here yet', 'xhat-blog' ); ?></h2>
		<p><?php esc_html_e( 'New articles are published regularly — please check back soon.', 'xhat-blog' ); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>

</section>
