<?php
/**
 * WooCommerce product details.
 *
 * @package apollo
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary" class="apollo-single-product apollo-shell">
	<?php do_action( 'woocommerce_before_main_content' ); ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php wc_get_template_part( 'content', 'single-product' ); ?>
	<?php endwhile; ?>
	<?php do_action( 'woocommerce_after_main_content' ); ?>
</main>
<?php get_footer(); ?>
