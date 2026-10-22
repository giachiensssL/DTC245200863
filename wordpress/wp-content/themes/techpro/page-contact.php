<?php
/**
 * Template Name: Trang Liên Hệ
 * @package techpro
 */
get_header();
?>

<section class="about-hero" style="padding: 4rem 0;">
    <div class="container">
        <h1>Liên Hệ Với Chúng Tôi</h1>
        <p>Chúng tôi luôn sẵn sàng tư vấn và hỗ trợ bạn 24/7</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2>Thông tin <span class="text-primary">liên lạc</span></h2>
                <p>Hãy liên hệ với chúng tôi qua bất kỳ kênh nào dưới đây. Đội ngũ TechPro sẽ phản hồi trong vòng 30 phút trong giờ làm việc.</p>

                <div class="contact-item">
                    <div class="contact-icon">📍</div>
                    <div>
                        <div class="contact-label">Địa chỉ</div>
                        <div class="contact-value">123 Đường Nguyễn Văn Linh, Phường Tân Phong,<br>Quận 7, TP. Hồ Chí Minh</div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">📞</div>
                    <div>
                        <div class="contact-label">Hotline</div>
                        <div class="contact-value"><a href="tel:+842899999999">028 9999 9999</a></div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">✉️</div>
                    <div>
                        <div class="contact-label">Email</div>
                        <div class="contact-value"><a href="mailto:info@techpro.vn">info@techpro.vn</a></div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">🕐</div>
                    <div>
                        <div class="contact-label">Giờ làm việc</div>
                        <div class="contact-value">Thứ Hai – Thứ Bảy: 8:00 – 20:00<br>Chủ Nhật: 9:00 – 18:00</div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">💬</div>
                    <div>
                        <div class="contact-label">Mạng xã hội</div>
                        <div class="contact-value">Facebook: fb.com/techpro.vn<br>Zalo OA: TechPro Official</div>
                    </div>
                </div>
            </div>

            <div class="contact-form-wrap">
                <h3>📬 Gửi yêu cầu cho chúng tôi</h3>
                <?php
                if ( isset($_GET['success']) && $_GET['success'] === '1' ) {
                    echo '<div style="background:#e8f5e9;border-left:4px solid #4caf50;padding:1rem;border-radius:8px;margin-bottom:1.5rem;color:#2e7d32;">
                        ✅ <strong>Cảm ơn bạn đã liên hệ!</strong> Chúng tôi sẽ phản hồi trong thời gian sớm nhất.
                    </div>';
                }
                ?>
                <form id="contact-form" action="" method="post">
                    <?php wp_nonce_field('techpro_contact', 'techpro_contact_nonce'); ?>
                    <div class="form-group">
                        <label for="contact-name">Họ và tên *</label>
                        <input type="text" id="contact-name" name="contact_name" required placeholder="Nguyễn Văn A">
                    </div>
                    <div class="form-group">
                        <label for="contact-email">Email *</label>
                        <input type="email" id="contact-email" name="contact_email" required placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="contact-phone">Số điện thoại</label>
                        <input type="tel" id="contact-phone" name="contact_phone" placeholder="09xxxxxxxx">
                    </div>
                    <div class="form-group">
                        <label for="contact-subject">Chủ đề</label>
                        <select id="contact-subject" name="contact_subject">
                            <option value="">-- Chọn chủ đề --</option>
                            <option value="san-pham">Tư vấn sản phẩm</option>
                            <option value="bao-hanh">Bảo hành & sửa chữa</option>
                            <option value="dat-hang">Đặt hàng số lượng lớn</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contact-message">Nội dung *</label>
                        <textarea id="contact-message" name="contact_message" required placeholder="Mô tả yêu cầu của bạn..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">📨 Gửi tin nhắn</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
