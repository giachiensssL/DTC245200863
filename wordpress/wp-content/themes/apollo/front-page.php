<?php
/**
 * Apollo Automobil — Homepage (front-page.php)
 * Follows mockup: Hero → Editorial → Vehicles → Categories → Products → Promo → Benefits → Newsletter
 *
 * @package apollo
 */

get_header();

/* Hero image: use backgoud.webp from theme assets as default fallback */
$hero_image = get_theme_mod( 'apollo_hero_image' );
if ( ! $hero_image ) {
	$hero_image = get_stylesheet_directory_uri() . '/assets/images/backgoud.webp';
}

/* Editorial detail image */
$detail_img = get_stylesheet_directory_uri() . '/assets/images/a6.webp';

/* Promo split image */
$promo_img = get_stylesheet_directory_uri() . '/assets/images/ao1.webp';

/* Vehicles query — up to 5, featured first */
$vehicles = new WP_Query(
	array(
		'post_type'      => 'apollo_vehicle',
		'post_status'    => 'publish',
		'posts_per_page' => 5,
	)
);

/* Featured products from WooCommerce */
$featured_products = array();
if ( function_exists( 'wc_get_products' ) ) {
	$featured_products = wc_get_products(
		array(
			'status'     => 'publish',
			'limit'      => 4,
			'orderby'    => 'date',
			'order'      => 'DESC',
			'visibility' => 'visible',
		)
	);
}

/* Apollo categories */
$apollo_categories = function_exists( 'apollo_get_visible_product_categories' )
	? apollo_get_visible_product_categories()
	: array();
?>
<main id="primary">

<!-- ═══════════════════════════════════════════════════════ 1. HERO ═══ -->
<section class="apollo-hero apollo-home-hero">
	<div class="apollo-hero__image" style="background-image:url('<?php echo esc_url( $hero_image ); ?>');" role="img" aria-label="<?php esc_attr_e( 'Apollo Automobil Showroom', 'apollo' ); ?>"></div>
	<div class="apollo-hero__backdrop" aria-hidden="true"></div>

	<div class="apollo-shell apollo-hero__shell">
		<div class="apollo-hero__content">
			<div class="apollo-hero__badge">
				<span class="apollo-hero__badge-dot"></span>
				<span><?php esc_html_e( 'SHOWROOM · BỘ SƯU TẬP', 'apollo' ); ?></span>
			</div>

			<h1 class="apollo-hero__title">
				<?php esc_html_e( 'APOLLO', 'apollo' ); ?>
				<span class="apollo-hero__title-accent"><?php esc_html_e( 'AUTOMOBIL', 'apollo' ); ?></span>
			</h1>

			<p class="apollo-hero__desc">
				<?php esc_html_e( 'Khám phá không gian trưng bày và bộ sưu tập lấy cảm hứng từ thế giới siêu xe. Thông tin từng mẫu xe sẽ được cập nhật khi có dữ liệu xác thực.', 'apollo' ); ?>
			</p>

			<a class="apollo-button apollo-home-hero__cta" href="<?php echo esc_url( get_post_type_archive_link( 'apollo_vehicle' ) ); ?>">
				<?php esc_html_e( 'KHÁM PHÁ BỘ SƯU TẬP', 'apollo' ); ?>
				<span aria-hidden="true">→</span>
			</a>

			<div class="apollo-hero__stats" aria-label="<?php esc_attr_e( 'Khám phá các khu vực Apollo', 'apollo' ); ?>">
				<div class="apollo-hero__stat-item">
					<div class="apollo-hero__stat-body">
						<span class="apollo-hero__stat-number"><?php esc_html_e( 'SHOWROOM', 'apollo' ); ?></span>
						<span class="apollo-hero__stat-label"><?php esc_html_e( 'KHÔNG GIAN TRƯNG BÀY', 'apollo' ); ?></span>
					</div>
				</div>
				<div class="apollo-hero__stat-item">
					<div class="apollo-hero__stat-body">
						<span class="apollo-hero__stat-number"><?php esc_html_e( 'BỘ SƯU TẬP', 'apollo' ); ?></span>
						<span class="apollo-hero__stat-label"><?php esc_html_e( 'CÁC MẪU XE APOLLO', 'apollo' ); ?></span>
					</div>
				</div>
				<div class="apollo-hero__stat-item">
					<div class="apollo-hero__stat-body">
						<span class="apollo-hero__stat-number"><?php esc_html_e( 'GIAN HÀNG', 'apollo' ); ?></span>
						<span class="apollo-hero__stat-label"><?php esc_html_e( 'MÔ HÌNH & PHỤ KIỆN', 'apollo' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ═══════════════════════════ 2. KỸ THUẬT TẠO NÊN KIỆT TÁC ═══════ -->
<section class="apollo-section apollo-section--dark apollo-editorial-section">
	<div class="apollo-shell apollo-editorial">
		<div class="apollo-editorial__art">
			<img
				src="<?php echo esc_url( $detail_img ); ?>"
				alt="<?php esc_attr_e( 'Siêu xe Apollo — thiết kế và kỹ thuật đỉnh cao', 'apollo' ); ?>"
				width="760" height="480" loading="lazy"
			>
		</div>
		<div class="apollo-editorial__copy">
			<span class="apollo-eyebrow"><?php esc_html_e( 'Thiết kế · Kỹ thuật · Trải nghiệm', 'apollo' ); ?></span>
			<h2><?php esc_html_e( 'CẢM HỨNG TỪ THẾ GIỚI SIÊU XE', 'apollo' ); ?></h2>
			<p><?php esc_html_e( 'Khám phá những đường nét thiết kế, câu chuyện kỹ thuật và tinh thần tốc độ qua bộ sưu tập Apollo. Nội dung về từng mẫu xe sẽ được cập nhật khi có thông tin xác thực.', 'apollo' ); ?></p>
			<a class="apollo-button" href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>">
				<?php esc_html_e( 'KHÁM PHÁ THÊM', 'apollo' ); ?>
			</a>
		</div>
	</div>
</section>

<!-- ═══════════════════════════ 3. NHỮNG TUYỆT TÁC TỐC ĐỘ ═══════════ -->
<section class="apollo-section apollo-section--dark">
	<div class="apollo-shell">
		<div class="apollo-section__heading">
			<div>
				<span class="apollo-eyebrow"><?php esc_html_e( 'Apollo Automobil', 'apollo' ); ?></span>
				<h2><?php esc_html_e( 'NHỮNG TUYỆT TÁC TỐC ĐỘ', 'apollo' ); ?></h2>
				<p><?php esc_html_e( 'Bộ sưu tập chỉ hiển thị mẫu xe Apollo đã được quản trị viên bổ sung.', 'apollo' ); ?></p>
			</div>
			<a class="apollo-button apollo-button--outline" href="<?php echo esc_url( get_post_type_archive_link( 'apollo_vehicle' ) ); ?>">
				<?php esc_html_e( 'XEM TOÀN BỘ BỘ SƯU TẬP', 'apollo' ); ?>
			</a>
		</div>

		<?php if ( $vehicles->have_posts() ) : ?>
			<?php
			$vehicle_index   = 0;
			$featured_v      = null;
			$secondary_vs    = array();
			while ( $vehicles->have_posts() ) {
				$vehicles->the_post();
				if ( 0 === $vehicle_index ) {
					$featured_v = get_post();
				} else {
					$secondary_vs[] = get_post();
				}
				$vehicle_index++;
			}
			wp_reset_postdata();
			?>
			<div class="apollo-vehicles-showcase">
				<?php if ( $featured_v ) : ?>
				<!-- Featured large card -->
				<article class="apollo-vehicle-featured">
					<a class="apollo-vehicle-featured__image" href="<?php echo esc_url( get_permalink( $featured_v ) ); ?>">
						<?php if ( has_post_thumbnail( $featured_v->ID ) ) : ?>
							<?php echo get_the_post_thumbnail( $featured_v->ID, 'large', array( 'loading' => 'lazy', 'alt' => esc_attr( get_the_title( $featured_v->ID ) ) ) ); ?>
						<?php else : ?>
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/a1.webp' ); ?>" alt="<?php echo esc_attr( get_the_title( $featured_v->ID ) ); ?>" loading="lazy">
						<?php endif; ?>
					</a>
					<div class="apollo-vehicle-featured__body">
						<span class="apollo-eyebrow"><?php esc_html_e( 'Xe nổi bật', 'apollo' ); ?></span>
						<h3><?php echo esc_html( get_the_title( $featured_v->ID ) ); ?></h3>
						<?php
						$excerpt = get_the_excerpt( $featured_v->ID );
						if ( $excerpt ) :
						?>
						<p class="apollo-vehicle-featured__desc"><?php echo esc_html( wp_trim_words( $excerpt, 20 ) ); ?></p>
						<?php endif; ?>
						<?php
						/* Spec line: stored in post excerpt or custom meta */
						$spec_line = get_post_meta( $featured_v->ID, '_apollo_specs', true );
						if ( ! $spec_line ) {
							$spec_line = get_the_excerpt( $featured_v->ID );
						}
						if ( $spec_line ) :
						?>
						<div class="apollo-vehicle-featured__specs">
							<span class="apollo-spec-chip">
								<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
								<?php echo esc_html( wp_trim_words( $spec_line, 8 ) ); ?>
							</span>
						</div>
						<?php endif; ?>
						<a class="apollo-button" href="<?php echo esc_url( get_permalink( $featured_v->ID ) ); ?>">
							<?php esc_html_e( 'XEM CHI TIẾT', 'apollo' ); ?>
						</a>
					</div>
				</article>
				<?php endif; ?>

				<?php if ( ! empty( $secondary_vs ) ) : ?>
				<!-- Secondary mini cards grid -->
				<div class="apollo-vehicles-secondary">
					<?php foreach ( $secondary_vs as $sv ) : ?>
					<article class="apollo-vehicle-mini">
						<a class="apollo-vehicle-mini__image" href="<?php echo esc_url( get_permalink( $sv->ID ) ); ?>">
							<?php if ( has_post_thumbnail( $sv->ID ) ) : ?>
								<?php echo get_the_post_thumbnail( $sv->ID, 'medium', array( 'loading' => 'lazy', 'alt' => esc_attr( get_the_title( $sv->ID ) ) ) ); ?>
							<?php else : ?>
								<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/a2.webp' ); ?>" alt="<?php echo esc_attr( get_the_title( $sv->ID ) ); ?>" loading="lazy">
							<?php endif; ?>
						</a>
						<div class="apollo-vehicle-mini__body">
							<h4><?php echo esc_html( get_the_title( $sv->ID ) ); ?></h4>
							<?php $mini_excerpt = get_the_excerpt( $sv->ID ); ?>
							<?php if ( $mini_excerpt ) : ?>
								<p><?php echo esc_html( wp_trim_words( $mini_excerpt, 10 ) ); ?></p>
							<?php endif; ?>
							<a href="<?php echo esc_url( get_permalink( $sv->ID ) ); ?>" class="apollo-vehicle-mini__cta">
								<?php esc_html_e( 'XEM CHI TIẾT', 'apollo' ); ?> →
							</a>
						</div>
					</article>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>

		<?php else : ?>
			<div class="apollo-empty">
				<h3><?php esc_html_e( 'Bộ sưu tập Apollo đang được cập nhật', 'apollo' ); ?></h3>
				<p><?php esc_html_e( 'Mẫu xe, hình ảnh và thông số sẽ xuất hiện tại đây sau khi có nội dung đã xác minh.', 'apollo' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- ═══════════════════════════ 4. KHÁM PHÁ GIAN HÀNG ══════════════ -->
<section class="apollo-section apollo-section--dark">
	<div class="apollo-shell">
		<div class="apollo-section__heading">
			<div>
				<span class="apollo-eyebrow"><?php esc_html_e( 'Gian hàng Apollo', 'apollo' ); ?></span>
				<h2><?php esc_html_e( 'KHÁM PHÁ GIAN HÀNG', 'apollo' ); ?></h2>
			</div>
		</div>
		<div class="apollo-category-grid">
			<?php if ( $apollo_categories ) : ?>
				<?php
				/* Category placeholder images from theme assets */
				$cat_fallbacks = array(
					get_stylesheet_directory_uri() . '/assets/images/a12.webp',
					get_stylesheet_directory_uri() . '/assets/images/a8.webp',
					get_stylesheet_directory_uri() . '/assets/images/a9.webp',
					get_stylesheet_directory_uri() . '/assets/images/ao1.webp',
				);
				$ci = 0;
				foreach ( $apollo_categories as $category ) :
					$thumbnail_id = absint( get_term_meta( $category->term_id, 'thumbnail_id', true ) );
					$img_url      = $thumbnail_id
						? wp_get_attachment_image_url( $thumbnail_id, 'woocommerce_thumbnail' )
						: ( $cat_fallbacks[ $ci % count( $cat_fallbacks ) ] ?? '' );
				?>
				<a class="apollo-cat-card" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
					<?php if ( $img_url ) : ?>
						<img class="apollo-cat-card__bg" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>" loading="lazy">
					<?php endif; ?>
					<span class="apollo-cat-card__overlay"></span>
					<span class="apollo-cat-card__body">
						<strong class="apollo-cat-card__name"><?php echo esc_html( $category->name ); ?></strong>
						<span class="apollo-cat-card__cta"><?php esc_html_e( 'Khám phá ngay', 'apollo' ); ?> →</span>
					</span>
				</a>
				<?php
				$ci++;
				endforeach;
				?>
			<?php else : ?>
				<?php
				$fallback_cats = array(
					array( 'name' => 'Mô hình siêu xe', 'img' => 'a12.webp', 'sub' => 'Sưu tầm mô hình' ),
					array( 'name' => 'Phụ kiện ô tô', 'img' => 'a8.webp', 'sub' => 'Nâng tầm trải nghiệm' ),
					array( 'name' => 'Đồ sưu tầm', 'img' => 'a9.webp', 'sub' => 'Giá trị vượt thời gian' ),
					array( 'name' => 'Thời trang motorsport', 'img' => 'ao1.webp', 'sub' => 'Phong cách chủ đề' ),
				);
				foreach ( $fallback_cats as $fcat ) :
				?>
				<a class="apollo-cat-card" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
					<img class="apollo-cat-card__bg" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $fcat['img'] ); ?>" alt="<?php echo esc_attr( $fcat['name'] ); ?>" loading="lazy">
					<span class="apollo-cat-card__overlay"></span>
					<span class="apollo-cat-card__body">
						<strong class="apollo-cat-card__name"><?php echo esc_html( $fcat['name'] ); ?></strong>
						<span class="apollo-cat-card__cta"><?php echo esc_html( $fcat['sub'] ); ?> →</span>
					</span>
				</a>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- ═══════════════════════════ 5. SẢN PHẨM ĐƯỢC QUAN TÂM ══════════ -->
<section class="apollo-section apollo-section--dark">
	<div class="apollo-shell">
		<div class="apollo-section__heading">
			<div>
				<span class="apollo-eyebrow"><?php esc_html_e( 'Gian hàng Apollo', 'apollo' ); ?></span>
				<h2><?php esc_html_e( 'SẢN PHẨM ĐƯỢC QUAN TÂM', 'apollo' ); ?></h2>
				<p><?php esc_html_e( 'Sản phẩm chỉ hiển thị khi có dữ liệu thực tế từ WooCommerce.', 'apollo' ); ?></p>
			</div>
			<a class="apollo-button apollo-button--outline" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
				<?php esc_html_e( 'XEM TẤT CẢ SẢN PHẨM', 'apollo' ); ?>
			</a>
		</div>

		<?php if ( $featured_products ) : ?>
			<ul class="products columns-4 apollo-product-grid">
				<?php
				global $post, $product;
				$orig_post    = $post;
				$orig_product = $product;
				foreach ( $featured_products as $product ) :
					if ( metadata_exists( 'post', $product->get_id(), '_product_price' ) ) {
						continue;
					}
					$post = get_post( $product->get_id() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $post );
					wc_get_template_part( 'content', 'product' );
				endforeach;
				wp_reset_postdata();
				$post    = $orig_post;    // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				$product = $orig_product;
				?>
			</ul>
		<?php else : ?>
			<div class="apollo-empty">
				<h3><?php esc_html_e( 'Gian hàng đang chờ catalog Apollo', 'apollo' ); ?></h3>
				<p><?php esc_html_e( 'Thêm sản phẩm từ WooCommerce để chúng xuất hiện ở đây.', 'apollo' ); ?></p>
				<a class="apollo-button" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=product' ) ); ?>">
					<?php esc_html_e( 'Thêm sản phẩm', 'apollo' ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- ═══════════════════════════ 6. DẤU ẤN PHONG CÁCH RIÊNG ══════════ -->
<section class="apollo-lifestyle">
	<div class="apollo-lifestyle__visual">
		<img
			src="<?php echo esc_url( $promo_img ); ?>"
			alt="<?php esc_attr_e( 'Bộ sưu tập phụ kiện và thời trang motorsport Apollo Automobil', 'apollo' ); ?>"
			loading="lazy"
		>
	</div>
	<div class="apollo-lifestyle__content">
		<span class="apollo-eyebrow"><?php esc_html_e( 'Bộ sưu tập độc quyền', 'apollo' ); ?></span>
		<h2><?php esc_html_e( 'DẤU ẤN PHONG CÁCH RIÊNG', 'apollo' ); ?></h2>
		<p><?php esc_html_e( 'Tìm hiểu và sở hữu những sản phẩm phụ kiện đặc biệt dành cho các tín đồ thể thao tốc độ. Từ mô hình sưu tầm cao cấp đến thời trang motorsport độc quyền.', 'apollo' ); ?></p>
		<a class="apollo-button" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
			<?php esc_html_e( 'KHÁM PHÁ NGAY', 'apollo' ); ?>
		</a>
	</div>
</section>

<!-- ═══════════════════════════ 7. VÌ SAO CHỌN APOLLO? ═════════════ -->
<section class="apollo-section apollo-why-section">
	<div class="apollo-shell">
		<div class="apollo-section__heading apollo-section__heading--center">
			<span class="apollo-eyebrow"><?php esc_html_e( 'Cam kết chất lượng', 'apollo' ); ?></span>
			<h2><?php esc_html_e( 'VÌ SAO CHỌN APOLLO AUTOMOBIL?', 'apollo' ); ?></h2>
		</div>
		<div class="apollo-why-grid">
			<div class="apollo-why-item">
				<div class="apollo-why-item__icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
						<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
					</svg>
				</div>
				<div class="apollo-why-item__text">
					<strong><?php esc_html_e( 'Thông tin minh bạch', 'apollo' ); ?></strong>
					<span><?php esc_html_e( 'Nội dung được cập nhật theo dữ liệu xác thực.', 'apollo' ); ?></span>
				</div>
			</div>
			<div class="apollo-why-item">
				<div class="apollo-why-item__icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
						<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
						<polyline points="14 2 14 8 20 8"/>
						<line x1="16" y1="13" x2="8" y2="13"/>
						<line x1="16" y1="17" x2="8" y2="17"/>
					</svg>
				</div>
				<div class="apollo-why-item__text">
					<strong><?php esc_html_e( 'Bộ sưu tập Apollo', 'apollo' ); ?></strong>
					<span><?php esc_html_e( 'Khám phá các mẫu xe và hình ảnh trưng bày.', 'apollo' ); ?></span>
				</div>
			</div>
			<div class="apollo-why-item">
				<div class="apollo-why-item__icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
						<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
						<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
					</svg>
				</div>
				<div class="apollo-why-item__text">
					<strong><?php esc_html_e( 'Gian hàng trực tuyến', 'apollo' ); ?></strong>
					<span><?php esc_html_e( 'Mô hình, phụ kiện và sản phẩm sưu tầm.', 'apollo' ); ?></span>
				</div>
			</div>
			<div class="apollo-why-item">
				<div class="apollo-why-item__icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
						<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
					</svg>
				</div>
				<div class="apollo-why-item__text">
					<strong><?php esc_html_e( 'Hỗ trợ khách hàng', 'apollo' ); ?></strong>
					<span><?php esc_html_e( 'Tư vấn tận tâm và chuyên nghiệp.', 'apollo' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ═══════════════════════════ 8. NEWSLETTER ═══════════════════════ -->
<section class="apollo-newsletter-section">
	<div class="apollo-shell">
		<span class="apollo-eyebrow"><?php esc_html_e( 'Tin tức Apollo', 'apollo' ); ?></span>
		<h2 class="apollo-newsletter__heading"><?php esc_html_e( 'CẬP NHẬT TỪ THẾ GIỚI APOLLO', 'apollo' ); ?></h2>
		<p class="apollo-newsletter__sub"><?php esc_html_e( 'Đăng ký để nhận thông tin mới nhất về xe, sản phẩm và chương trình ưu đãi.', 'apollo' ); ?></p>
		<form class="apollo-newsletter-form" id="apollo-newsletter-form" novalidate>
			<label class="apollo-screen-reader" for="apollo-newsletter-email"><?php esc_html_e( 'Địa chỉ email của bạn', 'apollo' ); ?></label>
			<input
				id="apollo-newsletter-email"
				type="email"
				name="email"
				placeholder="<?php esc_attr_e( 'Nhập địa chỉ email của bạn…', 'apollo' ); ?>"
				required
				autocomplete="email"
			>
			<button class="apollo-button" type="submit"><?php esc_html_e( 'ĐĂNG KÝ', 'apollo' ); ?></button>
		</form>
		<div class="apollo-newsletter__feedback" aria-live="polite" role="status"></div>
	</div>
</section>

</main>
<?php get_footer(); ?>
