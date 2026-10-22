<?php
/**
 * TechPro Homepage Template
 * @package techpro
 */
get_header();
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

<!-- ======== FEATURES SECTION ======== -->
<section class="features">
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

<!-- ======== FEATURED PRODUCTS ======== -->
<section class="products">
    <div class="container">
        <h2 class="section-title">Sản phẩm <span class="highlight">nổi bật</span></h2>
        <p class="section-subtitle">Những sản phẩm được khách hàng yêu thích nhất tháng này</p>

        <div class="products-filter">
            <button class="filter-btn active">Tất cả</button>
            <button class="filter-btn">Laptop</button>
            <button class="filter-btn">Smartphone</button>
            <button class="filter-btn">Tablet</button>
            <button class="filter-btn">Phụ kiện</button>
        </div>

        <div class="products-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <div class="product-image">
                    <span>💻</span>
                    <span class="product-badge">Hot</span>
                </div>
                <div class="product-info">
                    <div class="product-category">Laptop</div>
                    <div class="product-name">TechPro UltraBook X15 Pro</div>
                    <div class="product-desc">Intel Core i7-13700H, RAM 16GB, SSD 512GB, màn hình OLED 15.6" 2.8K</div>
                    <div class="product-footer">
                        <div class="product-price">
                            28.990.000₫
                            <span class="original">35.000.000₫</span>
                        </div>
                        <a href="#" class="product-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <!-- Product 2 -->
            <div class="product-card">
                <div class="product-image" style="background: linear-gradient(135deg,#f0fff4,#e8fef0)">
                    <span>📱</span>
                    <span class="product-badge new">Mới</span>
                </div>
                <div class="product-info">
                    <div class="product-category">Smartphone</div>
                    <div class="product-name">TechPro Nova Z9 Ultra</div>
                    <div class="product-desc">Snapdragon 8 Gen 3, RAM 12GB, camera 200MP, pin 5000mAh sạc 120W</div>
                    <div class="product-footer">
                        <div class="product-price">
                            18.490.000₫
                            <span class="original">22.000.000₫</span>
                        </div>
                        <a href="#" class="product-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="product-card">
                <div class="product-image" style="background: linear-gradient(135deg,#fff8f0,#fef0e8)">
                    <span>📟</span>
                    <span class="product-badge">Sale</span>
                </div>
                <div class="product-info">
                    <div class="product-category">Tablet</div>
                    <div class="product-name">TechPro Pad Pro 12.9</div>
                    <div class="product-desc">Chip M3, màn hình Liquid Retina XDR, 256GB, hỗ trợ bút cảm ứng thế hệ 2</div>
                    <div class="product-footer">
                        <div class="product-price">
                            22.990.000₫
                            <span class="original">28.000.000₫</span>
                        </div>
                        <a href="#" class="product-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <!-- Product 4 -->
            <div class="product-card">
                <div class="product-image" style="background: linear-gradient(135deg,#f8f0ff,#f0e8ff)">
                    <span>🎧</span>
                </div>
                <div class="product-info">
                    <div class="product-category">Âm thanh</div>
                    <div class="product-name">TechPro SoundElite ANC Pro</div>
                    <div class="product-desc">Tai nghe chống ồn chủ động ANC, driver 40mm, kết nối Bluetooth 5.3, pin 30 giờ</div>
                    <div class="product-footer">
                        <div class="product-price">
                            3.490.000₫
                            <span class="original">4.500.000₫</span>
                        </div>
                        <a href="#" class="product-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <!-- Product 5 -->
            <div class="product-card">
                <div class="product-image" style="background: linear-gradient(135deg,#f0f8ff,#e8f4ff)">
                    <span>⌨️</span>
                    <span class="product-badge new">Mới</span>
                </div>
                <div class="product-info">
                    <div class="product-category">Phụ kiện</div>
                    <div class="product-name">TechPro MechKey Elite RGB</div>
                    <div class="product-desc">Bàn phím cơ TKL, switch Gateron Yellow Pro, đèn RGB per-key, hot-swap socket</div>
                    <div class="product-footer">
                        <div class="product-price">
                            2.290.000₫
                            <span class="original">2.890.000₫</span>
                        </div>
                        <a href="#" class="product-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <!-- Product 6 -->
            <div class="product-card">
                <div class="product-image" style="background: linear-gradient(135deg,#fff0f5,#ffe8f0)">
                    <span>🖥️</span>
                    <span class="product-badge">Hot</span>
                </div>
                <div class="product-info">
                    <div class="product-category">Màn hình</div>
                    <div class="product-name">TechPro ProDisplay 4K 27"</div>
                    <div class="product-desc">IPS 4K 144Hz, độ phủ màu 100% sRGB, cổng USB-C 90W, đế chỉnh độ cao</div>
                    <div class="product-footer">
                        <div class="product-price">
                            8.990.000₫
                            <span class="original">11.500.000₫</span>
                        </div>
                        <a href="#" class="product-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align:center; margin-top:3rem;">
            <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="btn btn-outline">Xem tất cả sản phẩm →</a>
        </div>
    </div>
</section>

<!-- ======== CTA SECTION ======== -->
<section class="cta">
    <div class="container">
        <h2>Sẵn sàng nâng cấp công nghệ của bạn?</h2>
        <p>Hơn 50.000 khách hàng đã tin tưởng TechPro. Tư vấn miễn phí, giao hàng tận nơi, bảo hành chính hãng.</p>
        <div class="cta-actions">
            <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="btn btn-primary">🛒 Mua ngay hôm nay</a>
            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-secondary">💬 Chat với chuyên viên</a>
        </div>
    </div>
</section>

<!-- ======== TESTIMONIALS ======== -->
<section class="testimonials">
    <div class="container">
        <h2 class="section-title">Khách hàng <span class="highlight">nói gì</span> về TechPro?</h2>
        <p class="section-subtitle">Hàng nghìn phản hồi tích cực từ khách hàng thực</p>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"Mua chiếc TechPro UltraBook X15 được 3 tháng, máy chạy cực mượt, pin trâu hơn mong đợi. Giá so với các nơi khác thì TechPro rẻ hơn hẳn mà lại được tặng thêm balo và chuột. Sẽ tiếp tục ủng hộ!"</p>
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
                <p class="testimonial-text">"Đặt hàng lúc 9 giờ sáng, nhận máy lúc 2 giờ chiều cùng ngày. Nhân viên giao hàng rất chuyên nghiệp, hỗ trợ setup ban đầu tận tình. Chiếc Nova Z9 Ultra chụp ảnh đẹp không thua gì máy ảnh!"</p>
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
                <p class="testimonial-text">"Đã mua qua nhiều cửa hàng khác nhau nhưng TechPro là nơi tôi tin tưởng nhất. Sản phẩm chính hãng, nhân viên tư vấn nhiệt tình không ép mua. Đặc biệt dịch vụ bảo hành nhanh chóng và minh bạch."</p>
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

<?php get_footer(); ?>
