<?php
/**
 * TechPro Theme Functions
 * Theme: TechPro — Website Giới Thiệu Sản Phẩm Công Nghệ
 * Student ID: DTC245200863
 *
 * @package techpro
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ============================================================
// THEME SETUP
// ============================================================
function techpro_setup() {
    load_theme_textdomain( 'techpro', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    register_nav_menus( [
        'primary' => __( 'Menu Chính', 'techpro' ),
        'footer'  => __( 'Menu Footer', 'techpro' ),
    ] );

    // Image sizes for products
    add_image_size( 'product-card', 400, 300, true );
    add_image_size( 'product-detail', 800, 600, true );
    add_image_size( 'product-gallery-thumb', 150, 150, true );
}
add_action( 'after_setup_theme', 'techpro_setup' );

// ============================================================
// ENQUEUE STYLES & SCRIPTS
// ============================================================
function techpro_scripts() {
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', [], null );
    wp_enqueue_style( 'techpro-style', get_stylesheet_uri(), [ 'google-fonts' ], '2.1.0' );
    wp_enqueue_script( 'techpro-main', get_template_directory_uri() . '/assets/js/main.js', [], '2.0.0', true );

    // Pass AJAX URL and nonce to JavaScript
    wp_localize_script( 'techpro-main', 'techpro_ajax', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'techpro_nonce' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'techpro_scripts' );

// ============================================================
// WIDGET AREAS
// ============================================================
function techpro_widgets_init() {
    register_sidebar( [
        'name'          => __( 'Footer Widget Area', 'techpro' ),
        'id'            => 'footer-widget',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ] );
}
add_action( 'widgets_init', 'techpro_widgets_init' );

// ============================================================
// CUSTOM POST TYPE: PRODUCTS
// ============================================================
function techpro_register_product_cpt() {
    $labels = [
        'name'               => 'Sản phẩm',
        'singular_name'      => 'Sản phẩm',
        'add_new'            => 'Thêm sản phẩm',
        'add_new_item'       => 'Thêm sản phẩm mới',
        'edit_item'          => 'Chỉnh sửa sản phẩm',
        'new_item'           => 'Sản phẩm mới',
        'view_item'          => 'Xem sản phẩm',
        'search_items'       => 'Tìm kiếm sản phẩm',
        'not_found'          => 'Không tìm thấy sản phẩm',
        'not_found_in_trash' => 'Không có sản phẩm trong thùng rác',
        'all_items'          => 'Tất cả sản phẩm',
        'menu_name'          => 'Sản phẩm',
    ];
    register_post_type( 'product', [
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'san-pham', 'with_front' => false ],
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ],
        'menu_icon'     => 'dashicons-products',
        'show_in_rest'  => true,
        'taxonomies'    => [ 'product_cat' ],
    ] );
}
add_action( 'init', 'techpro_register_product_cpt' );

// ============================================================
// TAXONOMY: PRODUCT CATEGORY
// ============================================================
function techpro_register_product_taxonomy() {
    register_taxonomy( 'product_cat', 'product', [
        'labels'       => [
            'name'              => 'Danh mục sản phẩm',
            'singular_name'     => 'Danh mục',
            'add_new_item'      => 'Thêm danh mục mới',
            'edit_item'         => 'Chỉnh sửa danh mục',
            'search_items'      => 'Tìm danh mục',
            'all_items'         => 'Tất cả danh mục',
            'parent_item'       => 'Danh mục cha',
            'parent_item_colon' => 'Danh mục cha:',
            'menu_name'         => 'Danh mục SP',
        ],
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => [ 'slug' => 'danh-muc', 'with_front' => false ],
        'show_in_rest'  => true,
        'show_admin_column' => true,
    ] );
}
add_action( 'init', 'techpro_register_product_taxonomy' );

// ============================================================
// CUSTOM POST TYPE: FAQ
// ============================================================
function techpro_register_faq_cpt() {
    register_post_type( 'faq', [
        'labels' => [
            'name'          => 'Câu hỏi thường gặp',
            'singular_name' => 'Câu hỏi',
            'add_new'       => 'Thêm câu hỏi',
            'add_new_item'  => 'Thêm câu hỏi mới',
            'edit_item'     => 'Chỉnh sửa câu hỏi',
            'all_items'     => 'Tất cả câu hỏi',
            'menu_name'     => 'FAQ',
        ],
        'public'        => true,
        'has_archive'   => false,
        'rewrite'       => [ 'slug' => 'faq-item', 'with_front' => false ],
        'supports'      => [ 'title', 'editor' ],
        'menu_icon'     => 'dashicons-editor-help',
        'show_in_rest'  => true,
        'exclude_from_search' => true,
    ] );
}
add_action( 'init', 'techpro_register_faq_cpt' );

// ============================================================
// CUSTOM POST TYPE: CONTACT SUBMISSIONS
// ============================================================
function techpro_register_contact_cpt() {
    register_post_type( 'contact_submission', [
        'labels' => [
            'name'          => 'Yêu cầu liên hệ',
            'singular_name' => 'Yêu cầu',
            'all_items'     => 'Tất cả yêu cầu',
            'search_items'  => 'Tìm yêu cầu',
            'edit_item'     => 'Xem yêu cầu',
            'menu_name'     => 'Liên hệ',
        ],
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'supports'            => [ 'title' ],
        'menu_icon'           => 'dashicons-email-alt',
        'show_in_rest'        => false,
    ] );
}
add_action( 'init', 'techpro_register_contact_cpt' );

// ============================================================
// PRODUCT META BOXES
// ============================================================
function techpro_add_product_meta_boxes() {
    add_meta_box(
        'techpro_product_details',
        'Chi tiết sản phẩm',
        'techpro_product_details_callback',
        'product',
        'normal',
        'high'
    );
    add_meta_box(
        'techpro_product_gallery',
        'Thư viện ảnh sản phẩm',
        'techpro_product_gallery_callback',
        'product',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'techpro_add_product_meta_boxes' );

function techpro_product_details_callback( $post ) {
    wp_nonce_field( 'techpro_product_nonce', 'techpro_product_nonce' );
    $price      = get_post_meta( $post->ID, '_product_price', true );
    $old_price  = get_post_meta( $post->ID, '_product_old_price', true );
    $features   = get_post_meta( $post->ID, '_product_features', true );
    $badge      = get_post_meta( $post->ID, '_product_badge', true );
    $sku        = get_post_meta( $post->ID, '_product_sku', true );
    $stock      = get_post_meta( $post->ID, '_product_stock_status', true );
    $specs      = get_post_meta( $post->ID, '_product_specs', true );
    $featured   = get_post_meta( $post->ID, '_product_featured', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="product_price">Giá hiện tại (VND)</label></th>
            <td><input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>" class="regular-text" placeholder="ví dụ: 12.990.000"></td>
        </tr>
        <tr>
            <th><label for="product_old_price">Giá gốc (VND)</label></th>
            <td><input type="text" id="product_old_price" name="product_old_price" value="<?php echo esc_attr($old_price); ?>" class="regular-text" placeholder="ví dụ: 15.000.000"></td>
        </tr>
        <tr>
            <th><label for="product_badge">Nhãn (badge)</label></th>
            <td><input type="text" id="product_badge" name="product_badge" value="<?php echo esc_attr($badge); ?>" class="regular-text" placeholder="ví dụ: Mới, Hot, Sale"></td>
        </tr>
        <tr>
            <th><label for="product_sku">Mã SKU</label></th>
            <td><input type="text" id="product_sku" name="product_sku" value="<?php echo esc_attr($sku); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="product_stock_status">Tình trạng kho</label></th>
            <td>
                <select id="product_stock_status" name="product_stock_status">
                    <option value="instock" <?php selected($stock, 'instock'); ?>>Còn hàng</option>
                    <option value="outofstock" <?php selected($stock, 'outofstock'); ?>>Tạm hết hàng</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="product_featured">Sản phẩm nổi bật</label></th>
            <td>
                <label><input type="checkbox" id="product_featured" name="product_featured" value="1" <?php checked($featured, '1'); ?>> Hiển thị ở trang chủ</label>
            </td>
        </tr>
        <tr>
            <th><label for="product_features">Tính năng nổi bật</label></th>
            <td><textarea id="product_features" name="product_features" rows="5" class="large-text"><?php echo esc_textarea($features); ?></textarea><p class="description">Mỗi tính năng một dòng</p></td>
        </tr>
        <tr>
            <th><label for="product_specs">Thông số kỹ thuật</label></th>
            <td><textarea id="product_specs" name="product_specs" rows="5" class="large-text"><?php echo esc_textarea($specs); ?></textarea><p class="description">Mỗi thông số một dòng (Tên: Giá trị)</p></td>
        </tr>
    </table>
    <?php
}

function techpro_product_gallery_callback( $post ) {
    $gallery = get_post_meta( $post->ID, '_product_gallery', true );
    $gallery_ids = $gallery ? explode( ',', $gallery ) : [];
    ?>
    <div id="techpro-gallery-container">
        <div id="techpro-gallery-images" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
            <?php foreach ( $gallery_ids as $img_id ) :
                $img_id = intval( $img_id );
                if ( $img_id ) :
                    $thumb = wp_get_attachment_image_src( $img_id, 'thumbnail' );
                    if ( $thumb ) : ?>
                        <div class="techpro-gallery-item" data-id="<?php echo $img_id; ?>" style="position:relative;">
                            <img src="<?php echo esc_url($thumb[0]); ?>" style="width:80px;height:80px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">
                            <button type="button" class="techpro-gallery-remove" style="position:absolute;top:-6px;right:-6px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;line-height:20px;padding:0;">×</button>
                        </div>
                    <?php endif;
                endif;
            endforeach; ?>
        </div>
        <input type="hidden" name="product_gallery" id="product_gallery" value="<?php echo esc_attr($gallery); ?>">
        <button type="button" id="techpro-gallery-add" class="button">Thêm ảnh</button>
    </div>
    <script>
    jQuery(function($) {
        var frame;
        $('#techpro-gallery-add').on('click', function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'Chọn ảnh cho thư viện', multiple: true, library: { type: 'image' }, button: { text: 'Thêm vào thư viện' } });
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                var currentIds = $('#product_gallery').val() ? $('#product_gallery').val().split(',') : [];
                attachments.forEach(function(att) {
                    currentIds.push(att.id);
                    var thumb = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                    $('#techpro-gallery-images').append(
                        '<div class="techpro-gallery-item" data-id="'+att.id+'" style="position:relative;">' +
                        '<img src="'+thumb+'" style="width:80px;height:80px;object-fit:cover;border-radius:4px;border:1px solid #ddd;">' +
                        '<button type="button" class="techpro-gallery-remove" style="position:absolute;top:-6px;right:-6px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:20px;height:20px;cursor:pointer;font-size:12px;line-height:20px;padding:0;">×</button>' +
                        '</div>'
                    );
                });
                $('#product_gallery').val(currentIds.filter(Boolean).join(','));
            });
            frame.open();
        });
        $(document).on('click', '.techpro-gallery-remove', function() {
            var item = $(this).closest('.techpro-gallery-item');
            var removeId = item.data('id').toString();
            item.remove();
            var ids = $('#product_gallery').val().split(',').filter(function(id) { return id !== removeId; });
            $('#product_gallery').val(ids.join(','));
        });
    });
    </script>
    <?php
}

function techpro_save_product_meta( $post_id ) {
    if ( ! isset( $_POST['techpro_product_nonce'] ) || ! wp_verify_nonce( $_POST['techpro_product_nonce'], 'techpro_product_nonce' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $text_fields = [ 'product_price', 'product_old_price', 'product_badge', 'product_sku' ];
    foreach ( $text_fields as $field ) {
        if ( isset( $_POST[$field] ) ) {
            update_post_meta( $post_id, '_' . $field, sanitize_text_field( $_POST[$field] ) );
        }
    }
    if ( isset( $_POST['product_stock_status'] ) ) {
        $stock = sanitize_key( $_POST['product_stock_status'] );
        update_post_meta( $post_id, '_product_stock_status', in_array( $stock, [ 'instock', 'outofstock' ], true ) ? $stock : 'outofstock' );
    }

    $textarea_fields = [ 'product_features', 'product_specs' ];
    foreach ( $textarea_fields as $field ) {
        if ( isset( $_POST[$field] ) ) {
            update_post_meta( $post_id, '_' . $field, sanitize_textarea_field( $_POST[$field] ) );
        }
    }

    // Featured checkbox
    $featured = isset( $_POST['product_featured'] ) ? '1' : '';
    update_post_meta( $post_id, '_product_featured', $featured );

    // Gallery
    if ( isset( $_POST['product_gallery'] ) ) {
        $gallery_ids = array_filter( array_map( 'intval', explode( ',', $_POST['product_gallery'] ) ) );
        update_post_meta( $post_id, '_product_gallery', implode( ',', $gallery_ids ) );
    }
}
add_action( 'save_post_product', 'techpro_save_product_meta' );

// ============================================================
// CONTACT SUBMISSION META BOX
// ============================================================
function techpro_contact_meta_boxes() {
    add_meta_box(
        'techpro_contact_details',
        'Thông tin liên hệ',
        'techpro_contact_details_callback',
        'contact_submission',
        'normal',
        'high'
    );
    add_meta_box(
        'techpro_contact_status',
        'Trạng thái xử lý',
        'techpro_contact_status_callback',
        'contact_submission',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'techpro_contact_meta_boxes' );

function techpro_contact_details_callback( $post ) {
    $name    = get_post_meta( $post->ID, '_contact_name', true );
    $email   = get_post_meta( $post->ID, '_contact_email', true );
    $phone   = get_post_meta( $post->ID, '_contact_phone', true );
    $subject = get_post_meta( $post->ID, '_contact_subject', true );
    $message = get_post_meta( $post->ID, '_contact_message', true );
    $date    = get_post_meta( $post->ID, '_contact_date', true );
    $ip      = get_post_meta( $post->ID, '_contact_ip', true );

    $subjects = [
        'san-pham'  => 'Tư vấn sản phẩm',
        'bao-hanh'  => 'Bảo hành & sửa chữa',
        'dat-hang'  => 'Đặt hàng số lượng lớn',
        'hop-tac'   => 'Hợp tác kinh doanh',
        'khac'      => 'Khác',
    ];
    ?>
    <table class="form-table">
        <tr><th>Họ và tên</th><td><strong><?php echo esc_html($name); ?></strong></td></tr>
        <tr><th>Email</th><td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td></tr>
        <tr><th>Số điện thoại</th><td><?php echo esc_html($phone ?: '—'); ?></td></tr>
        <tr><th>Chủ đề</th><td><?php echo esc_html($subjects[$subject] ?? $subject ?: '—'); ?></td></tr>
        <tr><th>Nội dung</th><td><div style="background:#f9f9f9;padding:12px;border-radius:6px;border:1px solid #eee;white-space:pre-wrap;"><?php echo esc_html($message); ?></div></td></tr>
        <tr><th>Thời gian gửi</th><td><?php echo esc_html($date ?: '—'); ?></td></tr>
        <tr><th>Đồng ý chính sách</th><td><?php echo get_post_meta($post->ID, '_contact_privacy', true) ? '✅ Đã đồng ý' : '—'; ?></td></tr>
    </table>
    <?php
}

function techpro_contact_status_callback( $post ) {
    $status = get_post_meta( $post->ID, '_contact_status', true ) ?: 'new';
    wp_nonce_field( 'techpro_contact_status_nonce', 'techpro_contact_status_nonce' );
    ?>
    <select name="contact_status" style="width:100%;padding:6px;">
        <option value="new" <?php selected($status, 'new'); ?>>🔵 Mới</option>
        <option value="processing" <?php selected($status, 'processing'); ?>>🟡 Đang xử lý</option>
        <option value="completed" <?php selected($status, 'completed'); ?>>🟢 Đã xử lý</option>
        <option value="spam" <?php selected($status, 'spam'); ?>>🔴 Spam</option>
    </select>
    <p class="description" style="margin-top:8px;">Cập nhật trạng thái xử lý yêu cầu.</p>
    <?php
}

function techpro_save_contact_status( $post_id ) {
    if ( ! isset( $_POST['techpro_contact_status_nonce'] ) || ! wp_verify_nonce( $_POST['techpro_contact_status_nonce'], 'techpro_contact_status_nonce' ) ) return;
    if ( get_post_type( $post_id ) !== 'contact_submission' ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['contact_status'] ) ) {
        $allowed = [ 'new', 'processing', 'completed', 'spam' ];
        $value = sanitize_text_field( $_POST['contact_status'] );
        if ( in_array( $value, $allowed, true ) ) {
            update_post_meta( $post_id, '_contact_status', $value );
        }
    }
}
add_action( 'save_post_contact_submission', 'techpro_save_contact_status' );

// Contact admin columns
function techpro_contact_admin_columns( $columns ) {
    return [
        'cb'             => '<input type="checkbox">',
        'title'          => 'Tiêu đề',
        'contact_name'   => 'Họ tên',
        'contact_email'  => 'Email',
        'contact_subject'=> 'Chủ đề',
        'contact_status' => 'Trạng thái',
        'date'           => 'Ngày',
    ];
}
add_filter( 'manage_contact_submission_posts_columns', 'techpro_contact_admin_columns' );

function techpro_contact_admin_column_data( $column, $post_id ) {
    switch ( $column ) {
        case 'contact_name':
            echo esc_html( get_post_meta( $post_id, '_contact_name', true ) );
            break;
        case 'contact_email':
            $email = get_post_meta( $post_id, '_contact_email', true );
            echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            break;
        case 'contact_subject':
            $subjects = [ 'san-pham' => 'Tư vấn SP', 'bao-hanh' => 'Bảo hành', 'dat-hang' => 'Đặt hàng', 'hop-tac' => 'Hợp tác', 'khac' => 'Khác' ];
            $val = get_post_meta( $post_id, '_contact_subject', true );
            echo esc_html( $subjects[$val] ?? $val );
            break;
        case 'contact_status':
            $status = get_post_meta( $post_id, '_contact_status', true ) ?: 'new';
            $labels = [ 'new' => '🔵 Mới', 'processing' => '🟡 Đang xử lý', 'completed' => '🟢 Đã xử lý', 'spam' => '🔴 Spam' ];
            echo $labels[$status] ?? $status;
            break;
    }
}
add_action( 'manage_contact_submission_posts_custom_column', 'techpro_contact_admin_column_data', 10, 2 );

// ============================================================
// CONTACT FORM HANDLER (server-side)
// ============================================================
function techpro_handle_contact_form() {
    if ( ! isset( $_POST['techpro_contact_nonce'] ) || ! wp_verify_nonce( $_POST['techpro_contact_nonce'], 'techpro_contact' ) ) {
        return;
    }

    // Honeypot spam check
    if ( ! empty( $_POST['website_url'] ) ) {
        return; // Bot detected
    }

    // Rate limiting — simple check via transient
    $ip = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' );
    $rate_key = 'techpro_contact_' . md5( $ip );
    if ( get_transient( $rate_key ) ) {
        wp_redirect( add_query_arg( 'contact_status', 'rate_limited', wp_get_referer() ?: home_url('/lien-he') ) );
        exit;
    }

    // Validate required fields
    $name    = sanitize_text_field( $_POST['contact_name'] ?? '' );
    $email   = sanitize_email( $_POST['contact_email'] ?? '' );
    $phone   = sanitize_text_field( $_POST['contact_phone'] ?? '' );
    $subject = sanitize_text_field( $_POST['contact_subject'] ?? '' );
    $message = sanitize_textarea_field( $_POST['contact_message'] ?? '' );
    $privacy = isset( $_POST['contact_privacy'] ) ? '1' : '';

    $errors = [];
    if ( empty($name) || mb_strlen($name) < 2 ) $errors[] = 'name';
    if ( empty($email) || ! is_email($email) )   $errors[] = 'email';
    if ( empty($message) || mb_strlen($message) < 10 ) $errors[] = 'message';

    if ( ! empty($errors) ) {
        wp_redirect( add_query_arg( 'contact_status', 'error', wp_get_referer() ?: home_url('/lien-he') ) );
        exit;
    }

    // Create contact submission post
    $post_id = wp_insert_post( [
        'post_type'   => 'contact_submission',
        'post_title'  => sprintf( '[%s] %s — %s', date('d/m/Y H:i'), $name, $email ),
        'post_status' => 'publish',
    ] );

    if ( $post_id && ! is_wp_error($post_id) ) {
        update_post_meta( $post_id, '_contact_name', $name );
        update_post_meta( $post_id, '_contact_email', $email );
        update_post_meta( $post_id, '_contact_phone', $phone );
        update_post_meta( $post_id, '_contact_subject', $subject );
        update_post_meta( $post_id, '_contact_message', $message );
        update_post_meta( $post_id, '_contact_privacy', $privacy );
        update_post_meta( $post_id, '_contact_status', 'new' );
        update_post_meta( $post_id, '_contact_date', current_time('mysql') );
        update_post_meta( $post_id, '_contact_ip', $ip );

        // Rate limit: 1 submission per 60 seconds from same IP
        set_transient( $rate_key, true, 60 );

        wp_redirect( add_query_arg( 'contact_status', 'success', wp_get_referer() ?: home_url('/lien-he') ) );
        exit;
    }

    wp_redirect( add_query_arg( 'contact_status', 'error', wp_get_referer() ?: home_url('/lien-he') ) );
    exit;
}
add_action( 'admin_post_nopriv_techpro_contact', 'techpro_handle_contact_form' );
add_action( 'admin_post_techpro_contact', 'techpro_handle_contact_form' );

// ============================================================
// AJAX: PRODUCT SEARCH & FILTER
// ============================================================
function techpro_ajax_filter_products() {
    check_ajax_referer( 'techpro_nonce', 'nonce' );

    $paged    = absint( $_POST['paged'] ?? 1 );
    $per_page = 9;
    $category = sanitize_text_field( $_POST['category'] ?? '' );
    $search   = sanitize_text_field( $_POST['search'] ?? '' );
    $orderby  = sanitize_text_field( $_POST['orderby'] ?? 'date' );
    $order    = in_array( strtoupper($_POST['order'] ?? ''), ['ASC','DESC'] ) ? strtoupper($_POST['order']) : 'DESC';

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $per_page,
        'paged'          => $paged,
        'post_status'    => 'publish',
    ];

    if ( $category ) {
        $args['tax_query'] = [ [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $category,
        ] ];
    }

    if ( $search ) {
        $args['s'] = $search;
    }

    switch ( $orderby ) {
        case 'title':
            $args['orderby'] = 'title';
            $args['order']   = $order;
            break;
        case 'date':
        default:
            $args['orderby'] = 'date';
            $args['order']   = $order;
            break;
    }

    $query = new WP_Query( $args );
    $html  = '';

    if ( $query->have_posts() ) {
        ob_start();
        while ( $query->have_posts() ) : $query->the_post();
            get_template_part( 'template-parts/product', 'card' );
        endwhile;
        $html = ob_get_clean();
    }

    wp_send_json_success( [
        'html'       => $html,
        'found'      => $query->found_posts,
        'max_pages'  => $query->max_num_pages,
        'paged'      => $paged,
    ] );

    wp_reset_postdata();
    wp_die();
}
add_action( 'wp_ajax_techpro_filter_products', 'techpro_ajax_filter_products' );
add_action( 'wp_ajax_nopriv_techpro_filter_products', 'techpro_ajax_filter_products' );

// ============================================================
// BREADCRUMB HELPER
// ============================================================
function techpro_breadcrumb() {
    if ( is_front_page() ) return;

    echo '<nav class="breadcrumb" aria-label="Breadcrumb"><div class="container">';
    echo '<a href="' . esc_url(home_url('/')) . '">Trang chủ</a>';

    if ( is_singular('product') ) {
        echo ' <span class="sep">›</span> <a href="' . esc_url(home_url('/san-pham')) . '">Sản phẩm</a>';
        $cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
        if ( $cats && ! is_wp_error($cats) ) {
            echo ' <span class="sep">›</span> <a href="' . esc_url(get_term_link($cats[0])) . '">' . esc_html($cats[0]->name) . '</a>';
        }
        echo ' <span class="sep">›</span> <span class="current">' . esc_html(get_the_title()) . '</span>';
    } elseif ( is_singular('post') ) {
        echo ' <span class="sep">›</span> <a href="' . esc_url(home_url('/tin-tuc')) . '">Tin tức</a>';
        echo ' <span class="sep">›</span> <span class="current">' . esc_html(get_the_title()) . '</span>';
    } elseif ( is_tax('product_cat') ) {
        echo ' <span class="sep">›</span> <a href="' . esc_url(home_url('/san-pham')) . '">Sản phẩm</a>';
        echo ' <span class="sep">›</span> <span class="current">' . esc_html(single_term_title('', false)) . '</span>';
    } elseif ( is_post_type_archive('product') ) {
        echo ' <span class="sep">›</span> <span class="current">Sản phẩm</span>';
    } elseif ( is_search() ) {
        echo ' <span class="sep">›</span> <span class="current">Kết quả tìm kiếm</span>';
    } elseif ( is_page() ) {
        echo ' <span class="sep">›</span> <span class="current">' . esc_html(get_the_title()) . '</span>';
    } elseif ( is_category() ) {
        echo ' <span class="sep">›</span> <span class="current">' . esc_html(single_cat_title('', false)) . '</span>';
    } elseif ( is_404() ) {
        echo ' <span class="sep">›</span> <span class="current">Trang không tồn tại</span>';
    }

    echo '</div></nav>';
}

// ============================================================
// CUSTOMIZE LOGIN PAGE
// ============================================================
function techpro_login_style() {
    ?>
    <style>
    body.login { background: #1a1a2e; }
    .login h1 a { width: 100%; background: linear-gradient(135deg, #0066cc, #00d4aa) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; font-size: 2rem !important; }
    .login form { border-top: 3px solid #0066cc; border-radius: 8px; }
    .wp-core-ui .button-primary { background: #0066cc; border-color: #004499; }
    .wp-core-ui .button-primary:hover { background: #004499; }
    </style>
    <?php
}
add_action( 'login_enqueue_scripts', 'techpro_login_style' );

function techpro_login_url() {
    return home_url('/');
}
add_filter( 'login_headerurl', 'techpro_login_url' );

// ============================================================
// SECURITY HARDENING
// ============================================================
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );

// Disable XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// ============================================================
// EXCERPT
// ============================================================
function techpro_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'techpro_excerpt_length', 999 );

function techpro_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'techpro_excerpt_more' );

// ============================================================
// ADMIN ENQUEUE (for media uploader in meta boxes)
// ============================================================
function techpro_admin_scripts( $hook ) {
    if ( in_array($hook, ['post.php', 'post-new.php']) ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'techpro_admin_scripts' );

// ============================================================
// FLUSH REWRITE RULES ON THEME ACTIVATION
// ============================================================
function techpro_rewrite_flush() {
    techpro_register_product_cpt();
    techpro_register_product_taxonomy();
    techpro_register_faq_cpt();
    techpro_register_contact_cpt();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'techpro_rewrite_flush' );

// ============================================================
// ADMIN DASHBOARD WIDGET
// ============================================================
function techpro_dashboard_widget() {
    wp_add_dashboard_widget(
        'techpro_overview',
        '📊 TechPro — Tổng quan',
        'techpro_dashboard_widget_content'
    );
}
add_action( 'wp_dashboard_setup', 'techpro_dashboard_widget' );

function techpro_dashboard_widget_content() {
    $products = wp_count_posts('product');
    $contacts = wp_count_posts('contact_submission');
    $new_contacts = get_posts([
        'post_type'   => 'contact_submission',
        'meta_key'    => '_contact_status',
        'meta_value'  => 'new',
        'numberposts' => -1,
        'fields'      => 'ids',
    ]);
    ?>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div style="background:#f0f4ff;padding:16px;border-radius:8px;text-align:center;">
            <div style="font-size:2rem;font-weight:700;color:#0066cc;"><?php echo intval($products->publish); ?></div>
            <div style="color:#666;font-size:0.9rem;">Sản phẩm</div>
        </div>
        <div style="background:#f0fff4;padding:16px;border-radius:8px;text-align:center;">
            <div style="font-size:2rem;font-weight:700;color:#00d4aa;"><?php echo intval($contacts->publish); ?></div>
            <div style="color:#666;font-size:0.9rem;">Yêu cầu liên hệ</div>
        </div>
    </div>
    <?php if ( count($new_contacts) > 0 ) : ?>
    <p style="margin-top:12px;padding:8px 12px;background:#fff3cd;border-radius:6px;color:#856404;">
        ⚠️ Có <strong><?php echo count($new_contacts); ?></strong> yêu cầu liên hệ mới chờ xử lý.
        <a href="<?php echo admin_url('edit.php?post_type=contact_submission'); ?>">Xem ngay →</a>
    </p>
    <?php endif;
}

// ============================================================
// PRODUCT CATEGORY IMAGE (term meta)
// ============================================================
function techpro_product_cat_add_image_field() {
    ?>
    <div class="form-field">
        <label>Hình ảnh danh mục</label>
        <input type="hidden" name="product_cat_image" id="product_cat_image" value="">
        <div id="product-cat-image-preview" style="margin:5px 0;"></div>
        <button type="button" class="button" id="product-cat-image-btn">Chọn ảnh</button>
        <p class="description">Ảnh đại diện cho danh mục sản phẩm</p>
    </div>
    <script>
    jQuery(function($) {
        var frame;
        $('#product-cat-image-btn').on('click', function(e) {
            e.preventDefault();
            if (frame) { frame.open(); return; }
            frame = wp.media({ title: 'Chọn ảnh danh mục', multiple: false, library: { type: 'image' } });
            frame.on('select', function() {
                var att = frame.state().get('selection').first().toJSON();
                $('#product_cat_image').val(att.id);
                var thumb = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                $('#product-cat-image-preview').html('<img src="'+thumb+'" style="max-width:150px;border-radius:4px;">');
            });
            frame.open();
        });
    });
    </script>
    <?php
}
add_action( 'product_cat_add_form_fields', 'techpro_product_cat_add_image_field' );

function techpro_product_cat_edit_image_field( $term ) {
    $image_id = get_term_meta( $term->term_id, '_category_image', true );
    $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : '';
    ?>
    <tr class="form-field">
        <th><label>Hình ảnh danh mục</label></th>
        <td>
            <input type="hidden" name="product_cat_image" id="product_cat_image" value="<?php echo esc_attr($image_id); ?>">
            <div id="product-cat-image-preview" style="margin:5px 0;">
                <?php if ($image_url) echo '<img src="' . esc_url($image_url) . '" style="max-width:150px;border-radius:4px;">'; ?>
            </div>
            <button type="button" class="button" id="product-cat-image-btn">Chọn ảnh</button>
            <?php if ($image_id) : ?>
                <button type="button" class="button" id="product-cat-image-remove">Xóa ảnh</button>
            <?php endif; ?>
            <script>
            jQuery(function($) {
                var frame;
                $('#product-cat-image-btn').on('click', function(e) {
                    e.preventDefault();
                    if (frame) { frame.open(); return; }
                    frame = wp.media({ title: 'Chọn ảnh danh mục', multiple: false, library: { type: 'image' } });
                    frame.on('select', function() {
                        var att = frame.state().get('selection').first().toJSON();
                        $('#product_cat_image').val(att.id);
                        var thumb = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
                        $('#product-cat-image-preview').html('<img src="'+thumb+'" style="max-width:150px;border-radius:4px;">');
                    });
                    frame.open();
                });
                $('#product-cat-image-remove').on('click', function() {
                    $('#product_cat_image').val('');
                    $('#product-cat-image-preview').html('');
                });
            });
            </script>
        </td>
    </tr>
    <?php
}
add_action( 'product_cat_edit_form_fields', 'techpro_product_cat_edit_image_field' );

function techpro_save_product_cat_image( $term_id ) {
    if ( isset( $_POST['product_cat_image'] ) ) {
        update_term_meta( $term_id, '_category_image', absint( $_POST['product_cat_image'] ) );
    }
}
add_action( 'created_product_cat', 'techpro_save_product_cat_image' );
add_action( 'edited_product_cat', 'techpro_save_product_cat_image' );

// ============================================================
// HELPER: Get contact form status message
// ============================================================
function techpro_get_contact_status_message() {
    if ( ! isset( $_GET['contact_status'] ) ) return '';

    $status = sanitize_text_field( $_GET['contact_status'] );
    switch ( $status ) {
        case 'success':
            return '<div class="form-message form-message--success">
                ✅ <strong>Cảm ơn bạn đã liên hệ!</strong> Chúng tôi đã nhận được yêu cầu và sẽ phản hồi trong thời gian sớm nhất.
            </div>';
        case 'error':
            return '<div class="form-message form-message--error">
                ❌ <strong>Có lỗi xảy ra.</strong> Vui lòng kiểm tra lại thông tin và thử lại. Các trường có dấu (*) là bắt buộc.
            </div>';
        case 'rate_limited':
            return '<div class="form-message form-message--warning">
                ⚠️ <strong>Bạn đã gửi yêu cầu gần đây.</strong> Vui lòng chờ 1 phút trước khi gửi lại.
            </div>';
        default:
            return '';
    }
}
