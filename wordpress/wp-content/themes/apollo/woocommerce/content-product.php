<?php
/**
 * Product card for Apollo catalog.
 *
 * @package apollo
 */

defined( 'ABSPATH' ) || exit;
global $product;

if ( ! $product instanceof WC_Product || ! $product->is_visible() ) {
	return;
}

if ( metadata_exists( 'post', $product->get_id(), '_product_price' ) ) {
	return;
}

$is_on_sale   = $product->is_on_sale();
$is_in_stock  = $product->is_in_stock();
$regular_price = $product->get_regular_price();
$sale_price    = $product->get_sale_price();

// Compute discount percentage.
$discount_pct = '';
if ( $is_on_sale && $regular_price && $sale_price ) {
	$discount_pct = '-' . round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) . '%';
}
?>
<li <?php wc_product_class( 'apollo-product-card', $product ); ?>>
	<?php if ( $is_on_sale && $discount_pct ) : ?>
		<span class="apollo-sale-badge" aria-label="<?php echo esc_attr( $discount_pct ); ?>"><?php echo esc_html( $discount_pct ); ?></span>
	<?php endif; ?>
	<a class="apollo-product-card__image" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) );
		} else {
			echo '<span class="apollo-image-missing">' . esc_html__( 'Ảnh sản phẩm chưa được cập nhật', 'apollo' ) . '</span>';
		}
		?>
	</a>
	<div class="apollo-card__body">
		<span class="apollo-card__eyebrow"><?php echo wp_kses_post( wc_get_product_category_list( $product->get_id(), ', ' ) ); ?></span>
		<h2 class="apollo-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ( wc_review_ratings_enabled() ) : ?>
			<?php woocommerce_template_loop_rating(); ?>
		<?php endif; ?>
		<div class="apollo-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		<div class="apollo-card__meta">
			<?php if ( $is_in_stock ) : ?>
				<span class="apollo-stock-label apollo-stock-label--instock"><?php esc_html_e( 'Còn hàng', 'apollo' ); ?></span>
			<?php else : ?>
				<span class="apollo-stock-label apollo-stock-label--outofstock"><?php esc_html_e( 'Tạm hết hàng', 'apollo' ); ?></span>
			<?php endif; ?>
		</div>
		<div class="apollo-card__action">
			<?php woocommerce_template_loop_add_to_cart(); ?>
		</div>
	</div>
</li>
