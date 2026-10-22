<?php
/**
 * Configures WooCommerce pages and activates the Apollo child theme.
 * Run with: docker compose exec wordpress php /tmp/activate-apollo.php
 */

require_once '/var/www/html/wp-load.php';

if ( ! class_exists( 'WooCommerce' ) ) {
	fwrite( STDERR, "WooCommerce must be installed and active first.\n" );
	exit( 1 );
}

function apollo_install_page( $title, $slug, $content = '' ) {
	$existing = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $existing instanceof WP_Post ) {
		return (int) $existing->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'post_status'  => 'publish',
			'post_type'    => 'page',
		),
		true
	);

	if ( is_wp_error( $page_id ) ) {
		fwrite( STDERR, 'Could not create page "' . $title . '": ' . $page_id->get_error_message() . PHP_EOL );
		exit( 1 );
	}

	return (int) $page_id;
}

$shop_id     = apollo_install_page( 'Sản phẩm', 'san-pham' );
$cart_id     = apollo_install_page( 'Giỏ hàng', 'gio-hang', '[woocommerce_cart]' );
$checkout_id = apollo_install_page( 'Thanh toán', 'thanh-toan', '[woocommerce_checkout]' );
$account_id  = apollo_install_page( 'Tài khoản', 'tai-khoan', '[woocommerce_my_account]' );

update_option( 'woocommerce_shop_page_id', $shop_id );
update_option( 'woocommerce_cart_page_id', $cart_id );
update_option( 'woocommerce_checkout_page_id', $checkout_id );
update_option( 'woocommerce_myaccount_page_id', $account_id );
$apollo_page_ids = array( $shop_id, $cart_id, $checkout_id, $account_id );

foreach (
	array(
		'shop'       => 'Shop',
		'cart'       => 'Cart',
		'checkout'   => 'Checkout',
		'my-account' => 'My account',
	) as $slug => $default_title
) {
	$duplicate = get_page_by_path( $slug, OBJECT, 'page' );
	if (
		$duplicate instanceof WP_Post
		&& ! in_array( (int) $duplicate->ID, $apollo_page_ids, true )
		&& $default_title === $duplicate->post_title
	) {
		$result = wp_update_post(
			array(
				'ID'          => $duplicate->ID,
				'post_status' => 'draft',
			),
			true
		);
		if ( is_wp_error( $result ) ) {
			fwrite( STDERR, 'Could not hide duplicate WooCommerce page "' . $slug . '": ' . $result->get_error_message() . PHP_EOL );
			exit( 1 );
		}
	}
}

update_option( 'blogname', 'APOLLO AUTOMOBIL' );
update_option( 'blogdescription', 'Showroom xe Apollo và gian hàng mô hình sưu tầm' );
update_option( 'woocommerce_currency', 'VND' );
update_option( 'woocommerce_price_num_decimals', '0' );
update_option( 'woocommerce_price_thousand_sep', '.' );
update_option( 'woocommerce_price_decimal_sep', ',' );
update_option( 'woocommerce_currency_pos', 'right_space' );
update_option(
	'woocommerce_permalinks',
	array(
		'product_base'  => '/san-pham',
		'category_base' => '/danh-muc-san-pham',
	)
);

switch_theme( 'apollo' );

echo "Apollo child theme activated. Existing TechPro product records were not changed.\n";
echo "WooCommerce pages configured (IDs): shop={$shop_id}, cart={$cart_id}, checkout={$checkout_id}, account={$account_id}.\n";
