<?php
/**
 * 404 Error Page Template
 *
 * @package techpro
 */

get_header();
?>

<section class="error-404-section">
    <div class="container">
        <div class="error-404-content">
            <div class="error-404-code">404</div>
            <h1>Trang không tồn tại</h1>
            <p>Xin lỗi, trang bạn đang tìm kiếm không tồn tại hoặc đã được di chuyển. Vui lòng kiểm tra lại đường dẫn hoặc quay về trang chủ.</p>

            <div class="error-404-search">
                <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-input-group">
                        <input type="text" name="s" class="products-search-input" placeholder="Tìm kiếm trên website..." aria-label="Tìm kiếm">
                        <button type="submit" class="products-search-btn" aria-label="Tìm kiếm">🔍</button>
                    </div>
                </form>
            </div>

            <div class="error-404-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">🏠 Về trang chủ</a>
                <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="btn btn-outline">📦 Xem sản phẩm</a>
                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-outline">📞 Liên hệ</a>
            </div>

            <div class="error-404-suggestions">
                <h3>Gợi ý cho bạn:</h3>
                <ul>
                    <li>Kiểm tra lại URL bạn đã nhập</li>
                    <li>Sử dụng thanh tìm kiếm phía trên</li>
                    <li>Truy cập <a href="<?php echo esc_url(home_url('/san-pham')); ?>">trang sản phẩm</a> để duyệt</li>
                    <li><a href="<?php echo esc_url(home_url('/lien-he')); ?>">Liên hệ</a> với chúng tôi nếu cần hỗ trợ</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
