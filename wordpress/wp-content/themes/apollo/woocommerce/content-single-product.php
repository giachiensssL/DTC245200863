<?php
/**
 * WooCommerce single-product layout.
 *
 * @package apollo
 */

defined( 'ABSPATH' ) || exit;
global $product;
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'apollo-product-detail', $product ); ?>>
	<?php do_action( 'woocommerce_before_single_product' ); ?>
	<?php if ( post_password_required() ) : ?>
		<?php echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php else : ?>
		<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
		<div class="summary entry-summary">
			<?php do_action( 'woocommerce_single_product_summary' ); ?>
		</div>
		<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
	<?php endif; ?>
</div>
