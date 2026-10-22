<?php
/**
 * Initializes the local TechPro demo site before WooCommerce/Apollo setup.
 *
 * Run inside the WordPress container:
 * docker compose exec -T wordpress php < scripts/initialize-wordpress.php
 */

require '/var/www/html/wp-load.php';

if ( ! is_blog_installed() ) {
    fwrite( STDERR, "WordPress is not installed; finish the initial installation first.\n" );
    exit( 1 );
}

if ( 'apollo' === get_option( 'stylesheet' ) || class_exists( 'WooCommerce' ) ) {
    fwrite( STDERR, "This TechPro demo initializer must run before WooCommerce is installed and Apollo is activated; it would overwrite site settings.\n" );
    exit( 1 );
}

if ( ! wp_get_theme( 'techpro' )->exists() ) {
    fwrite( STDERR, "The TechPro theme was not found in wp-content/themes/techpro.\n" );
    exit( 1 );
}

switch_theme( 'techpro' );
update_option( 'blogname', 'TechPro | Thiết bị công nghệ' );
update_option( 'blogdescription', 'Khám phá thiết bị công nghệ chất lượng cho cuộc sống hiện đại.' );

$pages = [
    'trang-chu' => [
        'title'    => 'Trang chủ',
        'template' => 'index.php',
    ],
    'danh-muc' => [
        'title'    => 'Danh mục sản phẩm',
        'template' => 'page-categories.php',
    ],
    've-chung-toi' => [
        'title'    => 'Về chúng tôi',
        'template' => 'page-about.php',
    ],
    'lien-he' => [
        'title'    => 'Liên hệ',
        'template' => 'page-contact.php',
    ],
];

$page_ids = [];
foreach ( $pages as $slug => $page ) {
    $existing = get_page_by_path( $slug, OBJECT, 'page' );
    $post_data = [
        'ID'             => $existing ? $existing->ID : 0,
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'post_title'     => $page['title'],
        'post_name'      => $slug,
        'post_content'   => '',
        'comment_status' => 'closed',
    ];
    $page_id = wp_insert_post( $post_data, true );
    if ( is_wp_error( $page_id ) ) {
        fwrite( STDERR, "Could not create page {$slug}: " . $page_id->get_error_message() . "\n" );
        exit( 1 );
    }
    update_post_meta( $page_id, '_wp_page_template', $page['template'] );
    update_post_meta( $page_id, '_techpro_demo_page', '1' );
    $page_ids[ $slug ] = $page_id;
}

$products_page = get_page_by_path( 'san-pham', OBJECT, 'page' );
if (
    $products_page
    && 'Sản phẩm' === $products_page->post_title
    && 'page-products.php' === get_post_meta( $products_page->ID, '_wp_page_template', true )
) {
    wp_delete_post( $products_page->ID, true );
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $page_ids['trang-chu'] );
update_option( 'page_for_posts', 0 );
update_option( 'permalink_structure', '/%postname%/' );

$categories = [
    'laptop' => [ 'Laptop', 'Laptop học tập, văn phòng và gaming hiệu năng cao.' ],
    'man-hinh' => [ 'Màn hình', 'Màn hình sắc nét cho công việc sáng tạo và giải trí.' ],
    'phu-kien' => [ 'Phụ kiện', 'Phụ kiện thiết yếu cho góc làm việc hiện đại.' ],
    'am-thanh' => [ 'Âm thanh', 'Tai nghe và thiết bị âm thanh cho mọi trải nghiệm.' ],
];

$category_ids = [];
foreach ( $categories as $slug => [ $name, $description ] ) {
    $term = term_exists( $slug, 'product_cat' );
    if ( ! $term ) {
        $term = wp_insert_term( $name, 'product_cat', [
            'slug'        => $slug,
            'description' => $description,
        ] );
    } elseif ( ! is_wp_error( $term ) ) {
        wp_update_term( (int) ( is_array( $term ) ? $term['term_id'] : $term ), 'product_cat', [
            'name'        => $name,
            'description' => $description,
        ] );
    }
    if ( is_wp_error( $term ) ) {
        fwrite( STDERR, "Could not create category {$slug}: " . $term->get_error_message() . "\n" );
        exit( 1 );
    }
    $category_ids[ $slug ] = (int) ( is_array( $term ) ? $term['term_id'] : $term );
}

$products = [
    [
        'slug' => 'techpro-blade-gaming-15',
        'name' => 'TechPro Blade Gaming 15',
        'category' => 'laptop',
        'price' => '28.990.000',
        'old_price' => '31.490.000',
        'sku' => 'TP-LT-001',
        'image' => 'blade-gaming.svg',
        'badge' => 'Bán chạy',
        'features' => "CPU Intel Core i7 thế hệ mới\nRAM 16GB DDR5, SSD 1TB\nMàn hình 15.6 inch 165Hz",
        'specs' => "CPU: Intel Core i7\nRAM: 16GB DDR5\nLưu trữ: SSD 1TB\nMàn hình: 15.6 inch, 165Hz",
        'excerpt' => 'Laptop gaming hiệu năng cao, màn hình 165Hz mượt mà và thiết kế tản nhiệt tối ưu.',
        'content' => '<p>TechPro Blade Gaming 15 cân bằng hiệu năng và tính di động cho game thủ, nhà sáng tạo nội dung. Màn hình tần số quét cao, bộ nhớ tốc độ nhanh và hệ thống tản nhiệt nhiều vùng giúp máy luôn sẵn sàng cho những phiên làm việc dài.</p>',
    ],
    [
        'slug' => 'techpro-airbook-14',
        'name' => 'TechPro AirBook 14',
        'category' => 'laptop',
        'price' => '19.490.000',
        'old_price' => '21.990.000',
        'sku' => 'TP-LT-002',
        'image' => 'airbook-14.svg',
        'badge' => 'Mới',
        'features' => "Trọng lượng chỉ 1,25 kg\nMàn hình 14 inch độ phân giải cao\nPin sử dụng cả ngày",
        'specs' => "CPU: Intel Core Ultra 5\nRAM: 16GB\nLưu trữ: SSD 512GB\nTrọng lượng: 1,25 kg",
        'excerpt' => 'Laptop mỏng nhẹ cho học tập và công việc linh hoạt, pin bền bỉ cả ngày.',
        'content' => '<p>AirBook 14 sở hữu thiết kế nhôm thanh lịch, màn hình sắc nét và thời lượng pin dài. Đây là lựa chọn gọn nhẹ cho người thường xuyên di chuyển giữa lớp học, văn phòng và những chuyến công tác.</p>',
    ],
    [
        'slug' => 'techpro-studio-display-27',
        'name' => 'TechPro Studio Display 27',
        'category' => 'man-hinh',
        'price' => '11.990.000',
        'old_price' => '13.490.000',
        'sku' => 'TP-MH-001',
        'image' => 'studio-display.svg',
        'badge' => 'Đề xuất',
        'features' => "Tấm nền IPS 27 inch QHD\nĐộ phủ màu rộng, màu sắc chính xác\nChân đế điều chỉnh linh hoạt",
        'specs' => "Kích thước: 27 inch\nĐộ phân giải: 2560 x 1440\nTấm nền: IPS\nTần số quét: 100Hz",
        'excerpt' => 'Màn hình QHD rộng rãi, màu sắc chuẩn xác dành cho thiết kế và đa nhiệm.',
        'content' => '<p>Studio Display 27 mang lại không gian làm việc rộng rãi với độ phân giải QHD, tấm nền IPS và khả năng tái tạo màu sắc trung thực. Chân đế công thái học hỗ trợ điều chỉnh tư thế làm việc thoải mái.</p>',
    ],
    [
        'slug' => 'techpro-mechanical-keyboard-k87',
        'name' => 'TechPro Mechanical K87',
        'category' => 'phu-kien',
        'price' => '1.690.000',
        'old_price' => '1.990.000',
        'sku' => 'TP-PK-001',
        'image' => 'mechanical-k87.svg',
        'badge' => 'Mới',
        'features' => "Layout gọn 87 phím\nSwitch cơ thay nóng\nĐèn nền RGB tùy chỉnh",
        'specs' => "Layout: TKL 87 phím\nKết nối: USB-C\nSwitch: Linear cơ học\nĐèn nền: RGB",
        'excerpt' => 'Bàn phím cơ TKL gọn gàng, gõ êm và có thể tùy biến switch theo sở thích.',
        'content' => '<p>Mechanical K87 tối ưu không gian bàn làm việc nhưng vẫn giữ đủ các phím chức năng cần thiết. Kết nối USB-C ổn định, switch thay nóng và hệ thống đèn RGB giúp cá nhân hóa góc máy dễ dàng.</p>',
    ],
    [
        'slug' => 'techpro-silent-mouse-m5',
        'name' => 'TechPro Silent Mouse M5',
        'category' => 'phu-kien',
        'price' => '790.000',
        'old_price' => '990.000',
        'sku' => 'TP-PK-002',
        'image' => 'silent-mouse.svg',
        'badge' => '',
        'features' => "Kết nối Bluetooth và USB receiver\nClick yên tĩnh\nPin sạc dùng nhiều tuần",
        'specs' => "Kết nối: Bluetooth 5.2, 2.4GHz\nĐộ phân giải: 800–3200 DPI\nPin: Sạc USB-C\nTrọng lượng: 92 g",
        'excerpt' => 'Chuột không dây yên tĩnh, chính xác và thoải mái cho cả ngày làm việc.',
        'content' => '<p>Silent Mouse M5 có thiết kế công thái học vừa tay, cảm biến chính xác và nút bấm giảm tiếng ồn. Chuyển đổi linh hoạt giữa Bluetooth và đầu thu USB giúp kết nối nhanh với nhiều thiết bị.</p>',
    ],
    [
        'slug' => 'techpro-anc-headphones-h9',
        'name' => 'TechPro ANC Headphones H9',
        'category' => 'am-thanh',
        'price' => '3.490.000',
        'old_price' => '3.990.000',
        'sku' => 'TP-AT-001',
        'image' => 'anc-headphones.svg',
        'badge' => 'Bán chạy',
        'features' => "Chống ồn chủ động nhiều mức\nÂm thanh Hi-Res sống động\nThời lượng pin đến 40 giờ",
        'specs' => "Kết nối: Bluetooth 5.3\nChống ồn: ANC chủ động\nThời lượng pin: Tối đa 40 giờ\nSạc: USB-C",
        'excerpt' => 'Tai nghe chụp tai chống ồn chủ động, pin dài và âm thanh chi tiết.',
        'content' => '<p>ANC Headphones H9 tạo không gian nghe riêng tư với khả năng chống ồn chủ động và đệm tai mềm mại. Pin dài, sạc nhanh USB-C và kết nối Bluetooth ổn định phù hợp cho công việc lẫn giải trí.</p>',
    ],
    [
        'slug' => 'techpro-portable-ssd-1tb',
        'name' => 'TechPro Portable SSD 1TB',
        'category' => 'phu-kien',
        'price' => '2.290.000',
        'old_price' => '2.690.000',
        'sku' => 'TP-PK-003',
        'image' => 'portable-ssd.svg',
        'badge' => '',
        'features' => "Dung lượng lưu trữ 1TB\nKết nối USB-C tốc độ cao\nVỏ chống va đập nhỏ gọn",
        'specs' => "Dung lượng: 1TB\nKết nối: USB-C 3.2 Gen 2\nTốc độ đọc: Tối đa 1.000 MB/s\nTương thích: Windows, macOS",
        'excerpt' => 'Ổ SSD di động 1TB gọn nhẹ, truyền dữ liệu nhanh và an toàn khi di chuyển.',
        'content' => '<p>Portable SSD 1TB mở rộng không gian lưu trữ cho laptop, máy tính bảng và điện thoại hỗ trợ USB-C. Thiết kế bền bỉ, nhỏ gọn và tốc độ truyền tải cao giúp sao lưu dữ liệu thuận tiện.</p>',
    ],
    [
        'slug' => 'techpro-usb-c-dock-8in1',
        'name' => 'TechPro USB-C Dock 8-in-1',
        'category' => 'phu-kien',
        'price' => '1.290.000',
        'old_price' => '1.590.000',
        'sku' => 'TP-PK-004',
        'image' => 'usb-c-dock.svg',
        'badge' => 'Ưu đãi',
        'features' => "Mở rộng 8 cổng kết nối\nXuất hình ảnh 4K HDMI\nVỏ nhôm tản nhiệt tốt",
        'specs' => "Cổng: HDMI 4K, USB-A, USB-C, SD, Ethernet\nNguồn: USB-C PD 100W\nVật liệu: Hợp kim nhôm\nTương thích: Laptop USB-C",
        'excerpt' => 'Hub USB-C đa cổng giúp kết nối màn hình, mạng dây và thiết bị ngoại vi.',
        'content' => '<p>USB-C Dock 8-in-1 biến một cổng kết nối thành trung tâm làm việc tiện dụng. Sản phẩm hỗ trợ xuất hình ảnh 4K, đọc thẻ nhớ và truyền dữ liệu, phù hợp với laptop hiện đại.</p>',
    ],
];

foreach ( $products as $product ) {
    $existing = get_page_by_path( $product['slug'], OBJECT, 'product' );
    $product_id = wp_insert_post( [
        'ID'             => $existing ? $existing->ID : 0,
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'post_title'     => $product['name'],
        'post_name'      => $product['slug'],
        'post_excerpt'   => $product['excerpt'],
        'post_content'   => $product['content'],
        'comment_status' => 'closed',
    ], true );
    if ( is_wp_error( $product_id ) ) {
        fwrite( STDERR, "Could not create product {$product['slug']}: " . $product_id->get_error_message() . "\n" );
        exit( 1 );
    }

    wp_set_object_terms( $product_id, [ $category_ids[ $product['category'] ] ], 'product_cat' );
    update_post_meta( $product_id, '_product_price', $product['price'] );
    update_post_meta( $product_id, '_product_old_price', $product['old_price'] );
    update_post_meta( $product_id, '_product_sku', $product['sku'] );
    update_post_meta( $product_id, '_product_stock_status', 'instock' );
    update_post_meta( $product_id, '_product_image', $product['image'] );
    update_post_meta( $product_id, '_product_badge', $product['badge'] );
    update_post_meta( $product_id, '_product_features', $product['features'] );
    update_post_meta( $product_id, '_product_specs', $product['specs'] );
    update_post_meta( $product_id, '_product_featured', '1' );
}

$hello_world = get_page_by_path( 'chao-moi-nguoi', OBJECT, 'post' );
if ( $hello_world && 'Chào tất cả mọi người!' === $hello_world->post_title ) {
    wp_delete_post( $hello_world->ID, true );
}

$menu_name = 'TechPro Main Navigation';
$menu = wp_get_nav_menu_object( $menu_name );
if ( ! $menu ) {
    $menu_id = wp_create_nav_menu( $menu_name );
    if ( is_wp_error( $menu_id ) ) {
        fwrite( STDERR, "Could not create navigation menu: " . $menu_id->get_error_message() . "\n" );
        exit( 1 );
    }
} else {
    $menu_id = (int) $menu->term_id;
    foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $item ) {
        wp_delete_post( $item->ID, true );
    }
}

$menu_items = [
    [ 'Trang chủ', 'page', $page_ids['trang-chu'] ],
    [ 'Sản phẩm', 'custom', home_url( '/san-pham/' ) ],
    [ 'Danh mục', 'page', $page_ids['danh-muc'] ],
    [ 'Về chúng tôi', 'page', $page_ids['ve-chung-toi'] ],
    [ 'Liên hệ', 'page', $page_ids['lien-he'] ],
];
foreach ( $menu_items as $position => [ $label, $type, $target ] ) {
    $item_id = wp_update_nav_menu_item( $menu_id, 0, [
        'menu-item-title'     => $label,
        'menu-item-object'    => $type,
        'menu-item-object-id' => 'page' === $type ? $target : 0,
        'menu-item-type'      => 'page' === $type ? 'post_type' : 'custom',
        'menu-item-url'       => 'custom' === $type ? $target : '',
        'menu-item-status'    => 'publish',
        'menu-item-position'  => $position + 1,
    ] );
    if ( is_wp_error( $item_id ) ) {
        fwrite( STDERR, "Could not add menu item {$label}: " . $item_id->get_error_message() . "\n" );
        exit( 1 );
    }
}
$locations = (array) get_theme_mod( 'nav_menu_locations', [] );
$locations['primary'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );

flush_rewrite_rules( false );
echo 'TechPro initialized: ' . count( $page_ids ) . ' pages, ' . count( $products ) . ' products, ' . count( $categories ) . " categories.\n";
