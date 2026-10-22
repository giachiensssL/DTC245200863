<?php
/**
 * Apollo empty cart state.
 *
 * @package apollo
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="apollo-empty apollo-cart-empty" role="status">
	<h3><?php esc_html_e( 'Giỏ hàng của bạn đang trống', 'apollo' ); ?></h3>
	<p><?php esc_html_e( 'Khám phá gian hàng Apollo và các sản phẩm sưu tầm.', 'apollo' ); ?></p>
	<a class="apollo-button" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Tiếp tục khám phá', 'apollo' ); ?></a>
</div>
