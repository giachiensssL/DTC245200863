<?php
/**
 * Apollo no products found message.
 *
 * @package apollo
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="apollo-no-products">
	<h2><?php esc_html_e( 'Không tìm thấy sản phẩm phù hợp', 'apollo' ); ?></h2>
	<p><?php esc_html_e( 'Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm.', 'apollo' ); ?></p>
	<div style="display:flex;gap:12px;justify-content:center;margin-top:20px;">
		<a class="apollo-button" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'XÓA BỘ LỌC', 'apollo' ); ?></a>
		<a class="apollo-button apollo-button--outline" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'VỀ TRANG CHỦ', 'apollo' ); ?></a>
	</div>
</div>
