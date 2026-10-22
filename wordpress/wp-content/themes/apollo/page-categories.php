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
						<a class="apollo-category-card" href="<?php echo esc_url( $category_url ); ?>">
							<div class="apollo-card__body">
								<span class="apollo-card__eyebrow"><?php esc_html_e( 'Danh mục Apollo', 'apollo' ); ?></span>
								<h2><?php echo esc_html( $category->name ); ?></h2>
								<span><?php esc_html_e( 'Khám phá sản phẩm', 'apollo' ); ?> →</span>
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
