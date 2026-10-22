<?php
/**
 * TechPro Theme Functions
 * Student ID: DTC245200863
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Theme Setup
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
        'primary' => __( 'Primary Menu', 'techpro' ),
        'footer'  => __( 'Footer Menu', 'techpro' ),
    ] );
}
add_action( 'after_setup_theme', 'techpro_setup' );

// Enqueue styles
function techpro_scripts() {
    wp_enqueue_style( 'techpro-style', get_stylesheet_uri(), [], '1.0.0' );
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', [], null );
    wp_enqueue_script( 'techpro-main', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'techpro_scripts' );

// Widget areas
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

// Custom post type: Products
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
        'menu_name'          => 'Sản phẩm',
    ];
    register_post_type( 'product', [
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'san-pham' ],
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'menu_icon'     => 'dashicons-products',
        'show_in_rest'  => true,
    ] );
}
add_action( 'init', 'techpro_register_product_cpt' );

// Taxonomy: Product Category
function techpro_register_product_taxonomy() {
    register_taxonomy( 'product_cat', 'product', [
        'labels'       => [
            'name'          => 'Danh mục sản phẩm',
            'singular_name' => 'Danh mục',
            'add_new_item'  => 'Thêm danh mục mới',
            'edit_item'     => 'Chỉnh sửa danh mục',
            'menu_name'     => 'Danh mục',
        ],
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => [ 'slug' => 'danh-muc' ],
        'show_in_rest'  => true,
    ] );
}
add_action( 'init', 'techpro_register_product_taxonomy' );

// Custom meta boxes for product
function techpro_add_product_meta_boxes() {
    add_meta_box(
        'techpro_product_details',
        'Chi tiết sản phẩm',
        'techpro_product_details_callback',
        'product',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'techpro_add_product_meta_boxes' );

function techpro_product_details_callback( $post ) {
    wp_nonce_field( 'techpro_product_nonce', 'techpro_product_nonce' );
    $price      = get_post_meta( $post->ID, '_product_price', true );
    $old_price  = get_post_meta( $post->ID, '_product_old_price', true );
    $features   = get_post_meta( $post->ID, '_product_features', true );
    $badge      = get_post_meta( $post->ID, '_product_badge', true );
    $specs      = get_post_meta( $post->ID, '_product_specs', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="product_price">Giá hiện tại (VND)</label></th>
            <td><input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>" class="regular-text" placeholder="ví dụ: 12.990.000"></td>
        </tr>
        <tr>
            <th><label for="product_old_price">Giá gốc (VND)</label></th>
            <td><input type="text" id="product_old_price" name="product_old_price" value="<?php echo esc_attr($old_price); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="product_badge">Nhãn (badge)</label></th>
            <td><input type="text" id="product_badge" name="product_badge" value="<?php echo esc_attr($badge); ?>" class="regular-text" placeholder="ví dụ: Mới, Hot, Sale"></td>
        </tr>
        <tr>
            <th><label for="product_features">Tính năng nổi bật</label></th>
            <td><textarea id="product_features" name="product_features" rows="4" class="large-text"><?php echo esc_textarea($features); ?></textarea><p class="description">Mỗi tính năng một dòng</p></td>
        </tr>
        <tr>
            <th><label for="product_specs">Thông số kỹ thuật</label></th>
            <td><textarea id="product_specs" name="product_specs" rows="4" class="large-text"><?php echo esc_textarea($specs); ?></textarea><p class="description">Mỗi thông số một dòng (Tên: Giá trị)</p></td>
        </tr>
    </table>
    <?php
}

function techpro_save_product_meta( $post_id ) {
    if ( ! isset( $_POST['techpro_product_nonce'] ) || ! wp_verify_nonce( $_POST['techpro_product_nonce'], 'techpro_product_nonce' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = [ 'product_price', 'product_old_price', 'product_badge', 'product_features', 'product_specs' ];
    foreach ( $fields as $field ) {
        if ( isset( $_POST[$field] ) ) {
            update_post_meta( $post_id, '_' . $field, sanitize_textarea_field( $_POST[$field] ) );
        }
    }
}
add_action( 'save_post_product', 'techpro_save_product_meta' );

// Customize login page
function techpro_login_style() {
    ?>
    <style>
    body.login { background: #1a1a2e; }
    .login h1 a { width: 100%; background: linear-gradient(135deg, #0066cc, #00d4aa) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; }
    .login form { border-top: 3px solid #0066cc; }
    .wp-core-ui .button-primary { background: #0066cc; border-color: #004499; }
    .wp-core-ui .button-primary:hover { background: #004499; }
    </style>
    <?php
}
add_action( 'login_enqueue_scripts', 'techpro_login_style' );

// Security: remove WordPress version from head
remove_action( 'wp_head', 'wp_generator' );

// Excerpt length
function techpro_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'techpro_excerpt_length', 999 );
