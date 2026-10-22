<?php
/**
 * Template Name: Trang Liên Hệ
 * Contact page with server-side form processing
 *
 * @package techpro
 */

get_header();

// Pre-fill product name from URL param
$prefill_product = sanitize_text_field( $_GET['product'] ?? '' );
?>

<?php techpro_breadcrumb(); ?>

<section class="page-hero page-hero--small">
    <div class="container">
        <h1>Liên Hệ Với Chúng Tôi</h1>
        <p>Chúng tôi luôn sẵn sàng tư vấn và hỗ trợ bạn</p>
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

                <div class="contact-map" style="margin-top: 2rem;">
                    <p class="contact-label" style="margin-bottom: 0.5rem;">📍 Vị trí trên bản đồ</p>
                    <div style="background: linear-gradient(135deg, #f0f4ff, #e8f0fe); border-radius: 12px; padding: 3rem; text-align: center; color: var(--gray);">
                        <span style="font-size: 3rem;">🗺️</span>
                        <p style="margin-top: 1rem; font-size: 0.9rem;">Bản đồ sẽ hiển thị khi tích hợp Google Maps API.<br>
                        <em>Địa chỉ: 123 Nguyễn Văn Linh, Q.7, TP.HCM</em></p>
                    </div>
                </div>
            </div>

            <div class="contact-form-wrap">
                <h3>📬 Gửi yêu cầu cho chúng tôi</h3>

                <?php echo techpro_get_contact_status_message(); ?>

                <form id="contact-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" novalidate>
                    <?php wp_nonce_field('techpro_contact', 'techpro_contact_nonce'); ?>
                    <input type="hidden" name="action" value="techpro_contact">

                    <!-- Honeypot field (hidden from real users) -->
                    <div style="position:absolute;left:-9999px;" aria-hidden="true">
                        <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="contact-name">Họ và tên <span class="required">*</span></label>
                        <input type="text" id="contact-name" name="contact_name" required minlength="2" maxlength="100" placeholder="Nguyễn Văn A" autocomplete="name">
                        <span class="form-error" id="error-name">Vui lòng nhập họ tên (ít nhất 2 ký tự)</span>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-email">Email <span class="required">*</span></label>
                            <input type="email" id="contact-email" name="contact_email" required placeholder="email@example.com" autocomplete="email">
                            <span class="form-error" id="error-email">Vui lòng nhập email hợp lệ</span>
                        </div>
                        <div class="form-group">
                            <label for="contact-phone">Số điện thoại</label>
                            <input type="tel" id="contact-phone" name="contact_phone" placeholder="09xxxxxxxx" pattern="[0-9]{9,11}" autocomplete="tel">
                            <span class="form-error" id="error-phone">Số điện thoại không hợp lệ</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact-subject">Chủ đề</label>
                        <select id="contact-subject" name="contact_subject">
                            <option value="">— Chọn chủ đề —</option>
                            <option value="san-pham" <?php selected($prefill_product ? true : false); ?>>Tư vấn sản phẩm</option>
                            <option value="bao-hanh">Bảo hành & sửa chữa</option>
                            <option value="dat-hang">Đặt hàng số lượng lớn</option>
                            <option value="hop-tac">Hợp tác kinh doanh</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contact-message">Nội dung <span class="required">*</span></label>
                        <textarea id="contact-message" name="contact_message" required minlength="10" maxlength="2000" placeholder="Mô tả yêu cầu của bạn..."><?php if ($prefill_product) echo esc_textarea("Tôi quan tâm đến sản phẩm: {$prefill_product}\n\n"); ?></textarea>
                        <span class="form-error" id="error-message">Vui lòng nhập nội dung (ít nhất 10 ký tự)</span>
                    </div>

                    <div class="form-group form-group--checkbox">
                        <label>
                            <input type="checkbox" name="contact_privacy" value="1">
                            Tôi đồng ý với <a href="<?php echo esc_url(home_url('/chinh-sach-bao-mat')); ?>" target="_blank" rel="noopener">chính sách bảo mật</a> và cho phép TechPro lưu trữ thông tin liên hệ để phục vụ tư vấn.
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-submit" id="contact-submit" style="width:100%;">📨 Gửi yêu cầu</button>

                    <p class="form-note">
                        ⚠️ Lưu ý: Yêu cầu được lưu trữ trong hệ thống quản trị WordPress.
                        <?php if ( ! defined('TECHPRO_SMTP_CONFIGURED') || ! TECHPRO_SMTP_CONFIGURED ) : ?>
                        <br><em style="color:var(--gray);">Hệ thống chưa cấu hình SMTP nên email thông báo sẽ không được gửi tự động. Quản trị viên cần kiểm tra yêu cầu liên hệ trong WordPress Admin.</em>
                        <?php endif; ?>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
