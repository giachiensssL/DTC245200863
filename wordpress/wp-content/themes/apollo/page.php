<?php
/**
 * Generic page template for Apollo and WooCommerce shortcode pages.
 *
 * @package apollo
 */

get_header();
?>
<main id="primary">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<section class="apollo-page-heading">
			<div class="apollo-shell">
				<?php if ( function_exists( 'woocommerce_breadcrumb' ) && ( is_cart() || is_checkout() || is_account_page() ) ) : ?>
					<?php woocommerce_breadcrumb(); ?>
				<?php else : ?>
					<span class="apollo-eyebrow"><?php esc_html_e( 'APOLLO AUTOMOBIL', 'apollo' ); ?></span>
				<?php endif; ?>
				<h1><?php the_title(); ?></h1>
			</div>
		</section>
		<section class="apollo-section">
			<div class="apollo-shell apollo-page-content">
				<div class="entry-content"><?php the_content(); ?></div>
			</div>
		</section>
	<?php endwhile; ?>
</main>
<?php
get_footer();
