<?php
/**
 * The search form.
 *
 * @package Xhat_Blog
 */

$xhat_unique_id = wp_unique_id( 'search-field-' );
?>
<form role="search" method="get" class="xhat-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $xhat_unique_id ); ?>">
		<?php esc_html_e( 'Search articles', 'xhat-blog' ); ?>
	</label>

	<input
		type="search"
		id="<?php echo esc_attr( $xhat_unique_id ); ?>"
		class="xhat-searchform__field"
		placeholder="<?php esc_attr_e( 'Search articles&hellip;', 'xhat-blog' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s" />

	<button type="submit" class="xhat-btn">
		<?php xhat_icon( 'search' ); ?>
		<span><?php esc_html_e( 'Search', 'xhat-blog' ); ?></span>
	</button>
</form>
