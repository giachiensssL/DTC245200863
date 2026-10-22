<?php
/**
 * Apollo Automobil child theme.
 *
 * @package apollo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function apollo_theme_setup() {
	load_child_theme_textdomain( 'apollo', get_stylesheet_directory() . '/languages' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menus(
		array(
			'apollo_primary' => __( 'Apollo menu chính', 'apollo' ),
			'apollo_footer'  => __( 'Apollo menu chân trang', 'apollo' ),
		)
	);
}
add_action( 'after_setup_theme', 'apollo_theme_setup', 20 );

function apollo_remove_legacy_product_hooks() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	remove_action( 'init', 'techpro_register_product_cpt' );
	remove_action( 'init', 'techpro_register_product_taxonomy' );
	remove_action( 'add_meta_boxes', 'techpro_add_product_meta_boxes' );
	remove_action( 'save_post_product', 'techpro_save_product_meta' );
	remove_action( 'wp_ajax_techpro_filter_products', 'techpro_ajax_filter_products' );
	remove_action( 'wp_ajax_nopriv_techpro_filter_products', 'techpro_ajax_filter_products' );
	remove_action( 'product_cat_add_form_fields', 'techpro_product_cat_add_image_field' );
	remove_action( 'product_cat_edit_form_fields', 'techpro_product_cat_edit_image_field' );
	remove_action( 'created_product_cat', 'techpro_save_product_cat_image' );
	remove_action( 'edited_product_cat', 'techpro_save_product_cat_image' );
}
add_action( 'after_setup_theme', 'apollo_remove_legacy_product_hooks', 30 );

function apollo_register_vehicle_type() {
	register_post_type(
		'apollo_vehicle',
		array(
			'labels' => array(
				'name'          => __( 'Xe Apollo', 'apollo' ),
				'singular_name' => __( 'Mẫu xe', 'apollo' ),
				'add_new_item'  => __( 'Thêm mẫu xe', 'apollo' ),
				'edit_item'     => __( 'Chỉnh sửa mẫu xe', 'apollo' ),
				'all_items'     => __( 'Bộ sưu tập xe', 'apollo' ),
				'menu_name'     => __( 'Xe Apollo', 'apollo' ),
			),
			'public'       => true,
			'has_archive'  => 'bo-suu-tap',
			'rewrite'      => array(
				'slug'       => 'xe-apollo',
				'with_front' => false,
			),
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-car',
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		)
	);
}
add_action( 'init', 'apollo_register_vehicle_type', 20 );

function apollo_enqueue_assets() {
	wp_dequeue_style( 'techpro-style' );
	wp_dequeue_style( 'google-fonts' );
	wp_dequeue_script( 'techpro-main' );

	// Optimized Google Fonts loading: Inter (400, 500, 600), Montserrat (600, 700, 800), Oswald (600, 700) with Vietnamese subset
	wp_enqueue_style(
		'apollo-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600;700;800&family=Oswald:wght@600;700&display=swap&subset=vietnamese',
		array(),
		null
	);

	wp_enqueue_style(
		'apollo-style',
		get_stylesheet_uri(),
		array(),
		(string) filemtime( get_stylesheet_directory() . '/style.css' )
	);
	wp_enqueue_script(
		'apollo-main',
		get_stylesheet_directory_uri() . '/assets/js/apollo.js',
		array(),
		(string) filemtime( get_stylesheet_directory() . '/style.css' ),
		true
	);
	wp_enqueue_script( 'wc-cart-fragments' );
}
add_action( 'wp_enqueue_scripts', 'apollo_enqueue_assets', 100 );

function apollo_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'apollo_homepage',
		array(
			'title'    => __( 'Apollo Automobil — Trang chủ', 'apollo' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'apollo_announcement',
		array(
			'default'           => __( 'Khám phá bộ sưu tập xe Apollo và mô hình sưu tầm', 'apollo' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'apollo_announcement',
		array(
			'label'   => __( 'Thanh thông báo', 'apollo' ),
			'section' => 'apollo_homepage',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'apollo_hero_image',
		array(
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'apollo_hero_image',
			array(
				'label'       => __( 'Ảnh hero (chỉ dùng ảnh có quyền sử dụng)', 'apollo' ),
				'description' => __( 'Nếu chưa chọn ảnh, trang dùng minh họa vector nguyên bản, không đại diện cho mẫu xe cụ thể.', 'apollo' ),
				'section'     => 'apollo_homepage',
			)
		)
	);
}
add_action( 'customize_register', 'apollo_customize_register' );

function apollo_hide_legacy_techpro_products( $meta_query ) {
	$meta_query[] = array(
		'key'     => '_product_price',
		'compare' => 'NOT EXISTS',
	);
	$meta_query[] = array(
		'key'     => '_price',
		'compare' => 'EXISTS',
	);
	$meta_query[] = array(
		'key'     => '_price',
		'value'   => '',
		'compare' => '!=',
	);

	if ( isset( $_GET['stock_status'] ) && 'instock' === sanitize_key( wp_unslash( $_GET['stock_status'] ) ) ) {
		$meta_query[] = array(
			'key'   => '_stock_status',
			'value' => 'instock',
		);
	}

	return $meta_query;
}
add_filter( 'woocommerce_product_query_meta_query', 'apollo_hide_legacy_techpro_products' );

function apollo_hide_legacy_products_from_rest_queries( $query ) {
	if ( ! defined( 'REST_REQUEST' ) || ! REST_REQUEST || ! in_array( 'product', (array) $query->get( 'post_type' ), true ) ) {
		return;
	}

	$meta_query = apollo_hide_legacy_techpro_products(
		array(
			array(
				'key'     => '_thumbnail_id',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'NUMERIC',
			),
		)
	);

	$query->set(
		'meta_query',
		array(
			'relation' => 'AND',
			(array) $query->get( 'meta_query' ),
			$meta_query,
		)
	);
}
add_action( 'pre_get_posts', 'apollo_hide_legacy_products_from_rest_queries', 10 );

function apollo_hide_legacy_product_visibility( $visible, $product_id ) {
	if (
		metadata_exists( 'post', $product_id, '_product_price' )
		|| ! has_post_thumbnail( $product_id )
		|| '' === get_post_meta( $product_id, '_price', true )
	) {
		return false;
	}

	return $visible;
}
add_filter( 'woocommerce_product_is_visible', 'apollo_hide_legacy_product_visibility', 10, 2 );

function apollo_get_visible_product_categories() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		)
	);

	if ( is_wp_error( $terms ) ) {
		return array();
	}

	$visible_terms = array();
	foreach ( $terms as $term ) {
		$products = wc_get_products(
			array(
				'status'     => 'publish',
				'limit'      => 1,
				'category'   => array( $term->slug ),
				'visibility' => 'visible',
			)
		);

		if ( $products ) {
			$visible_terms[] = $term;
		}
	}

	return $visible_terms;
}

function apollo_hide_legacy_product_pages() {
	$product_id          = get_queried_object_id();
	$is_product_category = function_exists( 'is_product_category' ) && is_product_category();
	$category            = $is_product_category ? get_queried_object() : null;

	if (
		$is_product_category
		&& (
			! $category
			|| is_wp_error( $category )
			|| ! apollo_product_category_is_visible( $category->term_id )
		)
	) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
		return;
	}

	if (
		is_singular( 'product' )
		&& (
			metadata_exists( 'post', $product_id, '_product_price' )
			|| ! has_post_thumbnail( $product_id )
			|| '' === get_post_meta( $product_id, '_price', true )
		)
	) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
	}
}
add_action( 'template_redirect', 'apollo_hide_legacy_product_pages', 1 );

function apollo_hide_legacy_product_rest( $response, $post ) {
	if ( metadata_exists( 'post', $post->ID, '_product_price' ) ) {
		return new WP_REST_Response(
			array(
				'code'    => 'rest_post_invalid_id',
				'message' => __( 'Không tìm thấy sản phẩm.', 'apollo' ),
				'data'    => array( 'status' => 404 ),
			),
			404
		);
	}

	return $response;
}
add_filter( 'rest_prepare_product', 'apollo_hide_legacy_product_rest', 10, 2 );

function apollo_hide_legacy_products_and_categories_from_rest( $result, $server, $request ) {
	$route = $request->get_route();

	if ( preg_match( '#^/wc/store/v1/products/([0-9]+)/?$#', $route, $matches ) && metadata_exists( 'post', (int) $matches[1], '_product_price' ) ) {
		return new WP_REST_Response(
			array(
				'code'    => 'rest_post_invalid_id',
				'message' => __( 'Không tìm thấy sản phẩm.', 'apollo' ),
				'data'    => array( 'status' => 404 ),
			),
			404
		);
	}

	if ( preg_match( '#^/(?:wc/store/v1/products/categories|wp/v2/product_cat)/([0-9]+)/?$#', $route, $matches ) ) {
		$category = get_term( (int) $matches[1], 'product_cat' );
		if ( ! $category || is_wp_error( $category ) || ! apollo_product_category_is_visible( $category->term_id ) ) {
			return new WP_REST_Response(
				array(
					'code'    => 'rest_term_invalid',
					'message' => __( 'Không tìm thấy danh mục.', 'apollo' ),
					'data'    => array( 'status' => 404 ),
				),
				404
			);
		}
	}

	return $result;
}
add_filter( 'rest_pre_dispatch', 'apollo_hide_legacy_products_and_categories_from_rest', 10, 3 );

function apollo_product_category_is_visible( $term_id ) {
	foreach ( apollo_get_visible_product_categories() as $category ) {
		if ( (int) $category->term_id === (int) $term_id ) {
			return true;
		}
	}

	return false;
}

function apollo_filter_legacy_categories_from_rest_collection( $response, $server, $request ) {
	if ( ! in_array( $request->get_route(), array( '/wc/store/v1/products/categories', '/wp/v2/product_cat' ), true ) ) {
		return $response;
	}

	$response = rest_ensure_response( $response );
	if ( ! $response instanceof WP_REST_Response || ! is_array( $response->get_data() ) ) {
		return $response;
	}

	$visible_category_ids = array_map(
		'intval',
		wp_list_pluck( apollo_get_visible_product_categories(), 'term_id' )
	);
	$categories          = array_filter(
		$response->get_data(),
		static function ( $category ) use ( $visible_category_ids ) {
			$category_id = is_array( $category ) ? ( $category['id'] ?? 0 ) : ( $category->id ?? 0 );
			return in_array( (int) $category_id, $visible_category_ids, true );
		}
	);

	$response->set_data( array_values( $categories ) );
	return $response;
}
add_filter( 'rest_post_dispatch', 'apollo_filter_legacy_categories_from_rest_collection', 10, 3 );

function apollo_vnd_price_decimals( $decimals ) {
	return 'VND' === get_woocommerce_currency() ? 0 : $decimals;
}
add_filter( 'wc_get_price_decimals', 'apollo_vnd_price_decimals' );

function apollo_vnd_thousand_separator( $separator ) {
	return 'VND' === get_woocommerce_currency() ? '.' : $separator;
}
add_filter( 'wc_get_price_thousand_separator', 'apollo_vnd_thousand_separator' );

function apollo_vnd_decimal_separator( $separator ) {
	return 'VND' === get_woocommerce_currency() ? ',' : $separator;
}
add_filter( 'wc_get_price_decimal_separator', 'apollo_vnd_decimal_separator' );

function apollo_cart_count_fragment( $fragments ) {
	if ( WC()->cart ) {
		$count = WC()->cart->get_cart_contents_count();
		$fragments['span.apollo-cart-count'] = '<span class="apollo-cart-count">' . esc_html( $count ) . '</span>';
	}

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'apollo_cart_count_fragment' );

function apollo_vehicle_archive_query( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'apollo_vehicle' ) ) {
		$query->set( 'posts_per_page', 12 );
	}
}
add_action( 'pre_get_posts', 'apollo_vehicle_archive_query' );

/**
 * Localize newsletter nonce for JS.
 */
function apollo_localize_newsletter() {
	wp_localize_script(
		'apollo-main',
		'apolloNewsletter',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'apollo_newsletter_nonce' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'apollo_localize_newsletter', 110 );

/**
 * AJAX: Handle newsletter subscription.
 * Sends notification to admin email, does not store personal data beyond the request.
 */
function apollo_newsletter_handler() {
	// Verify nonce.
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'apollo_newsletter_nonce' ) ) {
		wp_send_json_error( array( 'message' => __( 'Yêu cầu không hợp lệ. Vui lòng tải lại trang và thử lại.', 'apollo' ) ) );
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( ! $email || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Địa chỉ email không hợp lệ. Vui lòng kiểm tra lại.', 'apollo' ) ) );
	}

	// Send notification email to admin.
	$admin_email  = get_option( 'admin_email' );
	$site_name    = get_bloginfo( 'name' );
	$subject      = sprintf(
		/* translators: %s: site name */
		__( '[%s] Đăng ký nhận thông tin mới', 'apollo' ),
		$site_name
	);
	$message      = sprintf(
		/* translators: 1: email address, 2: date/time */
		__( "Có một đăng ký nhận thông tin mới từ Apollo Automobil.\n\nEmail: %1\$s\nThời gian: %2\$s\n\nVui lòng xử lý theo quy trình quản lý danh sách liên lạc của bạn.", 'apollo' ),
		$email,
		wp_date( 'd/m/Y H:i', time() )
	);

	$sent = wp_mail( $admin_email, $subject, $message );

	if ( $sent ) {
		wp_send_json_success( array( 'message' => __( 'Đăng ký thành công! Cảm ơn bạn đã quan tâm đến Apollo Automobil.', 'apollo' ) ) );
	} else {
		wp_send_json_error( array( 'message' => __( 'Không thể gửi yêu cầu. Vui lòng thử lại sau hoặc liên hệ trực tiếp với chúng tôi.', 'apollo' ) ) );
	}
}
add_action( 'wp_ajax_apollo_newsletter', 'apollo_newsletter_handler' );
add_action( 'wp_ajax_nopriv_apollo_newsletter', 'apollo_newsletter_handler' );

/**
 * Add trust badges below WooCommerce cart table.
 */
function apollo_cart_trust_badges() {
	?>
	<div class="apollo-trust-badges">
		<div class="apollo-trust-badge">
			<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
			<div class="apollo-trust-badge__text">
				<strong><?php esc_html_e( 'Thanh toán an toàn', 'apollo' ); ?></strong>
				<span><?php esc_html_e( 'Bảo mật thông tin khách hàng', 'apollo' ); ?></span>
			</div>
		</div>
		<div class="apollo-trust-badge">
			<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
			<div class="apollo-trust-badge__text">
				<strong><?php esc_html_e( 'Hỗ trợ 24/7', 'apollo' ); ?></strong>
				<span><?php esc_html_e( 'Tư vấn tận tâm, chuyên nghiệp', 'apollo' ); ?></span>
			</div>
		</div>
		<div class="apollo-trust-badge">
			<svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
			<div class="apollo-trust-badge__text">
				<strong><?php esc_html_e( 'Giao hàng toàn quốc', 'apollo' ); ?></strong>
				<span><?php esc_html_e( 'Theo cấu hình vận chuyển WooCommerce', 'apollo' ); ?></span>
			</div>
		</div>
		<div class="apollo-trust-badge">
			<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
			<div class="apollo-trust-badge__text">
				<strong><?php esc_html_e( 'Đổi trả dễ dàng', 'apollo' ); ?></strong>
				<span><?php esc_html_e( 'Theo chính sách đổi trả đã thiết lập', 'apollo' ); ?></span>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'woocommerce_after_cart_table', 'apollo_cart_trust_badges' );

/**
 * Register customizer social & contact settings.
 */
function apollo_social_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'apollo_social',
		array(
			'title'    => __( 'Apollo — Mạng xã hội & Liên hệ', 'apollo' ),
			'priority' => 32,
		)
	);

	$social_fields = array(
		'apollo_social_facebook'  => __( 'URL Facebook', 'apollo' ),
		'apollo_social_instagram' => __( 'URL Instagram', 'apollo' ),
		'apollo_social_youtube'   => __( 'URL YouTube', 'apollo' ),
		'apollo_contact_address'  => __( 'Địa chỉ', 'apollo' ),
		'apollo_contact_phone'    => __( 'Số điện thoại', 'apollo' ),
		'apollo_contact_email'    => __( 'Email liên hệ (để trống = dùng email admin)', 'apollo' ),
	);

	foreach ( $social_fields as $key => $label ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$key,
			array(
				'label'   => $label,
				'section' => 'apollo_social',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'apollo_social_customizer' );

// Cart page heading handled uniformly in page.php

/**
 * Wrap WooCommerce cart content in shell container.
 */
function apollo_cart_wrapper_open() {
	if ( is_cart() ) {
		echo '<div class="apollo-cart-wrapper apollo-shell">';
	}
}
add_action( 'woocommerce_before_cart', 'apollo_cart_wrapper_open', 15 );

function apollo_cart_wrapper_close() {
	if ( is_cart() ) {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_cart', 'apollo_cart_wrapper_close', 50 );
