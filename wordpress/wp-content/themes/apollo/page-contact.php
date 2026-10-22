<?php
/**
 * Template Name: Liên hệ Apollo
 *
 * @package apollo
 */

get_header();
$contact_address = get_theme_mod( 'apollo_contact_address', '119 Nguyễn Đức Cảnh, Q.7, TP.HCM' );
$contact_phone   = get_theme_mod( 'apollo_contact_phone', '0941 234 567' );
$contact_email   = get_theme_mod( 'apollo_contact_email', '' );
$contact_email   = $contact_email ? $contact_email : get_option( 'admin_email' );
?>
<main id="primary">
	<section class="apollo-page-heading">
		<div class="apollo-shell">
			<span class="apollo-eyebrow"><?php esc_html_e( 'APOLLO AUTOMOBIL', 'apollo' ); ?></span>
			<h1><?php the_title(); ?></h1>
			<p><?php esc_html_e( 'Gửi yêu cầu tư vấn về xe Apollo hoặc sản phẩm sưu tầm.', 'apollo' ); ?></p>
		</div>
	</section>
	<section class="apollo-section">
		<div class="apollo-shell apollo-contact-layout">
			<div>
				<span class="apollo-eyebrow"><?php esc_html_e( 'Liên hệ tư vấn', 'apollo' ); ?></span>
				<h2><?php esc_html_e( 'Chúng tôi sẵn sàng lắng nghe', 'apollo' ); ?></h2>
				<div class="entry-content">
					<?php if ( trim( wp_strip_all_tags( get_the_content() ) ) ) : ?>
						<?php the_content(); ?>
					<?php else : ?>
						<p><?php esc_html_e( 'Gửi thông tin qua biểu mẫu. Nội dung sẽ giúp chúng tôi hiểu yêu cầu tư vấn của bạn.', 'apollo' ); ?></p>
					<?php endif; ?>
				</div>
				<div class="apollo-contact-details">
					<h3><?php esc_html_e( 'Thông tin liên hệ', 'apollo' ); ?></h3>
					<?php if ( $contact_address ) : ?>
						<p><span><?php esc_html_e( 'ĐỊA CHỈ', 'apollo' ); ?></span><?php echo esc_html( $contact_address ); ?></p>
					<?php endif; ?>
					<?php if ( $contact_phone ) : ?>
						<p><span><?php esc_html_e( 'ĐIỆN THOẠI', 'apollo' ); ?></span><a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $contact_phone ) ); ?>"><?php echo esc_html( $contact_phone ); ?></a></p>
					<?php endif; ?>
					<?php if ( $contact_email ) : ?>
						<p><span><?php esc_html_e( 'EMAIL', 'apollo' ); ?></span><a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a></p>
					<?php endif; ?>
				</div>
			</div>
			<div>
				<?php
				if ( function_exists( 'techpro_get_contact_status_message' ) ) {
					echo wp_kses_post( techpro_get_contact_status_message() );
				}
				?>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="techpro_contact">
					<?php wp_nonce_field( 'techpro_contact', 'techpro_contact_nonce' ); ?>
					<div class="apollo-screen-reader" aria-hidden="true">
						<label for="apollo-contact-website"><?php esc_html_e( 'Không điền trường này', 'apollo' ); ?></label>
						<input id="apollo-contact-website" name="website_url" type="text" tabindex="-1" autocomplete="off">
					</div>
					<div class="form-field">
						<label for="apollo-contact-name"><?php esc_html_e( 'Họ và tên', 'apollo' ); ?> *</label>
						<input id="apollo-contact-name" name="contact_name" type="text" minlength="2" maxlength="100" autocomplete="name" required>
					</div>
					<div class="form-field">
						<label for="apollo-contact-email"><?php esc_html_e( 'Email', 'apollo' ); ?> *</label>
						<input id="apollo-contact-email" name="contact_email" type="email" autocomplete="email" required>
					</div>
					<div class="form-field">
						<label for="apollo-contact-phone"><?php esc_html_e( 'Số điện thoại', 'apollo' ); ?></label>
						<input id="apollo-contact-phone" name="contact_phone" type="tel" autocomplete="tel">
					</div>
					<div class="form-field">
						<label for="apollo-contact-message"><?php esc_html_e( 'Nội dung cần tư vấn', 'apollo' ); ?> *</label>
						<textarea id="apollo-contact-message" name="contact_message" minlength="10" maxlength="2000" required><?php echo isset( $_GET['mau-xe'] ) ? esc_textarea( sprintf( __( 'Tôi muốn tìm hiểu về mẫu xe: %s', 'apollo' ), sanitize_text_field( wp_unslash( $_GET['mau-xe'] ) ) ) ) : ''; ?></textarea>
					</div>
					<div class="form-field">
						<label>
							<input name="contact_privacy" type="checkbox" value="1">
							<?php esc_html_e( 'Tôi đồng ý để website lưu yêu cầu liên hệ nhằm phản hồi nội dung tư vấn.', 'apollo' ); ?>
						</label>
						<?php if ( get_privacy_policy_url() ) : ?>
							<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Xem chính sách bảo mật', 'apollo' ); ?></a>
						<?php endif; ?>
					</div>
					<button class="apollo-button" type="submit"><?php esc_html_e( 'Gửi yêu cầu', 'apollo' ); ?></button>
				</form>
			</div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
