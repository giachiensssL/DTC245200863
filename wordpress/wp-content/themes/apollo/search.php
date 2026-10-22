<?php
/**
 * Product search uses the same filters and product loop as the shop archive.
 *
 * @package apollo
 */

if ( 'product' === get_query_var( 'post_type' ) && function_exists( 'woocommerce_product_loop' ) ) {
	include get_stylesheet_directory() . '/archive-product.php';
	return;
}

get_header();
?>
<main id="primary">
	<section class="apollo-page-heading">
		<div class="apollo-shell">
			<span class="apollo-eyebrow"><?php esc_html_e( 'Tìm kiếm', 'apollo' ); ?></span>
			<h1><?php echo esc_html( sprintf( __( 'Kết quả cho: %s', 'apollo' ), get_search_query() ) ); ?></h1>
		</div>
	</section>
	<section class="apollo-search-results apollo-shell">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="entry-summary"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
			<div class="apollo-pagination"><?php the_posts_pagination(); ?></div>
		<?php else : ?>
			<p><?php esc_html_e( 'Không tìm thấy nội dung phù hợp.', 'apollo' ); ?></p>
		<?php endif; ?>
	</section>
</main>
<?php get_footer(); ?>
