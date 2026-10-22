<?php
/**
 * TechPro Theme Footer
 * @package techpro
 */
?>

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="logo-text">Tech<span>Pro</span></div>
                <p class="footer-desc">
                    TechPro — Thương hiệu công nghệ hàng đầu Việt Nam. Chúng tôi cung cấp các giải pháp 
                    thiết bị điện tử thông minh, chất lượng cao với dịch vụ hỗ trợ tận tâm.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook">f</a>
                    <a href="#" class="social-link" aria-label="YouTube">▶</a>
                    <a href="#" class="social-link" aria-label="Zalo">Z</a>
                    <a href="#" class="social-link" aria-label="LinkedIn">in</a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Sản phẩm</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/san-pham/')); ?>">Tất cả sản phẩm</a></li>
                    <li><a href="<?php echo esc_url(home_url('/danh-muc/laptop')); ?>">Laptop</a></li>
                    <li><a href="<?php echo esc_url(home_url('/danh-muc/man-hinh')); ?>">Màn hình</a></li>
                    <li><a href="<?php echo esc_url(home_url('/danh-muc/phu-kien')); ?>">Phụ kiện</a></li>
                    <li><a href="<?php echo esc_url(home_url('/danh-muc/am-thanh')); ?>">Âm thanh</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Thông tin</h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/ve-chung-toi')); ?>">Về chúng tôi</a></li>
                    <li><a href="<?php echo esc_url(home_url('/danh-muc/')); ?>">Danh mục sản phẩm</a></li>
                    <li><a href="<?php echo esc_url(home_url('/lien-he/')); ?>">Liên hệ tư vấn</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Liên hệ</h4>
                <div class="footer-contact">
                    <span>📍 123 Đường Nguyễn Văn Linh,<br>Quận 7, TP. Hồ Chí Minh</span>
                    <a href="tel:+842899999999">📞 028 9999 9999</a>
                    <a href="mailto:info@techpro.vn">✉️ info@techpro.vn</a>
                    <span>🕐 T2–T7: 8:00 – 20:00</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© <?php echo date('Y'); ?> TechPro Việt Nam. Bảo lưu mọi quyền. | 
               <em>Dự án học thuật — MSSV: DTC245200863 — Triển Khai &amp; Quản Trị Hệ Thống</em>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
