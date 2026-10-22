<?php
/**
 * TechPro Homepage Template
 * Trang chủ với dữ liệu động từ WordPress
 *
 * @package techpro
 */
get_header();

// Query featured products
$featured_products = new WP_Query( [
    'post_type'      => 'product',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'meta_query'     => [ [ 'key' => '_product_featured', 'value' => '1' ] ],
] );

// Fallback: if no featured products, get latest products
if ( ! $featured_products->have_posts() ) {
    $featured_products = new WP_Query( [
        'post_type'      => 'product',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );
}

// Query categories
$categories = get_terms( [
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'number'     => 6,
] );

// Query latest posts
$latest_posts = new WP_Query( [
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
] );

// Query FAQs
$faqs = new WP_Query( [
    'post_type'      => 'faq',
    'posts_per_page' => 5,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
] );
?>

<!-- ======== HERO SECTION ======== -->
<section class="hero" id="hero">
    <div class="hero-content">
        <div class="hero-text">
            <span class="badge">⚡ Công nghệ tiên phong tại Việt Nam</span>
            <h1>Thiết Bị Công Nghệ <span>Thông Minh</span><br>Cho Cuộc Sống Hiện Đại</h1>
            <p>TechPro cung cấp các sản phẩm điện tử chất lượng cao — từ laptop hiệu năng mạnh mẽ đến smartphone thời thượng — với giá cả cạnh tranh và dịch vụ hậu mãi tận tâm.</p>
            <div class="hero-actions">
                <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="btn btn-primary">🛒 Khám phá sản phẩm</a>
                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-secondary">📞 Tư vấn miễn phí</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="number">500+</div>
                    <div class="label">Sản phẩm</div>
                </div>
                <div class="hero-stat">
                    <div class="number">50K+</div>
                    <div class="label">Khách hàng</div>
                </div>
                <div class="hero-stat">
                    <div class="number">10 năm</div>
                    <div class="label">Kinh nghiệm</div>
                </div>
                <div class="hero-stat">
                    <div class="number">4.9⭐</div>
                    <div class="label">Đánh giá</div>
                </div>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-mockup">
                <div class="mockup-header">
                    <div class="mockup-dot"></div>
                    <div class="mockup-dot"></div>
                    <div class="mockup-dot"></div>
                </div>
                <div class="mockup-screen">
                    <div class="mockup-bar accent"></div>
                    <div class="mockup-bar"></div>
                    <div class="mockup-bar medium"></div>
                    <div class="mockup-bar short"></div>
                    <div class="mockup-grid">
                        <div class="mockup-card"></div>
                        <div class="mockup-card"></div>
                        <div class="mockup-card"></div>
                        <div class="mockup-card"></div>
                    </div>
                    <div class="mockup-bar medium"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======== BRAND INTRO SECTION ======== -->
<section class="brand-intro">
    <div class="container">
        <div class="brand-intro-grid">
            <div class="brand-intro-visual">
                <div class="brand-logo-large">
                    <div class="logo-icon-lg">T</div>
                    <span class="logo-text-lg">Tech<span>Pro</span></span>
                </div>
                <p class="brand-tagline">Công nghệ — Chất lượng — Tin cậy</p>
            </div>
            <div class="brand-intro-content">
                <h2>Về <span class="highlight">TechPro</span></h2>
                <p>Được thành lập năm 2014, TechPro là thương hiệu bán lẻ thiết bị điện tử uy tín hàng đầu Việt Nam. Với hơn 10 năm kinh nghiệm, chúng tôi tự hào phục vụ hơn 50.000 khách hàng trên toàn quốc.</p>
                <p>Chúng tôi cam kết mang đến sản phẩm chính hãng 100%, giá cả cạnh tranh và dịch vụ hỗ trợ tận tâm nhất. Mỗi sản phẩm đều được kiểm định nghiêm ngặt trước khi đến tay khách hàng.</p>
                <a href="<?php echo esc_url(home_url('/ve-chung-toi')); ?>" class="btn btn-outline">Tìm hiểu thêm →</a>
            </div>
        </div>
    </div>
</section>

<!-- ======== FEATURES SECTION ======== -->
<section class="features" id="features">
    <div class="container">
        <h2 class="section-title">Tại sao chọn <span class="highlight">TechPro</span>?</h2>
        <p class="section-subtitle">Cam kết chất lượng — Giá tốt nhất thị trường — Hỗ trợ 24/7</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Bảo hành chính hãng</h3>
                <p>Tất cả sản phẩm đều được bảo hành chính hãng từ 12–24 tháng. Hỗ trợ đổi mới trong 30 ngày đầu nếu lỗi do nhà sản xuất.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3>Giao hàng nhanh toàn quốc</h3>
                <p>Giao hàng trong ngày tại TP.HCM và Hà Nội. Giao hàng toàn quốc trong 1–3 ngày làm việc với nhiều đơn vị vận chuyển uy tín.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💎</div>
                <h3>Sản phẩm chính hãng 100%</h3>
                <p>Nhập khẩu trực tiếp từ nhà sản xuất, đảm bảo 100% sản phẩm chính hãng, mới nguyên seal, đầy đủ phụ kiện theo hộp.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>Giá cạnh tranh nhất</h3>
                <p>Cam kết giá tốt nhất thị trường. Nếu bạn tìm thấy giá rẻ hơn, chúng tôi sẽ hoàn trả phần chênh lệch ngay lập tức.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📞</div>
                <h3>Hỗ trợ kỹ thuật 24/7</h3>
                <p>Đội ngũ kỹ thuật viên chuyên nghiệp luôn sẵn sàng hỗ trợ qua hotline, chat trực tuyến và email bất kỳ lúc nào.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔄</div>
                <h3>Thu cũ — Đổi mới</h3>
                <p>Dịch vụ thu mua thiết bị cũ với giá cao, hỗ trợ đổi mới linh hoạt. Thủ tục đơn giản, định giá minh bạch và công bằng.</p>
            </div>
        </div>
    </div>
</section>

<!-- ======== PRODUCT CATEGORIES ======== -->
<?php if ( $categories && ! is_wp_error($categories) && count($categories) > 0 ) : ?>
<section class="home-categories">
    <div class="container">
        <h2 class="section-title">Danh mục <span class="highlight">sản phẩm</span></h2>
        <p class="section-subtitle">Khám phá sản phẩm theo từng lĩnh vực</p>
        <div class="home-categories-grid">
            <?php
            $cat_icons = [
                'laptop'     => '💻',
                'smartphone' => '📱',
                'tablet'     => '📟',
                'phu-kien'   => '⌨️',
                'am-thanh'   => '🎧',
                'man-hinh'   => '🖥️',
            ];
            foreach ( $categories as $cat ) :
                $icon = $cat_icons[$cat->slug] ?? '📦';
                $cat_image = get_term_meta( $cat->term_id, '_category_image', true );
            ?>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="home-category-card">
                <div class="home-category-icon">
                    <?php if ( $cat_image ) : ?>
                        <img src="<?php echo esc_url(wp_get_attachment_image_url($cat_image, 'thumbnail')); ?>" alt="<?php echo esc_attr($cat->name); ?>">
                    <?php else : ?>
                        <span><?php echo $icon; ?></span>
                    <?php endif; ?>
                </div>
                <h3><?php echo esc_html($cat->name); ?></h3>
                <span class="home-category-count"><?php echo intval($cat->count); ?> sản phẩm</span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ======== FEATURED PRODUCTS ======== -->
<section class="products" id="products">
    <div class="container">
        <h2 class="section-title">Sản phẩm <span class="highlight">nổi bật</span></h2>
        <p class="section-subtitle">Những sản phẩm được khách hàng yêu thích nhất</p>

        <div class="products-grid">
            <?php if ( $featured_products->have_posts() ) : ?>
                <?php while ( $featured_products->have_posts() ) : $featured_products->the_post();
                    get_template_part( 'template-parts/product', 'card' );
                endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="no-results" style="grid-column:1/-1;">
                    <p>Sản phẩm đang được cập nhật. Vui lòng quay lại sau.</p>
                </div>
            <?php endif; ?>
        </div>

        <div style="text-align:center; margin-top:3rem;">
            <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="btn btn-outline">Xem tất cả sản phẩm →</a>
        </div>
    </div>
</section>

<!-- ======== SERVICES / POLICIES ======== -->
<section class="services-section">
    <div class="container">
        <h2 class="section-title">Dịch vụ & <span class="highlight">Chính sách</span></h2>
        <p class="section-subtitle">Cam kết mang đến trải nghiệm mua sắm tốt nhất</p>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">🚚</div>
                <h3>Giao hàng miễn phí</h3>
                <p>Miễn phí vận chuyển cho đơn hàng trên 500.000₫ tại TP.HCM và Hà Nội. Giao toàn quốc 1–3 ngày.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🔧</div>
                <h3>Bảo hành tận nơi</h3>
                <p>Đội ngũ kỹ thuật viên đến tận nơi sửa chữa và bảo hành sản phẩm tại TP.HCM.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">💳</div>
                <h3>Thanh toán linh hoạt</h3>
                <p>Hỗ trợ thanh toán tiền mặt, chuyển khoản, và trả góp 0% lãi suất qua các đối tác tài chính.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">📦</div>
                <h3>Đổi trả dễ dàng</h3>
                <p>Chính sách đổi trả trong 7 ngày nếu sản phẩm lỗi. Hoàn tiền 100% nếu sản phẩm không đúng mô tả.</p>
            </div>
        </div>
    </div>
</section>

<!-- ======== CTA SECTION ======== -->
<section class="cta">
    <div class="container">
        <h2>Sẵn sàng nâng cấp công nghệ của bạn?</h2>
        <p>Hơn 50.000 khách hàng đã tin tưởng TechPro. Tư vấn miễn phí, giao hàng tận nơi, bảo hành chính hãng.</p>
        <div class="cta-actions">
            <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="btn btn-primary">🛒 Xem sản phẩm ngay</a>
            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-secondary">💬 Tư vấn miễn phí</a>
        </div>
    </div>
</section>

<!-- ======== TESTIMONIALS ======== -->
<section class="testimonials" id="testimonials">
    <div class="container">
        <h2 class="section-title">Khách hàng <span class="highlight">nói gì</span> về TechPro?</h2>
        <p class="section-subtitle">Đánh giá từ khách hàng thực tế — <em>Nội dung demo mang tính minh họa</em></p>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"Mua chiếc TechPro UltraBook X15 được 3 tháng, máy chạy cực mượt, pin trâu hơn mong đợi. Giá so với các nơi khác thì TechPro rẻ hơn hẳn mà lại được tặng thêm balo và chuột."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">NM</div>
                    <div>
                        <div class="author-name">Nguyễn Minh Tuấn</div>
                        <div class="author-role">Kỹ sư phần mềm • TP.HCM</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"Đặt hàng lúc 9 giờ sáng, nhận máy lúc 2 giờ chiều cùng ngày. Nhân viên giao hàng rất chuyên nghiệp, hỗ trợ setup ban đầu tận tình. Chiếc Nova Z9 Ultra chụp ảnh đẹp!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">TL</div>
                    <div>
                        <div class="author-name">Trần Thị Lan</div>
                        <div class="author-role">Nhiếp ảnh gia • Hà Nội</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"TechPro là nơi tôi tin tưởng nhất. Sản phẩm chính hãng, nhân viên tư vấn nhiệt tình không ép mua. Dịch vụ bảo hành nhanh chóng và minh bạch."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">PH</div>
                    <div>
                        <div class="author-name">Phạm Hoàng Anh</div>
                        <div class="author-role">Doanh nhân • Đà Nẵng</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======== FAQ SECTION ======== -->
<?php if ( $faqs->have_posts() ) : ?>
<section class="home-faq">
    <div class="container">
        <h2 class="section-title">Câu hỏi <span class="highlight">thường gặp</span></h2>
        <p class="section-subtitle">Giải đáp nhanh những thắc mắc phổ biến</p>
        <div class="faq-container faq-container--home">
            <?php while ( $faqs->have_posts() ) : $faqs->the_post(); ?>
            <div class="faq-item">
                <button class="faq-question" aria-expanded="false">
                    <span><?php the_title(); ?></span>
                    <span class="faq-toggle">+</span>
                </button>
                <div class="faq-answer" role="region">
                    <div class="faq-answer-inner">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <div style="text-align:center;margin-top:2rem;">
            <a href="<?php echo esc_url(home_url('/cau-hoi-thuong-gap')); ?>" class="btn btn-outline">Xem tất cả câu hỏi →</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ======== LATEST NEWS ======== -->
<?php if ( $latest_posts->have_posts() ) : ?>
<section class="home-news">
    <div class="container">
        <h2 class="section-title">Tin tức <span class="highlight">mới nhất</span></h2>
        <p class="section-subtitle">Cập nhật thông tin công nghệ và khuyến mãi hấp dẫn</p>
        <div class="news-grid">
            <?php while ( $latest_posts->have_posts() ) : $latest_posts->the_post(); ?>
            <article class="news-card">
                <a href="<?php the_permalink(); ?>" class="news-card-link">
                    <div class="news-card-image">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'product-card', [ 'alt' => esc_attr(get_the_title()), 'loading' => 'lazy' ] ); ?>
                        <?php else : ?>
                            <span class="news-card-placeholder">📰</span>
                        <?php endif; ?>
                    </div>
                    <div class="news-card-content">
                        <div class="news-card-meta">
                            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d/m/Y'); ?></time>
                        </div>
                        <h3 class="news-card-title"><?php the_title(); ?></h3>
                        <p class="news-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                        <span class="news-card-readmore">Đọc thêm →</span>
                    </div>
                </a>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <div style="text-align:center;margin-top:2rem;">
            <a href="<?php echo esc_url(home_url('/tin-tuc')); ?>" class="btn btn-outline">Xem tất cả tin tức →</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ======== CONTACT CTA ======== -->
<section class="contact-cta">
    <div class="container">
        <div class="contact-cta-grid">
            <div>
                <h2>Bạn cần tư vấn?</h2>
                <p>Đội ngũ chuyên gia TechPro luôn sẵn sàng hỗ trợ bạn chọn sản phẩm phù hợp nhất.</p>
            </div>
            <div class="contact-cta-actions">
                <a href="tel:+842899999999" class="btn btn-primary btn-lg">📞 Gọi ngay: 028 9999 9999</a>
                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-outline btn-lg">📬 Gửi yêu cầu liên hệ</a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
