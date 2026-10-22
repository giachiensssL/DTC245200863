<?php
/**
 * Template Name: Về Apollo
 *
 * @package apollo
 */

get_header();
?>
<main id="primary">
	<section class="apollo-page-heading">
		<div class="apollo-shell">
			<span class="apollo-eyebrow"><?php esc_html_e( 'APOLLO AUTOMOBIL', 'apollo' ); ?></span>
			<h1><?php the_title(); ?></h1>
			<p><?php esc_html_e( 'Không gian giới thiệu thương hiệu và bộ sưu tập Apollo.', 'apollo' ); ?></p>
		</div>
	</section>
	<section class="apollo-section">
		<div class="apollo-shell apollo-editorial">
			<div class="apollo-editorial__art"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/a6.webp' ); ?>" alt="<?php esc_attr_e( 'Siêu xe trong không gian trưng bày', 'apollo' ); ?>" loading="lazy"></div>
			<div class="apollo-editorial__copy">
				<span class="apollo-eyebrow"><?php esc_html_e( 'Thiết kế · Kỹ thuật', 'apollo' ); ?></span>
				<h2><?php esc_html_e( 'Khám phá thế giới Apollo', 'apollo' ); ?></h2>
				<div class="entry-content">
					<?php if ( trim( wp_strip_all_tags( get_the_content() ) ) ) : ?>
						<?php the_content(); ?>
					<?php else : ?>
						<p><?php esc_html_e( 'Trang giới thiệu bộ sưu tập xe và sản phẩm sưu tầm theo phong cách Apollo Automobil.', 'apollo' ); ?></p>
						<p><?php esc_html_e( 'Đây là website demo học thuật, không đại diện cho thương hiệu chính hãng. Thông tin mẫu xe và sản phẩm được trình bày theo dữ liệu hiện có trên website.', 'apollo' ); ?></p>
					<?php endif; ?>
				</div>
				<a class="apollo-button" href="<?php echo esc_url( get_post_type_archive_link( 'apollo_vehicle' ) ); ?>"><?php esc_html_e( 'Xem bộ sưu tập xe', 'apollo' ); ?></a>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
