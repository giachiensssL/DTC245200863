<?php
/**
 * Apollo vehicle details. Cars are inquiry items, not checkout products.
 *
 * @package apollo
 */

get_header();
?>
<main id="primary" class="apollo-catalog apollo-shell">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'apollo-editorial' ); ?>>
			<div class="apollo-editorial__art">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large' ); ?>
				<?php else : ?>
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/apollo-detail.svg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
				<?php endif; ?>
			</div>
			<div class="apollo-editorial__copy">
				<span class="apollo-eyebrow"><?php esc_html_e( 'Xe Apollo', 'apollo' ); ?></span>
				<h1><?php the_title(); ?></h1>
				<div class="entry-content"><?php the_content(); ?></div>
				<a class="apollo-button" href="<?php echo esc_url( add_query_arg( 'mau-xe', get_the_title(), home_url( '/lien-he/' ) ) ); ?>"><?php esc_html_e( 'Đăng ký tư vấn', 'apollo' ); ?></a>
			</div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
