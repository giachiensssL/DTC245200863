<?php
/**
 * Apollo vehicle collection archive.
 *
 * @package apollo
 */

get_header();
?>
<main id="primary">
	<section class="apollo-page-heading">
		<div class="apollo-shell">
			<span class="apollo-eyebrow"><?php esc_html_e( 'Apollo Automobil', 'apollo' ); ?></span>
			<h1><?php esc_html_e( 'Bộ sưu tập xe', 'apollo' ); ?></h1>
			<p><?php esc_html_e( 'Thông tin và hình ảnh từng mẫu xe sẽ được bổ sung từ nội dung đã xác minh.', 'apollo' ); ?></p>
		</div>
	</section>
	<section class="apollo-catalog apollo-shell">
		<div class="apollo-vehicle-grid">
			<?php if ( have_posts() ) : ?>
				<?php $vehicle_fallbacks = array( 'a1.webp', 'a2.webp', 'a6.webp', 'a8.webp', 'a9.webp' ); ?>
				<?php $vehicle_index = 0; ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="apollo-vehicle-card">
						<a class="apollo-vehicle-card__image" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy', 'alt' => esc_attr( get_the_title() ) ) ); ?>
							<?php else : ?>
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $vehicle_fallbacks[ $vehicle_index % count( $vehicle_fallbacks ) ] ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
							<?php endif; ?>
						</a>
						<div class="apollo-card__body">
							<span class="apollo-card__eyebrow"><?php esc_html_e( 'Xe Apollo', 'apollo' ); ?></span>
							<h2 class="apollo-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div class="apollo-card__meta"><?php the_excerpt(); ?></div>
							<div class="apollo-card__action"><a class="apollo-button" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Xem chi tiết', 'apollo' ); ?></a></div>
						</div>
					</article>
					<?php $vehicle_index++; ?>
				<?php endwhile; ?>
				<div class="apollo-pagination"><?php the_posts_pagination(); ?></div>
			<?php else : ?>
				<div class="apollo-empty">
					<h2><?php esc_html_e( 'Bộ sưu tập đang chờ nội dung Apollo', 'apollo' ); ?></h2>
					<p><?php esc_html_e( 'Chưa có mẫu xe hoặc ảnh được công bố. Quản trị viên có thể bổ sung nội dung đã xác minh trong mục Xe Apollo.', 'apollo' ); ?></p>
					<a class="apollo-button" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>"><?php esc_html_e( 'Liên hệ tư vấn', 'apollo' ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php get_footer(); ?>
