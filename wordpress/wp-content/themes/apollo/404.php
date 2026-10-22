<?php
/**
 * Apollo 404 page.
 *
 * @package apollo
 */

get_header();
?>
<main id="primary" class="apollo-404">
	<p class="apollo-404__code">4<span>0</span>4</p>
	<h1><?php esc_html_e( 'Trang không tìm thấy', 'apollo' ); ?></h1>
	<p><?php esc_html_e( 'Trang bạn đang tìm kiếm có thể đã bị di chuyển, đổi tên hoặc tạm thời không khả dụng. Hãy khám phá các mục khác của Apollo Automobil.', 'apollo' ); ?></p>
	<div class="apollo-404__actions">
		<a class="apollo-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'VỀ TRANG CHỦ', 'apollo' ); ?></a>
		<a class="apollo-button apollo-button--outline" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'KHÁM PHÁ SẢN PHẨM', 'apollo' ); ?></a>
	</div>
</main>
<?php get_footer(); ?>
