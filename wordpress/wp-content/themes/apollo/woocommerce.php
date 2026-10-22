<?php
/**
 * WooCommerce wrapper for cart, checkout, and account pages.
 *
 * @package apollo
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary" class="apollo-catalog apollo-shell">
	<?php woocommerce_content(); ?>
</main>
<?php get_footer(); ?>
