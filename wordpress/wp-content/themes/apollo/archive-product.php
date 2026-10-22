<?php
/**
 * WooCommerce product catalog.
 *
 * @package apollo
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary">
	<section class="apollo-page-heading">
		<div class="apollo-shell">
			<?php woocommerce_breadcrumb(); ?>
			<span class="apollo-eyebrow"><?php esc_html_e( 'Apollo Automobil', 'apollo' ); ?></span>
			<h1><?php esc_html_e( 'Bộ sưu tập sản phẩm', 'apollo' ); ?></h1>
			<p><?php esc_html_e( 'Mô hình xe Apollo và sản phẩm sưu tầm được quản lý từ WooCommerce.', 'apollo' ); ?></p>
		</div>
	</section>

	<section class="apollo-catalog apollo-shell">
		<?php do_action( 'woocommerce_before_main_content' ); ?>
		<button class="apollo-mobile-filter" type="button" aria-expanded="false" aria-controls="apollo-product-filters"><?php esc_html_e( 'Lọc sản phẩm', 'apollo' ); ?></button>
		<div class="apollo-catalog__layout">
			<aside class="apollo-filters" id="apollo-product-filters">
				<h2><?php esc_html_e( 'Lọc sản phẩm', 'apollo' ); ?></h2>
				<form method="get" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
					<div class="apollo-filter-group">
						<label for="apollo-search-products"><?php esc_html_e( 'Tìm kiếm', 'apollo' ); ?></label>
						<input id="apollo-search-products" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Tên sản phẩm', 'apollo' ); ?>">
						<input type="hidden" name="post_type" value="product">
					</div>
					<div class="apollo-filter-group">
						<label for="apollo-product-category"><?php esc_html_e( 'Danh mục', 'apollo' ); ?></label>
						<select name="product_cat" id="apollo-product-category">
							<option value=""><?php esc_html_e( 'Tất cả danh mục', 'apollo' ); ?></option>
							<?php
							$selected_category = isset( $_GET['product_cat'] ) ? sanitize_title( wp_unslash( $_GET['product_cat'] ) ) : '';
							foreach ( apollo_get_visible_product_categories() as $category ) :
								?>
								<option value="<?php echo esc_attr( $category->slug ); ?>" <?php selected( $selected_category, $category->slug ); ?>><?php echo esc_html( $category->name ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="apollo-filter-group">
						<fieldset>
							<legend><?php esc_html_e( 'Khoảng giá (₫)', 'apollo' ); ?></legend>
							<div class="apollo-filter-price">
								<input type="number" min="0" name="min_price" value="<?php echo isset( $_GET['min_price'] ) ? esc_attr( wc_clean( wp_unslash( $_GET['min_price'] ) ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Từ', 'apollo' ); ?>">
								<input type="number" min="0" name="max_price" value="<?php echo isset( $_GET['max_price'] ) ? esc_attr( wc_clean( wp_unslash( $_GET['max_price'] ) ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Đến', 'apollo' ); ?>">
							</div>
						</fieldset>
					</div>
					<div class="apollo-filter-group">
						<label><input type="checkbox" name="stock_status" value="instock" <?php checked( isset( $_GET['stock_status'] ) && 'instock' === sanitize_key( wp_unslash( $_GET['stock_status'] ) ) ); ?>> <?php esc_html_e( 'Chỉ xem sản phẩm còn hàng', 'apollo' ); ?></label>
					</div>
					<div class="apollo-filter-group">
						<button class="apollo-button" type="submit"><?php esc_html_e( 'Áp dụng bộ lọc', 'apollo' ); ?></button>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Xóa bộ lọc', 'apollo' ); ?></a>
					</div>
				</form>
			</aside>

			<div class="apollo-catalog__results">
				<?php if ( woocommerce_product_loop() ) : ?>
					<div class="apollo-toolbar">
						<div class="apollo-toolbar__results"><?php woocommerce_result_count(); ?></div>
						<?php woocommerce_catalog_ordering(); ?>
					</div>
					<?php woocommerce_product_loop_start(); ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php wc_get_template_part( 'content', 'product' ); ?>
						<?php endwhile; ?>
					<?php woocommerce_product_loop_end(); ?>
					<div class="apollo-pagination"><?php woocommerce_pagination(); ?></div>
				<?php else : ?>
					<div class="apollo-no-products">
						<h2><?php esc_html_e( 'Chưa có sản phẩm phù hợp', 'apollo' ); ?></h2>
						<p><?php esc_html_e( 'Gian hàng sẽ hiển thị sản phẩm Apollo sau khi catalog được bổ sung.', 'apollo' ); ?></p>
						<a class="apollo-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Về trang chủ', 'apollo' ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php do_action( 'woocommerce_after_main_content' ); ?>
	</section>
</main>
<?php get_footer(); ?>
