<?php
/**
 * Template Name: Trang Về Chúng Tôi
 * @package techpro
 */
get_header();
?>

<section class="about-hero">
    <div class="container">
        <h1>Về TechPro</h1>
        <p>Hành trình 10 năm đồng hành cùng công nghệ Việt Nam</p>
    </div>
</section>

<section style="background:#fff; padding: 5rem 0;">
    <div class="container">
        <div class="about-grid">
            <div class="about-visual">🏢</div>
            <div>
                <h2>Câu chuyện của <span class="text-primary">TechPro</span></h2>
                <p>Được thành lập năm 2014, TechPro khởi đầu từ một cửa hàng nhỏ tại Quận 7, TP. Hồ Chí Minh với tầm nhìn mang đến những sản phẩm công nghệ chính hãng, chất lượng cao đến tay người tiêu dùng Việt Nam với mức giá cạnh tranh nhất.</p>
                <p>Sau 10 năm phát triển, TechPro đã trở thành một trong những nhà bán lẻ thiết bị điện tử uy tín hàng đầu, phục vụ hơn 50.000 khách hàng trên toàn quốc với hơn 500 dòng sản phẩm từ các thương hiệu công nghệ hàng đầu thế giới.</p>
                <p>Đội ngũ TechPro gồm hơn 200 nhân viên tận tâm, trong đó có nhiều kỹ thuật viên được chứng nhận bởi Apple, Samsung, Dell và các nhà sản xuất lớn khác.</p>
                <div class="values-grid" style="margin-top:2rem;">
                    <div class="value-item">
                        <h4>🎯 Sứ mệnh</h4>
                        <p>Mang công nghệ tốt nhất đến mọi người Việt Nam</p>
                    </div>
                    <div class="value-item">
                        <h4>👁️ Tầm nhìn</h4>
                        <p>Trở thành hệ sinh thái công nghệ số 1 Việt Nam</p>
                    </div>
                    <div class="value-item">
                        <h4>💡 Đổi mới</h4>
                        <p>Luôn cập nhật sản phẩm và công nghệ mới nhất</p>
                    </div>
                    <div class="value-item">
                        <h4>🤝 Tin cậy</h4>
                        <p>Cam kết 100% chính hãng, minh bạch về giá</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section style="background: #f8f9fa; padding: 5rem 0;">
    <div class="container">
        <h2 class="section-title">Những con số <span class="highlight">ấn tượng</span></h2>
        <p class="section-subtitle">Minh chứng cho 10 năm nỗ lực không ngừng</p>
        <div class="features-grid">
            <div class="feature-card" style="text-align:center;">
                <div style="font-size:3rem; font-weight:800; color: var(--primary);">10+</div>
                <h3>Năm kinh nghiệm</h3>
                <p>Hơn thập kỷ phát triển và khẳng định vị thế trong ngành bán lẻ công nghệ</p>
            </div>
            <div class="feature-card" style="text-align:center;">
                <div style="font-size:3rem; font-weight:800; color: var(--accent);">50K+</div>
                <h3>Khách hàng tin dùng</h3>
                <p>Hàng chục nghìn khách hàng trung thành trên toàn quốc quay lại mua hàng</p>
            </div>
            <div class="feature-card" style="text-align:center;">
                <div style="font-size:3rem; font-weight:800; color: var(--secondary);">500+</div>
                <h3>Dòng sản phẩm</h3>
                <p>Đa dạng sản phẩm từ các thương hiệu công nghệ hàng đầu thế giới</p>
            </div>
            <div class="feature-card" style="text-align:center;">
                <div style="font-size:3rem; font-weight:800; color: var(--primary);">200+</div>
                <h3>Nhân viên chuyên nghiệp</h3>
                <p>Đội ngũ được đào tạo bài bản, nhiệt tình và luôn đặt khách hàng lên hàng đầu</p>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Hãy cùng TechPro khám phá thế giới công nghệ!</h2>
        <p>Truy cập showroom hoặc mua sắm trực tuyến ngay hôm nay</p>
        <div class="cta-actions">
            <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="btn btn-primary">🛒 Xem sản phẩm</a>
            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-secondary">📞 Liên hệ ngay</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
