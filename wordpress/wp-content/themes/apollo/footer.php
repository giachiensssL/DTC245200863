<?php
/**
 * Apollo Automobil — Site Footer
 * 4-column layout: Brand + Social | Navigation | Policy | Contact
 *
 * @package apollo
 */
?>
<footer class="apollo-footer">
	<div class="apollo-shell">
		<div class="apollo-footer-grid">

			<!-- Column 1: Brand -->
			<div class="apollo-footer-col apollo-footer-col--brand">
				<a class="apollo-brand apollo-brand--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<svg class="apollo-brand__mark" viewBox="0 0 40 44" aria-hidden="true" focusable="false">
						<path d="M20 3 37 39H3L20 3Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
						<path d="m20 16 9 19H11l9-19Z" fill="none" stroke="currentColor" stroke-width="1.2"/>
						<path d="M16 31h8" stroke="currentColor" stroke-width="1.2"/>
					</svg>
					<span class="apollo-brand__wordmark">APOLLO<small>AUTOMOBIL</small></span>
				</a>
				<p class="apollo-footer-brand-desc">
					<?php esc_html_e( 'Không gian giới thiệu xe Apollo và các sản phẩm mô hình sưu tầm cao cấp. Nội dung sản phẩm chỉ được cập nhật từ dữ liệu đã xác minh.', 'apollo' ); ?>
				</p>
				<div class="apollo-footer-social">
					<?php
					$fb  = get_theme_mod( 'apollo_social_facebook', '' );
					$ig  = get_theme_mod( 'apollo_social_instagram', '' );
					$yt  = get_theme_mod( 'apollo_social_youtube', '' );
					?>
					<?php if ( $fb ) : ?>
					<a href="<?php echo esc_url( $fb ); ?>" class="apollo-footer-social__btn" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
						<svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
					</a>
					<?php endif; ?>
					<?php if ( $ig ) : ?>
					<a href="<?php echo esc_url( $ig ); ?>" class="apollo-footer-social__btn" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
						<svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
					</a>
					<?php endif; ?>
					<?php if ( $yt ) : ?>
					<a href="<?php echo esc_url( $yt ); ?>" class="apollo-footer-social__btn" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
						<svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.6.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.94 1.96C5.12 20 12 20 12 20s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#000"/></svg>
					</a>
					<?php endif; ?>
					<?php if ( ! $fb && ! $ig && ! $yt ) : ?>
					<span class="apollo-footer-social__placeholder"><?php esc_html_e( 'Cấu hình mạng xã hội trong Appearance → Customize', 'apollo' ); ?></span>
					<?php endif; ?>
				</div>
			</div>

			<!-- Column 2: Navigation -->
			<div class="apollo-footer-col">
				<h4 class="apollo-footer-col__title"><?php esc_html_e( 'Điều hướng', 'apollo' ); ?></h4>
				<nav aria-label="<?php esc_attr_e( 'Menu chân trang', 'apollo' ); ?>">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Trang chủ', 'apollo' ); ?></a>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'apollo_vehicle' ) ); ?>"><?php esc_html_e( 'Siêu xe', 'apollo' ); ?></a>
					<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/san-pham/' ) ); ?>"><?php esc_html_e( 'Sản phẩm', 'apollo' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/bo-suu-tap/' ) ); ?>"><?php esc_html_e( 'Bộ sưu tập', 'apollo' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/ve-chung-toi/' ) ); ?>"><?php esc_html_e( 'Về Apollo', 'apollo' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>"><?php esc_html_e( 'Liên hệ', 'apollo' ); ?></a>
				</nav>
			</div>

			<!-- Column 3: Policy -->
			<div class="apollo-footer-col">
				<h4 class="apollo-footer-col__title"><?php esc_html_e( 'Chính sách', 'apollo' ); ?></h4>
				<nav aria-label="<?php esc_attr_e( 'Chính sách', 'apollo' ); ?>">
					<a href="<?php echo esc_url( home_url( '/chinh-sach-mua-hang/' ) ); ?>"><?php esc_html_e( 'Chính sách mua hàng', 'apollo' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/chinh-sach-van-chuyen/' ) ); ?>"><?php esc_html_e( 'Vận chuyển', 'apollo' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/chinh-sach-doi-tra/' ) ); ?>"><?php esc_html_e( 'Đổi trả &amp; Hoàn tiền', 'apollo' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/chinh-sach-bao-mat/' ) ); ?>"><?php esc_html_e( 'Bảo mật thông tin', 'apollo' ); ?></a>
					<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Tài khoản của tôi', 'apollo' ); ?></a>
					<?php endif; ?>
				</nav>
			</div>

			<!-- Column 4: Contact -->
			<div class="apollo-footer-col">
				<h4 class="apollo-footer-col__title"><?php esc_html_e( 'Liên hệ', 'apollo' ); ?></h4>
				<?php $address = get_theme_mod( 'apollo_contact_address', '119 Nguyễn Đức Cảnh, Q.7, TP.HCM' ); ?>
				<?php if ( $address ) : ?>
				<span class="apollo-footer-contact-row">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
					<?php echo esc_html( $address ); ?>
				</span>
				<?php endif; ?>

				<?php $phone = get_theme_mod( 'apollo_contact_phone', '0941 234 567' ); ?>
				<?php if ( $phone ) : ?>
				<a class="apollo-footer-contact-row" href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.26h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.93a16 16 0 0 0 6.14 6.14l.93-.93a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
					<?php echo esc_html( $phone ); ?>
				</a>
				<?php endif; ?>

				<?php
				$contact_email = get_theme_mod( 'apollo_contact_email', '' );
				$display_email = $contact_email ? $contact_email : get_option( 'admin_email' );
				?>
				<a class="apollo-footer-contact-row" href="mailto:<?php echo esc_attr( $display_email ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
					<?php echo esc_html( $display_email ); ?>
				</a>
			</div>

		</div><!-- .apollo-footer-grid -->

		<div class="apollo-footer-bottom">
			<span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> APOLLO AUTOMOBIL. <?php esc_html_e( 'Tất cả quyền được bảo lưu.', 'apollo' ); ?></span>
			<span><?php esc_html_e( 'Website demo theo yêu cầu học thuật — không đại diện cho thương hiệu chính hãng.', 'apollo' ); ?></span>
		</div>
	</div><!-- .apollo-shell -->
</footer>
<?php wp_footer(); ?>
</body>
</html>
