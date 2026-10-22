<?php
/**
 * Apollo site header.
 *
 * @package apollo
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'apollo-site' ); ?>>
<?php wp_body_open(); ?>
<div class="apollo-announcement"><?php echo esc_html( get_theme_mod( 'apollo_announcement', 'Khám phá bộ sưu tập xe Apollo và mô hình sưu tầm' ) ); ?></div>
<header class="apollo-header">
	<div class="apollo-header__inner">
		<a class="apollo-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Apollo Automobil — Trang chủ', 'apollo' ); ?>">
			<svg class="apollo-brand__mark" viewBox="0 0 40 44" aria-hidden="true" focusable="false">
				<path d="M20 3 37 39H3L20 3Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
				<path d="m20 16 9 19H11l9-19Z" fill="none" stroke="currentColor" stroke-width="1.2"/>
				<path d="M16 31h8" stroke="currentColor" stroke-width="1.2"/>
			</svg>
			<span class="apollo-brand__wordmark">APOLLO<small>AUTOMOBIL</small></span>
		</a>

		<nav class="apollo-nav" id="apollo-navigation" aria-label="<?php esc_attr_e( 'Điều hướng chính', 'apollo' ); ?>">
			<?php if ( has_nav_menu( 'apollo_primary' ) ) : ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'apollo_primary',
						'container'      => false,
						'menu_class'     => 'apollo-nav__list',
						'depth'          => 1,
					)
				);
				?>
			<?php else : ?>
				<ul class="apollo-nav__list">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Trang chủ', 'apollo' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'apollo_vehicle' ) ); ?>"><?php esc_html_e( 'Bộ sưu tập xe', 'apollo' ); ?></a></li>
					<li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Sản phẩm', 'apollo' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/danh-muc/' ) ); ?>"><?php esc_html_e( 'Danh mục', 'apollo' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/ve-chung-toi/' ) ); ?>"><?php esc_html_e( 'Về Apollo', 'apollo' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>"><?php esc_html_e( 'Liên hệ', 'apollo' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</nav>

		<div class="apollo-header__tools">
			<button class="apollo-icon-link apollo-search-toggle" type="button" aria-label="<?php esc_attr_e( 'Mở tìm kiếm sản phẩm', 'apollo' ); ?>" aria-expanded="false" aria-controls="apollo-search-panel">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.5"/><path d="m16 16 4.5 4.5"/></svg>
			</button>
			<a class="apollo-icon-link apollo-account-link" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" aria-label="<?php esc_attr_e( 'Tài khoản', 'apollo' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c.7-3.2 3.1-5 7-5s6.3 1.8 7 5"/></svg>
			</a>
			<a class="apollo-icon-link apollo-cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php esc_attr_e( 'Giỏ hàng', 'apollo' ); ?>">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M3 4h2l2.2 11.3a2 2 0 0 0 2 1.7h8.4a2 2 0 0 0 2-1.6L21 8H6"/><circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
				<span class="apollo-cart-count"><?php echo esc_html( WC()->cart ? WC()->cart->get_cart_contents_count() : 0 ); ?></span>
			</a>
			<button class="apollo-menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Mở menu', 'apollo' ); ?>" aria-controls="apollo-navigation" aria-expanded="false">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
	<form class="apollo-header-search" id="apollo-search-panel" role="search" method="get" action="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" hidden>
		<label class="apollo-screen-reader" for="apollo-header-search-input"><?php esc_html_e( 'Tìm kiếm sản phẩm', 'apollo' ); ?></label>
		<input id="apollo-header-search-input" type="search" name="s" placeholder="<?php esc_attr_e( 'Tìm kiếm sản phẩm Apollo…', 'apollo' ); ?>">
		<input type="hidden" name="post_type" value="product">
		<button class="apollo-button" type="submit"><?php esc_html_e( 'Tìm kiếm', 'apollo' ); ?></button>
	</form>
</header>
