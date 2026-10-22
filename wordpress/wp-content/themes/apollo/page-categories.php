<?php
/**
 * Template Name: Danh mục Apollo
 *
 * @package apollo
 */

get_header();
$categories = apollo_get_visible_product_categories();
?>
<main id="primary">
	<section class="apollo-page-heading">
		<div class="apollo-shell">
			<span class="apollo-eyebrow"><?php esc_html_e( 'GIAN HÀNG APOLLO', 'apollo' ); ?></span>
			<h1><?php the_title(); ?></h1>
			<p><?php esc_html_e( 'Khám phá những sản phẩm Apollo đã được xác minh.', 'apollo' ); ?></p>
		</div>
	</section>
	<section class="apollo-section">
		<div class="apollo-shell">
			<?php if ( $categories ) : ?>
				<div class="apollo-category-grid">
					<?php foreach ( $categories as $category ) : ?>
						<?php $category_url = get_term_link( $category ); ?>
						<?php if ( is_wp_error( $category_url ) ) { continue; } ?>
						<?php
						$category_image_id = absint( get_term_meta( $category->term_id, 'thumbnail_id', true ) );
						$category_image    = $category_image_id ? wp_get_attachment_image_url( $category_image_id, 'large' ) : '';
						if ( ! $category_image ) {
							$category_name = strtolower( $category->name );
							$fallback      = 'a1.webp';
							if ( false !== strpos( $category_name, 'mô hình' ) ) {
								$fallback = 'a12.webp';
							} elseif ( false !== strpos( $category_name, 'phụ kiện' ) ) {
								$fallback = 'a9.webp';
							} elseif ( false !== strpos( $category_name, 'thời trang' ) ) {
								$fallback = 'ao1.webp';
							}
							$category_image = get_stylesheet_directory_uri() . '/assets/images/' . $fallback;
						}
						?>
						<a class="apollo-category-card" href="<?php echo esc_url( $category_url ); ?>">
							<img class="apollo-category-card__image" src="<?php echo esc_url( $category_image ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" loading="lazy">
							<span class="apollo-category-card__overlay" aria-hidden="true"></span>
							<div class="apollo-card__body">
								<span class="apollo-card__eyebrow"><?php esc_html_e( 'Danh mục Apollo', 'apollo' ); ?></span>
								<h2><?php echo esc_html( $category->name ); ?></h2>
								<span class="apollo-category-card__cta"><?php esc_html_e( 'Khám phá sản phẩm', 'apollo' ); ?> →</span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="apollo-empty" role="status">
					<h3><?php esc_html_e( 'Danh mục Apollo sẽ xuất hiện tại đây', 'apollo' ); ?></h3>
					<p><?php esc_html_e( 'Danh mục sẽ được bổ sung khi có catalog sản phẩm Apollo đã xác minh.', 'apollo' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
