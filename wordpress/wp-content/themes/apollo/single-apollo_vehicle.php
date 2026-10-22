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
		<?php
		$vehicle_slug = get_post_field( 'post_name', get_the_ID() );
		$related_products = array(
			'porsche-911-gt3-rs'          => 'mo-hinh-porsche-911-gt3-rs',
			'ferrari-sf90-stradale'       => 'mo-hinh-ferrari-sf90',
			'lamborghini-aventador-svj'   => 'mo-hinh-lamborghini-aventador-svj',
		);
		$vehicle_fallbacks = array(
			'bugatti-chiron'       => 'a2.webp',
			'mclaren-765lt'        => 'a1.webp',
			'porsche-911-gt3-rs'   => 'a2.webp',
			'ferrari-sf90-stradale'=> 'a1.webp',
			'lamborghini-aventador-svj' => 'a12.webp',
		);
		$related_product = isset( $related_products[ $vehicle_slug ] )
			? get_page_by_path( $related_products[ $vehicle_slug ], OBJECT, 'product' )
			: null;
		$vehicle_image_id = has_post_thumbnail()
			? get_post_thumbnail_id()
			: ( $related_product ? get_post_thumbnail_id( $related_product->ID ) : 0 );
		$vehicle_specs = get_post_meta( get_the_ID(), '_apollo_specs', true );
		if ( ! $vehicle_specs ) {
			$vehicle_specs = get_the_excerpt();
		}
		?>
		<article <?php post_class( 'apollo-editorial' ); ?>>
			<div class="apollo-editorial__art">
				<?php if ( $vehicle_image_id ) : ?>
					<?php echo wp_get_attachment_image( $vehicle_image_id, 'large', false, array( 'loading' => 'eager', 'alt' => esc_attr( get_the_title() ) ) ); ?>
				<?php else : ?>
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . ( $vehicle_fallbacks[ $vehicle_slug ] ?? 'a6.webp' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="eager">
				<?php endif; ?>
			</div>
			<div class="apollo-editorial__copy">
				<span class="apollo-eyebrow"><?php esc_html_e( 'Xe Apollo', 'apollo' ); ?></span>
				<h1><?php the_title(); ?></h1>
				<?php if ( $vehicle_specs ) : ?>
					<div class="apollo-vehicle-detail__specs">
						<span><?php esc_html_e( 'THÔNG TIN MẪU XE', 'apollo' ); ?></span>
						<p><?php echo esc_html( $vehicle_specs ); ?></p>
					</div>
				<?php endif; ?>
				<div class="entry-content"><?php the_content(); ?></div>
				<a class="apollo-button" href="<?php echo esc_url( add_query_arg( 'mau-xe', get_the_title(), home_url( '/lien-he/' ) ) ); ?>"><?php esc_html_e( 'Đăng ký tư vấn', 'apollo' ); ?></a>
			</div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
